<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopeeFeeCalculatorController extends Controller
{
    // Struktur biaya Shopee berdasarkan kategori (per November 2025)
    // Sumber: goleki.id + dokumentasi resmi Shopee
    private const FEE_RATES = [
        'star' => [
            'default' => 2.50, // Star/Star+ default
            'per_category' => [
                'elektronik' => 1.50,
                'handphone' => 1.50,
                'komputer' => 1.50,
                'kamera' => 1.50,
                'fashion' => 3.00,
                'kecantikan' => 2.50,
                'ibu_anak' => 2.50,
                'makanan' => 3.00,
                'rumah_tangga' => 2.50,
                'otomotif' => 8.25,
                'olahraga' => 2.50,
                'buku' => 2.50,
            ]
        ],
        'non_star' => [
            'default' => 4.50, // Non-Star default
            'per_category' => [
                'elektronik' => 3.50,
                'handphone' => 3.50,
                'komputer' => 3.50,
                'kamera' => 3.50,
                'fashion' => 5.50,
                'kecantikan' => 4.50,
                'ibu_anak' => 4.50,
                'makanan' => 5.50,
                'rumah_tangga' => 4.50,
                'otomotif' => 3.50,
                'olahraga' => 4.50,
                'buku' => 4.50,
            ]
        ]
    ];

    // Biaya tetap per transaksi (Rp)
    private const FIXED_FEE = 1000;

    // Biaya layanan (service fee) flat
    private const SERVICE_FEE_RATE = 1.00; // 1% dari harga setelah diskon

    // Promo XTRA
    private const PROMO_XTRA_RATE = 4.50;
    private const PROMO_XTRA_MAX = 60000;

    // Live XTRA
    private const LIVE_XTRA_RATE = 3.00;
    private const LIVE_XTRA_MAX = 20000;

    // Pre-Order fee
    private const PREORDER_FEE_RATE = 3.00;

    // Gratis Ongkir XTRA rates per kategori
    private const FREE_SHIPPING_RATES = [
        'default' => 2.50,
        'elektronik' => 1.80,
        'handphone' => 1.80,
        'komputer' => 1.80,
        'kamera' => 1.80,
        'fashion' => 3.00,
        'makanan' => 3.50,
        'rumah_tangga' => 2.50,
    ];

    private const FREE_SHIPPING_MAX = 30000; // max subsidi per item

    public function index()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->select('id', 'name', 'slug')
            ->get();

        return view('roas.kalkulator-shopee', compact('categories'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'harga' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'voucher_penjual' => 'nullable|numeric|min:0',
            'cashback_koin' => 'nullable|numeric|min:0',
            'kategori_slug' => 'required|string',
            'status_penjual' => 'required|in:STAR,NON_STAR',
            'promo_xtra' => 'boolean',
            'live_xtra' => 'boolean',
            'gratis_ongkir_xtra' => 'boolean',
            'preorder' => 'boolean',
        ]);

        $harga = (float) $request->harga;
        $diskon = (float) ($request->diskon ?? 0);
        $voucherPenjual = (float) ($request->voucher_penjual ?? 0);
        $cashbackKoin = (float) ($request->cashback_koin ?? 0);
        $kategoriSlug = $request->kategori_slug;
        $statusPenjual = $request->status_penjual;
        $promoXtra = $request->boolean('promo_xtra');
        $liveXtra = $request->boolean('live_xtra');
        $gratisOngkirXtra = $request->boolean('gratis_ongkir_xtra');
        $preorder = $request->boolean('preorder');

        // 1. Harga setelah diskon
        $hargaSetelahDiskon = max(0, $harga - $diskon);

        // 2. Biaya admin (based on status & kategori)
        $feeRates = self::FEE_RATES[$statusPenjual === 'STAR' ? 'star' : 'non_star'];
        $adminFeeRate = $feeRates['per_category'][$kategoriSlug] ?? $feeRates['default'];
        $biayaAdmin = round($hargaSetelahDiskon * $adminFeeRate / 100);

        // 3. Biaya layanan tetap (service fee)
        $biayaLayanan = round($hargaSetelahDiskon * self::SERVICE_FEE_RATE / 100);

        // 4. Biaya tetap
        $biayaTetap = self::FIXED_FEE;

        // 5. Promo XTRA
        $biayaPromoXtra = 0;
        if ($promoXtra) {
            $biayaPromoXtra = round($hargaSetelahDiskon * self::PROMO_XTRA_RATE / 100);
            $biayaPromoXtra = min($biayaPromoXtra, self::PROMO_XTRA_MAX);
        }

        // 6. Live XTRA
        $biayaLiveXtra = 0;
        if ($liveXtra) {
            $biayaLiveXtra = round($hargaSetelahDiskon * self::LIVE_XTRA_RATE / 100);
            $biayaLiveXtra = min($biayaLiveXtra, self::LIVE_XTRA_MAX);
        }

        // 7. Gratis Ongkir XTRA
        $biayaGratisOngkir = 0;
        if ($gratisOngkirXtra) {
            $shippingRate = self::FREE_SHIPPING_RATES[$kategoriSlug] ?? self::FREE_SHIPPING_RATES['default'];
            $biayaGratisOngkir = round($hargaSetelahDiskon * $shippingRate / 100);
            $biayaGratisOngkir = min($biayaGratisOngkir, self::FREE_SHIPPING_MAX);
        }

        // 8. Pre-Order fee
        $biayaPreorder = 0;
        if ($preorder) {
            $biayaPreorder = round($hargaSetelahDiskon * self::PREORDER_FEE_RATE / 100);
        }

        // 9. Voucher penjual = diskon tambahan dari penjual
        $biayaVoucher = $voucherPenjual;

        // 10. Cashback koin ditanggung penjual
        $biayaCashback = $cashbackKoin;

        // Total biaya
        $totalBiaya = $biayaAdmin + $biayaLayanan + $biayaTetap + 
                       $biayaPromoXtra + $biayaLiveXtra + $biayaGratisOngkir + 
                       $biayaPreorder + $biayaVoucher + $biayaCashback;

        // Dana yang diterima
        $danaDiterima = $hargaSetelahDiskon - $totalBiaya;

        // Persentase total biaya
        $persenBiaya = $hargaSetelahDiskon > 0 ? round(($totalBiaya / $hargaSetelahDiskon) * 100, 2) : 0;

        // Breakdown items
        $breakdown = [
            [
                'label' => 'Biaya Admin (' . $adminFeeRate . '%)',
                'amount' => $biayaAdmin,
            ],
            [
                'label' => 'Biaya Layanan (' . self::SERVICE_FEE_RATE . '%)',
                'amount' => $biayaLayanan,
            ],
            [
                'label' => 'Biaya Tetap',
                'amount' => $biayaTetap,
            ],
        ];

        if ($biayaPromoXtra > 0) {
            $breakdown[] = [
                'label' => 'Promo XTRA (' . self::PROMO_XTRA_RATE . '%, max Rp' . number_format(self::PROMO_XTRA_MAX, 0, ',', '.') . ')',
                'amount' => $biayaPromoXtra,
            ];
        }

        if ($biayaLiveXtra > 0) {
            $breakdown[] = [
                'label' => 'Live XTRA (' . self::LIVE_XTRA_RATE . '%, max Rp' . number_format(self::LIVE_XTRA_MAX, 0, ',', '.') . ')',
                'amount' => $biayaLiveXtra,
            ];
        }

        if ($biayaGratisOngkir > 0) {
            $breakdown[] = [
                'label' => 'Gratis Ongkir XTRA',
                'amount' => $biayaGratisOngkir,
            ];
        }

        if ($biayaPreorder > 0) {
            $breakdown[] = [
                'label' => 'Pre-Order (' . self::PREORDER_FEE_RATE . '%)',
                'amount' => $biayaPreorder,
            ];
        }

        if ($biayaVoucher > 0) {
            $breakdown[] = [
                'label' => 'Voucher Penjual',
                'amount' => $biayaVoucher,
            ];
        }

        if ($biayaCashback > 0) {
            $breakdown[] = [
                'label' => 'Cashback Koin',
                'amount' => $biayaCashback,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'harga' => $harga,
                'diskon' => $diskon,
                'harga_setelah_diskon' => $hargaSetelahDiskon,
                'total_biaya' => $totalBiaya,
                'dana_diterima' => $danaDiterima,
                'persen_biaya' => $persenBiaya,
                'admin_fee_rate' => $adminFeeRate,
                'breakdown' => $breakdown,
            ]
        ]);
    }

    public function getCategories()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->select('id', 'name', 'slug')
            ->get();

        return response()->json($categories);
    }
}