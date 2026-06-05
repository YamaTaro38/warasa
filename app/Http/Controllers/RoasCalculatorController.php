<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class RoasCalculatorController extends Controller
{
    public function index()
    {
        return view('roas.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'ad_spend' => 'required|numeric|min:0',
            'revenue' => 'required|numeric|min:0',
            'period' => 'nullable|string',
            'product_name' => 'nullable|string',
            'campaign_name' => 'nullable|string',
        ]);

        $adSpend = $request->ad_spend;
        $revenue = $request->revenue;
        
        // Perhitungan ROAS
        $roas = $adSpend > 0 ? ($revenue / $adSpend) : 0;
        $roasPercentage = $roas * 100;
        
        // Interpretasi ROAS
        $interpretation = $this->interpretRoas($roas);
        
        // Rekomendasi berdasarkan hasil
        $recommendations = $this->getRecommendations($roas, $adSpend, $revenue);
        
        // Break-even point
        $breakEvenRoas = 1.0; // 100% (modal kembali)
        $breakEvenRevenue = $adSpend; // minimal revenue untuk BEP
        
        // Target ROAS untuk profit
        $targetProfitRoas = 2.0; // 200% (2x lipat modal)
        $targetRevenue = $adSpend * $targetProfitRoas;
        
        // Simpan ke log
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'roas_calculation',
                'description' => 'Calculated ROAS: ' . number_format($roas, 2) . 'x',
                'details' => [
                    'ad_spend' => $adSpend,
                    'revenue' => $revenue,
                    'roas' => $roas,
                    'product_name' => $request->product_name,
                    'campaign_name' => $request->campaign_name,
                ],
                'ip_address' => $request->ip(),
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'ad_spend' => $adSpend,
                'revenue' => $revenue,
                'roas' => round($roas, 2),
                'roas_percentage' => round($roasPercentage, 2),
                'profit' => $revenue - $adSpend,
                'interpretation' => $interpretation,
                'recommendations' => $recommendations,
                'break_even_roas' => $breakEvenRoas,
                'break_even_revenue' => $breakEvenRevenue,
                'target_profit_roas' => $targetProfitRoas,
                'target_revenue' => $targetRevenue,
            ]
        ]);
    }
    
    private function interpretRoas($roas)
    {
        if ($roas >= 5) {
            return [
                'level' => 'Sangat Baik',
                'color' => 'success',
                'icon' => 'fa-trophy',
                'message' => 'ROAS sangat baik! Campaign Anda sangat menguntungkan.',
                'grade' => 'A+'
            ];
        } elseif ($roas >= 3) {
            return [
                'level' => 'Baik',
                'color' => 'primary',
                'icon' => 'fa-chart-line',
                'message' => 'ROAS baik. Campaign Anda menguntungkan.',
                'grade' => 'A'
            ];
        } elseif ($roas >= 2) {
            return [
                'level' => 'Cukup',
                'color' => 'info',
                'icon' => 'fa-chart-simple',
                'message' => 'ROAS cukup. Masih ada ruang untuk optimasi.',
                'grade' => 'B'
            ];
        } elseif ($roas >= 1) {
            return [
                'level' => 'Break Even',
                'color' => 'warning',
                'icon' => 'fa-balance-scale',
                'message' => 'ROAS break even. Anda tidak untung dan tidak rugi.',
                'grade' => 'C'
            ];
        } else {
            return [
                'level' => 'Rugi',
                'color' => 'danger',
                'icon' => 'fa-exclamation-triangle',
                'message' => 'ROAS di bawah break even. Campaign Anda merugi.',
                'grade' => 'D'
            ];
        }
    }
    
    private function getRecommendations($roas, $adSpend, $revenue)
    {
        $recommendations = [];
        
        if ($roas < 1) {
            $recommendations[] = 'Hentikan sementara campaign ini karena merugi.';
            $recommendations[] = 'Evaluasi ulang target audiens dan kreatif iklan.';
            $recommendations[] = 'Turunkan biaya iklan atau cari channel yang lebih murah.';
            $recommendations[] = 'Optimasi landing page untuk meningkatkan konversi.';
        } elseif ($roas < 2) {
            $recommendations[] = 'Tingkatkan kualitas kreatif iklan (gambar/video).';
            $recommendations[] = 'Optimasi kata kunci dan targeting audiens.';
            $recommendations[] = 'Coba gunakan fitur automatic bidding Shopee.';
            $recommendations[] = 'Tambahkan promo atau diskon untuk meningkatkan konversi.';
        } elseif ($roas < 3) {
            $recommendations[] = 'Perbesar budget campaign ini secara bertahap.';
            $recommendations[] = 'Uji coba A/B testing untuk kreatif iklan.';
            $recommendations[] = 'Manfaatkan retargeting untuk pembeli yang sudah tertarik.';
            $recommendations[] = 'Tingkatkan rating dan ulasan produk di Shopee.';
        } else {
            $recommendations[] = 'Scale up campaign ini untuk hasil maksimal.';
            $recommendations[] = 'Analisis produk terlaris untuk dijadikan produk unggulan.';
            $recommendations[] = 'Gunakan lookalike audience untuk menjangkau lebih banyak pembeli.';
            $recommendations[] = 'Pantau secara rutin untuk menjaga performa tetap optimal.';
        }
        
        // Tambahkan rekomendasi spesifik Shopee
        $recommendations[] = 'Gunakan fitur Shopee Ads Keyword untuk target lebih tepat.';
        $recommendations[] = 'Manfaatkan momen flash sale dan campaign event Shopee.';
        
        return $recommendations;
    }
}