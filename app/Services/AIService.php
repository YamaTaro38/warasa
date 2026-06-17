<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $pollinationsUrl;
    protected $maxRetries = 2;

    public function __construct()
    {
        $this->pollinationsUrl = 'https://text.pollinations.ai/';
    }

    // ==================== MULTI-KEY GEMINI ====================
    protected function getAvailableGeminiKey()
    {
        $key = ApiKey::active('gemini')->first();
        return $key ? $key->key : null;
    }

    protected function markKeyAsLimited($apiKey)
    {
        $keyModel = ApiKey::where('key', $apiKey)->first();
        if ($keyModel) {
            $keyModel->markAsLimited();
            Log::warning("Gemini API key marked as limited: " . substr($apiKey, 0, 10) . "...");
        }
    }

    public function checkGeminiKeyLimit($apiKey)
    {
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";
            $response = Http::timeout(10)->get($url);
            if ($response->successful()) return true;
            if (in_array($response->status(), [429, 403])) return false;
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkAllGeminiKeys()
    {
        $keys = ApiKey::where('provider', 'gemini')->get();
        foreach ($keys as $keyModel) {
            $isActive = $this->checkGeminiKeyLimit($keyModel->key);
            if (!$isActive) {
                $keyModel->markAsLimited();
            } elseif ($keyModel->status === 'limited') {
                $keyModel->markAsActive();
                Log::info("Gemini key reactivated: " . substr($keyModel->key, 0, 10));
            }
        }
    }

    protected function callGemini($prompt, $timeout, $minLength = 10)
    {
        $activeKeys = ApiKey::active('gemini')->orderBy('priority', 'desc')->get();
        if ($activeKeys->isEmpty()) return null;

        foreach ($activeKeys as $keyModel) {
            $apiKey = $keyModel->key;
            for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
                try {
                    $model = 'gemini-2.5-flash';
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                    
                    $response = Http::timeout($timeout)->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['temperature' => 0.8, 'maxOutputTokens' => 4096]
                    ]);
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                        if ($content && strlen(trim($content)) >= $minLength) {
                            Log::info("Gemini response from key: " . substr($apiKey, 0, 10));
                            return $content;
                        }
                    } else {
                        $status = $response->status();
                        Log::warning("Gemini attempt failed: HTTP {$status}");
                        if (in_array($status, [429, 403])) {
                            $this->markKeyAsLimited($apiKey);
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning("Gemini exception: " . $e->getMessage());
                }
                if ($attempt < $this->maxRetries) sleep(1);
            }
        }
        return null;
    }

    protected function callPollinations($prompt, $timeout, $minLength = 10)
    {
        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                $url = $this->pollinationsUrl . urlencode($prompt);
                $response = Http::timeout($timeout)
                    ->withOptions(['allow_redirects' => true, 'verify' => false])
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'])
                    ->get($url);
                    
                if ($response->successful()) {
                    $content = $response->body();
                    if (!empty($content) && strlen(trim($content)) >= $minLength) {
                        Log::info("Pollinations response");
                        return $content;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Pollinations attempt failed: " . $e->getMessage());
            }
            if ($attempt < $this->maxRetries) sleep(1);
        }
        return null;
    }

    protected function callAI($prompt, $timeout = 60, $minLength = 10)
    {
        $result = $this->callGemini($prompt, $timeout, $minLength);
        if ($result) return $result;
        
        $result = $this->callPollinations($prompt, $timeout, $minLength);
        if ($result) return $result;
        
        Log::error("All AI providers failed for prompt: " . substr($prompt, 0, 100));
        return null;
    }

    // ==================== FORMAT HTML ====================
    public function formatMarkdownToHtml($text)
    {
        if (empty($text)) return $text;
        
        $text = preg_replace('/--- Support.*?---/s', '', $text);
        $text = preg_replace('/Powered by.*?Pollinations.*/s', '', $text);
        $text = preg_replace('/Like what.*?$/m', '', $text);
        $text = preg_replace('/\*{3,}/', '', $text);
        
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*([^*\n]+)\*/', '<strong>$1</strong>', $text);
        
        $text = preg_replace('/^#{1,3}\s+(.+)$/m', '<strong>$1:</strong>', $text);
        
        $lines = explode("\n", $text);
        $processed = [];
        foreach ($lines as $line) {
            $t = trim($line);
            if (empty($t)) continue;
            if (preg_match('/^[\*\-•]\s/', $t)) {
                $content = preg_replace('/^[\*\-•]\s+/', '', $t);
                $content = preg_replace('/\*(.+?)\*/', '<strong>$1</strong>', $content);
                $processed[] = '<li>' . $content . '</li>';
            } else {
                $t = preg_replace('/\*(.+?)\*/', '<strong>$1</strong>', $t);
                $processed[] = $t;
            }
        }
        
        $result = '';
        $inList = false;
        foreach ($processed as $line) {
            if (preg_match('/^<li>/', $line)) {
                if (!$inList) { $result .= '<ul>'; $inList = true; }
                $result .= $line;
            } else {
                if ($inList) { $result .= '</ul>'; $inList = false; }
                if (preg_match('/^<strong>.+?<\/strong>\s*:?$/i', $line)) {
                    $result .= '<br>' . $line . '<br>';
                } else {
                    $result .= '<p>' . $line . '</p>';
                }
            }
        }
        if ($inList) $result .= '</ul>';
        
        $result = preg_replace('/<p>\s*<\/p>/', '', $result);
        $result = preg_replace('/<br>\s*<\/ul>/', '</ul>', $result);
        $result = preg_replace('/\s+/', ' ', $result);
        $result = str_replace('> <', '><', $result);
        
        return trim($result);
    }

    // ==================== GENERATE PRODUK ====================
    public function generateProductTitle($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Buat 1 judul SEO untuk produk \"{$productName}\" yang benar-benar dijual di Indonesia.{$info}
Gunakan data REAL dari produk yang ada di Shopee. Judul harus mengandung spesifikasi nyata produk ini, panjang 40-80 karakter, relevan dan mengandung kata kunci pencarian. Output hanya 1 judul.";
        
        $response = $this->callAI($prompt, 30, 10);
        if ($response) {
            $title = trim($response);
            $title = preg_replace('/[^\w\s\-\.\,\/]/u', '', $title);
            $title = preg_replace('/\s+/', ' ', $title);
            if (strlen($title) > 25 && strlen($title) < 100) return $title;
        }
        return null;
    }

    public function generateProductDescription($productName, $additionalInfo = null, $category = null)
    {
        $catName = $category ? $category->name : 'Produk';
        $extra = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        
        $prompt = "Cari produk {$productName} di Shopee Indonesia (kategori: {$catName}). {$extra}
Berdasarkan data real dari produk best seller, buat DESKRIPSI PRODUK yang PROFESIONAL dengan format berikut:

{$productName}
[Paragraf pembuka: 2 kalimat tentang keunggulan utama produk]

Detail Produk:
• [Tulis poin detail produk dari data real seperti bahan, ukuran, rasa, isi, atau berat]
• [Poin detail kedua]

Keunggulan:
• [Tulis 3-4 keunggulan berdasarkan data real atau review positif pembeli]

Informasi Tambahan:
• [Sesuaikan dengan kategori]

ATURAN:
- Bahasa Indonesia yang profesional dan mudah dipahami.
- Jujur berdasarkan data real, JANGAN berhalusinasi.
- Gunakan *teks* untuk menebalkan kata kunci penting.
Output langsung deskripsinya tanpa basa-basi pengantar.";
        
        $response = $this->callAI($prompt, 70, 80);
        if ($response && strlen($response) > 150) {
            try {
                $html = $this->formatMarkdownToHtml($response);
                if (strlen($html) > 80) return $html;
            } catch (\Exception $e) {
                Log::warning("Format error: " . $e->getMessage());
            }
        }
        return null;
    }

    public function recommendPrice($productName, $additionalInfo = null)
    {
        $prompt = "Berapa HARGA PASARAN yang wajar untuk produk REAL \"{$productName}\" di Indonesia saat ini? Berdasarkan data harga di Shopee/Tokopedia, berikan hanya angka Rupiah tanpa titik/koma/spasi. Contoh: 75000. Output hanya ANGKA.";
        
        $response = $this->callAI($prompt, 30, 1);
        if ($response) {
            $clean = preg_replace('/[^0-9]/', '', $response);
            if (!empty($clean)) {
                $num = (int) $clean;
                if ($num >= 1000 && $num <= 100000000) return $num;
            }
            preg_match_all('/\d+/', $response, $m);
            foreach (($m[0] ?? []) as $n) {
                $n = (int) $n;
                if ($n >= 1000 && $n <= 100000000) return $n;
            }
        }
        return 0;
    }

    public function generateKeywords($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Info: {$additionalInfo}" : '';
        $prompt = "Hasilkan 10 kata kunci untuk produk REAL \"{$productName}\" yang benar-benar sering dicari pembeli di Shopee dan Google Indonesia.{$info} Format: pisahkan dengan koma. Output hanya kata kunci.";
        
        $response = $this->callAI($prompt, 30, 10);
        if ($response && strlen($response) > 20) {
            $kw = array_map('trim', explode(',', $response));
            $kw = array_filter($kw, fn($k) => strlen($k) > 2);
            $result = implode(', ', array_slice($kw, 0, 10));
            if (strlen($result) > 10) return $result;
        }
        return null;
    }

    // ==================== REKOMENDASI KATEGORI DINAMIS ====================
    public function recommendCategoryName($productName, $additionalInfo = null)
    {
        // Ambil maksimal 30 kategori yang paling relevan dari database untuk menghindari prompt terlalu panjang
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(30)
            ->get(['name', 'description']);
        
        if ($categories->isEmpty()) return null;

        $categoryList = $categories->map(function($cat) {
            $desc = $cat->description ? " - {$cat->description}" : '';
            return "- {$cat->name}{$desc}";
        })->implode("\n");

        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        
        $prompt = "Tentukan 1 kategori yang PALING TEPAT untuk produk \"{$productName}\" yang dijual di Indonesia.{$info}

Pilih dari daftar kategori berikut:
{$categoryList}

Output HANYA nama kategori persis seperti yang ada di daftar, TANPA teks lain.";
        
        $response = $this->callAI($prompt, 20, 3);
        if ($response) {
            $categoryName = trim(preg_replace('/[^a-zA-Z\s&\-\/]/', '', $response));
            
            foreach ($categories as $cat) {
                if (strcasecmp(trim($categoryName), trim($cat->name)) === 0) {
                    return $cat->name;
                }
            }
            
            // Fuzzy match
            $bestMatch = null;
            $bestScore = 0;
            foreach ($categories as $cat) {
                similar_text(strtolower($categoryName), strtolower($cat->name), $percent);
                if ($percent > $bestScore) {
                    $bestScore = $percent;
                    $bestMatch = $cat->name;
                }
            }
            
            if ($bestScore > 60 && $bestMatch) {
                return $bestMatch;
            }
        }
        
        return null;
    }

    public function findCategoryIdFromDatabase($productName, $additionalInfo = null)
    {
        $categories = ProductCategory::where('is_active', true)->limit(30)->get(['id', 'name']);
        
        if ($categories->isEmpty()) return null;

        $categoryList = $categories->map(function($cat) {
            return "- {$cat->name} (ID: {$cat->id})";
        })->implode("\n");

        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        
        $prompt = "Produk: \"{$productName}\" yang dijual di Indonesia.{$info}

Pilih kategori yang PALING TEPAT dari daftar berikut:
{$categoryList}

Output HANYA angka ID kategori (contoh: 5). Tanpa teks lain.";
        
        $response = $this->callAI($prompt, 20, 1);
        if ($response) {
            preg_match('/\d+/', $response, $m);
            $id = (int) ($m[0] ?? 0);
            if ($id > 0 && $categories->contains('id', $id)) {
                return $id;
            }
        }
        
        return null;
    }

    public function recommendBrand($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Untuk produk \"{$productName}\" yang dijual di Indonesia.{$info}
Berikan 1 nama merek yang paling mungkin. Jika tidak ada merek spesifik, output 'Umum'.
Output hanya nama merek, tanpa kata lain.";
        
        $response = $this->callAI($prompt, 30, 2);
        if ($response && strlen($response) < 50) {
            return trim($response);
        }
        return null;
    }

    public function recommendWeight($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Perkirakan berat (dalam gram) untuk produk \"{$productName}\" yang dijual di Indonesia.{$info}
Output hanya angka (gram), tanpa satuan. Contoh: 250";
        
        $response = $this->callAI($prompt, 30, 1);
        if ($response) {
            $weight = (int) preg_replace('/[^0-9]/', '', $response);
            if ($weight > 0 && $weight < 10000) return $weight;
        }
        return 250;
    }

    public function recommendDimension($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Untuk produk \"{$productName}\" yang dijual di Indonesia.{$info}
Berikan dimensi kemasan dalam format: panjang x lebar x tinggi (dalam cm). Contoh: 30x20x5.
Output hanya format tersebut.";
        
        $response = $this->callAI($prompt, 30, 5);
        if ($response && preg_match('/\d+\s*[xX]\s*\d+\s*[xX]\s*\d+/', $response, $matches)) {
            $dim = preg_replace('/\s/', '', $matches[0]);
            return $dim;
        }
        return null;
    }

    // ==================== ANALISIS KOMPETITOR ====================

    public function analyzeCompetitor($csvData)
    {
        if (empty($csvData) || !is_array($csvData)) {
            return null;
        }

        $products = is_array($csvData) && isset($csvData[0]) ? $csvData : [$csvData];
        $prices = [];
        $soldCounts = [];
        $locations = [];
        $nameWords = [];
        $specKeys = [];

        foreach ($products as $p) {
            if (isset($p['harga']) && is_numeric($p['harga']) && $p['harga'] > 0) {
                $prices[] = (float) $p['harga'];
            }
            if (isset($p['terjual'])) {
                $sold = (int) preg_replace('/[^0-9]/', '', $p['terjual']);
                if ($sold > 0) $soldCounts[] = $sold;
            }
            if (!empty($p['lokasi_toko'])) $locations[] = $p['lokasi_toko'];
            if (!empty($p['nama_produk'])) {
                $words = preg_split('/[\s\-\,\.\(\)\/]+/u', strtolower($p['nama_produk']));
                foreach ($words as $w) {
                    if (strlen($w) > 3 && !in_array($w, ['untuk', 'dengan', 'yang', 'dan', 'dari', 'pada', 'dalam'])) {
                        $nameWords[] = $w;
                    }
                }
            }
            if (!empty($p['spesifikasi']) && is_array($p['spesifikasi'])) {
                foreach (array_keys($p['spesifikasi']) as $k) $specKeys[] = strtolower($k);
            }
        }

        $priceStats = null;
        if (!empty($prices)) {
            sort($prices);
            $priceStats = [
                'count'    => count($prices),
                'min'      => (int) min($prices),
                'max'      => (int) max($prices),
                'avg'      => (int) (array_sum($prices) / count($prices)),
                'median'   => (int) ($prices[(int) floor(count($prices) / 2)] ?? 0),
                'p25'      => (int) ($prices[(int) floor(count($prices) * 0.25)] ?? 0),
                'p75'      => (int) ($prices[(int) floor(count($prices) * 0.75)] ?? 0),
            ];
        }

        $wordFreq = array_count_values($nameWords);
        arsort($wordFreq);
        $topKeywords = array_slice(array_keys($wordFreq), 0, 10);

        $specFreq = array_count_values($specKeys);
        arsort($specFreq);
        $topSpecs = array_slice(array_keys($specFreq), 0, 5);

        return [
            'total_products'    => count($products),
            'price_stats'       => $priceStats,
            'top_keywords'      => $topKeywords,
            'top_specs'         => $topSpecs,
            'top_locations'     => array_slice(array_count_values($locations), 0, 5, true),
            'avg_sold'          => !empty($soldCounts) ? (int) (array_sum($soldCounts) / count($soldCounts)) : 0,
        ];
    }

    public function generateCompetitorBasedTitle($productName, $competitorAnalysis, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $topKw = !empty($competitorAnalysis['top_keywords']) ? implode(', ', array_slice($competitorAnalysis['top_keywords'], 0, 8)) : '-';
        $topSpecs = !empty($competitorAnalysis['top_specs']) ? implode(', ', $competitorAnalysis['top_specs']) : '-';

        $prompt = "Kamu adalah ahli SEO marketplace Indonesia. Buat 1 judul SEO untuk produk \"{$productName}\" yang akan dijual di Shopee/Tokopedia.{$info}

DATA KOMPETITOR (dari riset):
- Kata kunci teratas yang dipakai kompetitor: {$topKw}
- Spesifikasi yang sering muncul: {$topSpecs}

ATURAN JUDUL:
- Panjang 40-100 karakter
- Mengandung 3-5 kata kunci dari kompetitor + 1-2 kata pembeda (kualitas/premium/original/terlaris)
- Menyebut spesifikasi utama (kapasitas, ukuran, warna, dll)
- Bahasa Indonesia natural & menarik untuk pembeli
- Output hanya 1 judul, tanpa kutip, tanpa penjelasan.";

        $response = $this->callAI($prompt, 40, 15);
        if ($response) {
            $title = trim($response);
            $title = preg_replace('/^["\'"\']+|["\'"\']+$/u', '', $title);
            $title = preg_replace('/\s+/', ' ', $title);
            if (strlen($title) >= 25 && strlen($title) <= 120) return $title;
        }
        return null;
    }

    public function generateCompetitorBasedDescription($productName, $competitorAnalysis, $additionalInfo = null, $category = null)
    {
        $catName = $category ? $category->name : 'Produk';
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $topKw = !empty($competitorAnalysis['top_keywords']) ? implode(', ', array_slice($competitorAnalysis['top_keywords'], 0, 12)) : '-';

        $prompt = "Kamu adalah copywriter e-commerce Indonesia. Buat DESKRIPSI PRODUK yang LEBIH BAIK dari kompetitor untuk produk \"{$productName}\" (kategori: {$catName}).{$info}

REFERENSI KOMPETITOR:
- Kata kunci yang sering dipakai: {$topKw}

STRUKTUR DESKRIPSI:
{$productName}
[Paragraf pembuka 2-3 kalimat - highlight keunggulan utama & kenapa harus beli di sini]

Detail Produk:
• [Spesifikasi utama - bahan/ukuran/kapasitas/dll]
• [Spesifikasi kedua]
• [Spesifikasi ketiga]

Keunggulan:
• [Keunggulan 1 - berbeda dari kompetitor]
• [Keunggulan 2]
• [Keunggulan 3]
• [Keunggulan 4]

Cocok Untuk:
• [Target pengguna]
• [Situasi penggunaan]

ATURAN:
- Bahasa Indonesia profesional & natural
- Gunakan *teks* untuk menebalkan kata penting
- Fokus pada VALUE & BENEFIT, bukan cuma fitur
- Panjang 400-700 kata
- Output langsung deskripsinya tanpa pengantar.";

        $response = $this->callAI($prompt, 80, 200);
        if ($response && strlen($response) > 200) {
            try {
                $html = $this->formatMarkdownToHtml($response);
                if (strlen(strip_tags($html)) > 150) return $html;
            } catch (\Exception $e) {
                Log::warning("Format error: " . $e->getMessage());
            }
        }
        return null;
    }

    public function recommendCompetitivePrice($productName, $competitorAnalysis, $additionalInfo = null)
    {
        if (empty($competitorAnalysis['price_stats'])) {
            return $this->recommendPrice($productName, $additionalInfo);
        }

        $stats = $competitorAnalysis['price_stats'];
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Untuk produk \"{$productName}\" di marketplace Indonesia{$info}, dari data kompetitor:
- Harga minimum: Rp " . number_format($stats['min']) . "
- Harga rata-rata: Rp " . number_format($stats['avg']) . "
- Harga median: Rp " . number_format($stats['median']) . "
- Harga maksimum: Rp " . number_format($stats['max']) . "

Berikan 1 rekomendasi HARGA JUAL yang kompetitif (sedikit di bawah rata-rata untuk attract buyer, tapi tetap profitable). Output hanya ANGGA saja (tanpa Rp/titik/koma).";

        $response = $this->callAI($prompt, 30, 1);
        if ($response) {
            $num = (int) preg_replace('/[^0-9]/', '', $response);
            if ($num >= 1000 && $num <= 100000000) return $num;
        }
        return (int) ($stats['median'] * 0.9);
    }

    public function generateCompetitorKeywords($productName, $competitorAnalysis, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Info: {$additionalInfo}" : '';
        $existingKw = !empty($competitorAnalysis['top_keywords']) ? implode(', ', $competitorAnalysis['top_keywords']) : '-';

        $prompt = "Untuk produk \"{$productName}\" di Indonesia{$info}, berdasarkan kata kunci yang dipakai kompetitor ({$existingKw}), hasilkan 12 kata kunci SEO terbaik yang akan membuat produk ini RANKING #1 di Shopee dan Google Indonesia. Format pisahkan dengan koma. Output hanya kata kunci.";

        $response = $this->callAI($prompt, 30, 15);
        if ($response && strlen($response) > 20) {
            $kw = array_map('trim', explode(',', $response));
            $kw = array_filter($kw, fn($k) => strlen($k) > 2);
            $result = implode(', ', array_slice($kw, 0, 12));
            if (strlen($result) > 10) return $result;
        }
        return null;
    }

    public function calculateSeoScore($data)
    {
        $score = 0;
        $details = [];

        $title = $data['title'] ?? '';
        $titleLen = mb_strlen($title);
        if ($titleLen >= 40 && $titleLen <= 100) {
            $score += 30;
            $details['title'] = ['score' => 30, 'msg' => 'Panjang judul optimal (' . $titleLen . ' karakter)'];
        } elseif ($titleLen >= 25 && $titleLen <= 120) {
            $score += 20;
            $details['title'] = ['score' => 20, 'msg' => 'Panjang judul cukup (' . $titleLen . ' karakter, ideal 40-100)'];
        } else {
            $score += 5;
            $details['title'] = ['score' => 5, 'msg' => 'Panjang judul kurang optimal (' . $titleLen . ' karakter)'];
        }

        $desc = strip_tags($data['description'] ?? '');
        $descLen = mb_strlen($desc);
        if ($descLen >= 400 && $descLen <= 2000) {
            $score += 30;
            $details['description'] = ['score' => 30, 'msg' => 'Panjang deskripsi optimal (' . $descLen . ' karakter)'];
        } elseif ($descLen >= 200 && $descLen <= 3000) {
            $score += 20;
            $details['description'] = ['score' => 20, 'msg' => 'Panjang deskripsi cukup (' . $descLen . ' karakter)'];
        } else {
            $score += 5;
            $details['description'] = ['score' => 5, 'msg' => 'Panjang deskripsi kurang optimal (' . $descLen . ' karakter)'];
        }

        $keywords = $data['keywords'] ?? '';
        $kwArray = array_filter(array_map('trim', explode(',', $keywords)));
        $kwCount = count($kwArray);
        if ($kwCount >= 8 && $kwCount <= 15) {
            $score += 20;
            $details['keywords'] = ['score' => 20, 'msg' => 'Jumlah keyword optimal (' . $kwCount . ' keyword)'];
        } elseif ($kwCount >= 4 && $kwCount <= 20) {
            $score += 12;
            $details['keywords'] = ['score' => 12, 'msg' => 'Jumlah keyword cukup (' . $kwCount . ' keyword)'];
        } else {
            $score += 4;
            $details['keywords'] = ['score' => 4, 'msg' => 'Jumlah keyword kurang (' . $kwCount . ' keyword, ideal 8-15)'];
        }

        if (!empty($data['brand'])) {
            $score += 5;
            $details['brand'] = ['score' => 5, 'msg' => 'Brand terisi'];
        } else {
            $details['brand'] = ['score' => 0, 'msg' => 'Brand belum terisi'];
        }

        if (!empty($data['category_id'])) {
            $score += 5;
            $details['category'] = ['score' => 5, 'msg' => 'Kategori terisi'];
        } else {
            $details['category'] = ['score' => 0, 'msg' => 'Kategori belum terisi'];
        }

        $hasVariations = !empty($data['variations']);
        $hasPrice = !empty($data['price']) && $data['price'] > 0;
        if ($hasPrice && $hasVariations) {
            $score += 5;
            $details['price_variation'] = ['score' => 5, 'msg' => 'Harga & variasi terisi'];
        } elseif ($hasPrice || $hasVariations) {
            $score += 3;
            $details['price_variation'] = ['score' => 3, 'msg' => 'Harga atau variasi terisi'];
        } else {
            $details['price_variation'] = ['score' => 0, 'msg' => 'Harga & variasi belum terisi'];
        }

        $imgCount = is_array($data['images'] ?? null) ? count($data['images']) : 0;
        if ($imgCount >= 3) {
            $score += 5;
            $details['images'] = ['score' => 5, 'msg' => $imgCount . ' gambar (optimal)'];
        } elseif ($imgCount >= 1) {
            $score += 3;
            $details['images'] = ['score' => 3, 'msg' => $imgCount . ' gambar (minimal 1)'];
        } else {
            $details['images'] = ['score' => 0, 'msg' => 'Belum ada gambar'];
        }

        $grade = 'E';
        if ($score >= 85) $grade = 'A';
        elseif ($score >= 70) $grade = 'B';
        elseif ($score >= 55) $grade = 'C';
        elseif ($score >= 40) $grade = 'D';

        return [
            'total_score' => $score,
            'grade'       => $grade,
            'max_score'   => 100,
            'details'     => $details,
            'recommendations' => $this->generateSeoRecommendations($details, $score),
        ];
    }

    private function generateSeoRecommendations($details, $currentScore)
    {
        $recs = [];
        foreach ($details as $key => $d) {
            if ($d['score'] < 15) {
                $recs[] = [
                    'field'   => $key,
                    'message' => $d['msg'],
                    'action'  => $this->getRecommendationAction($key),
                ];
            }
        }
        if ($currentScore >= 85) {
            $recs[] = ['field' => 'overall', 'message' => '🎉 Skor SEO sangat baik! Produk siap tayang.', 'action' => null];
        }
        return $recs;
    }

    private function getRecommendationAction($field)
    {
        $actions = [
            'title'           => 'Perpanjang/pendekkan judul agar 40-100 karakter & tambahkan kata kunci utama',
            'description'     => 'Tambah detail produk, keunggulan, dan target pengguna di deskripsi',
            'keywords'        => 'Tambah lebih banyak kata kunci relevan (target 8-15 keyword)',
            'brand'           => 'Tetapkan nama brand untuk produk',
            'category'        => 'Pilih kategori yang sesuai',
            'price_variation' => 'Tentukan harga & variasi produk',
            'images'          => 'Generate minimal 3 gambar dengan angle berbeda',
        ];
        return $actions[$field] ?? 'Perbaiki field ini';
    }

    public function recommendVariations($productName, $additionalInfo = null)
    {
        $info = $additionalInfo ? " Informasi tambahan: {$additionalInfo}" : '';
        $prompt = "Untuk produk \"{$productName}\" yang dijual di Indonesia.{$info}
Apakah produk ini memiliki variasi seperti ukuran, warna, rasa, atau lainnya? Jika ya, berikan dalam format JSON array of objects dengan properti 'name' dan 'options' (array of strings).
Contoh: [{\"name\":\"Ukuran\",\"options\":[\"S\",\"M\",\"L\"]}, {\"name\":\"Warna\",\"options\":[\"Hitam\",\"Putih\"]}]
Jika tidak memiliki variasi, output: [].
Output hanya JSON valid, tanpa penjelasan lain.";
        
        $response = $this->callAI($prompt, 40, 5);
        if ($response) {
            preg_match('/\[.*\]/s', $response, $matches);
            if (!empty($matches)) {
                $variations = json_decode($matches[0], true);
                if (is_array($variations) && !empty($variations)) {
                    foreach ($variations as &$v) {
                        if (!isset($v['name']) || !isset($v['options'])) {
                            return [];
                        }
                        if (is_array($v['options'])) {
                            $v['options'] = array_map(function($opt) {
                                return is_array($opt) ? ($opt['value'] ?? '') : $opt;
                            }, $v['options']);
                        }
                    }
                    return $variations;
                }
            }
        }
        
        $lowerName = strtolower($productName);
        if (preg_match('/(hp|handphone|samsung|iphone)/i', $lowerName)) {
            return [
                ['name' => 'RAM/Storage', 'options' => ['4/64GB', '6/128GB', '8/256GB']],
                ['name' => 'Warna', 'options' => ['Hitam', 'Putih', 'Biru']]
            ];
        }
        if (preg_match('/(baju|kemeja|kaos|koko|gamis)/i', $lowerName)) {
            return [
                ['name' => 'Ukuran', 'options' => ['S', 'M', 'L', 'XL', 'XXL']],
                ['name' => 'Warna', 'options' => ['Hitam', 'Putih', 'Navy', 'Abu']]
            ];
        }
        if (preg_match('/(keripik|makanan|snack)/i', $lowerName)) {
            return [
                ['name' => 'Rasa', 'options' => ['Original', 'Pedas', 'Keju']],
                ['name' => 'Ukuran', 'options' => ['100gr', '250gr', '500gr']]
            ];
        }
        return [];
    }
}