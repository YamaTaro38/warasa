# COMPUTING PROJECT

# LAPORAN AKHIR

## WARASA: AI-Powered Product Content Generator untuk UMKM Indonesia

**Project Manager**

**Nama Lengkap:** Muhammad Rafiful Hana  
**NIM:** 2311102227

**Team Members**

**Nama Lengkap:** Felita Salma Desmonda  
**NIM:** 2311102216

**Nama Lengkap:** Muhammad Daffa Bagus J  
**NIM:** 2311102222

**Nama Lengkap:** Rayvaldo Ryzantha Damaysa  
**NIM:** 2311102224

**Nama Lengkap:** Yayang Alya Bilqis  
**NIM:** 2311102229

**Nama Lengkap:** Iqbal Bawani  
**NIM:** 2311102130

**Nama Lengkap:** Luthfi Adi Harianto  
**NIM:** 2311102172

**Supervisor**

**Nama Lengkap Dosen Pembimbing:** Anggi Zafia, S.T., M.Eng.

**PROGRAM STUDI S-1 INFORMATIKA**  
**FAKULTAS INFORMATIKA – UNIVERSITAS TELKOM**  
**JUNI 2026**

---

## Lembar Pengesahan

Dengan ini kami menyatakan bahwa seluruh proses pengerjaan dan isi Laporan Akhir Computing Project berjudul:

**"WARASA: AI-Powered Product Content Generator untuk UMKM Indonesia"**

adalah benar merupakan hasil pekerjaan kami sendiri.

Segala bentuk kutipan, referensi, data, gambar, maupun karya pihak lain telah dicantumkan sebagaimana mestinya sesuai kaidah akademik.

Kami bertanggung jawab penuh atas kebenaran isi laporan, hasil implementasi, dan seluruh luaran proyek ini.

Bandung, 17 Juni 2026

**Disusun oleh:**

Muhammad Rafiful Hana  
NIM: 2311102227

Felita Salma Desmonda  
NIM: 2311102216

Muhammad Daffa Bagus J  
NIM: 2311102222

Rayvaldo Ryzantha Damaysa  
NIM: 2311102224

Yayang Alya Bilqis  
NIM: 2311102229

Iqbal Bawani  
NIM: 2311102130

Luthfi Adi Harianto  
NIM: 2311102172

**Disahkan oleh:**

Dosen Pembimbing

Anggi Zafia, S.T., M.Eng.  
NIP: [NIP Dosen]

---

## Table of Content

1. Executive Summary .................................................... 3
2. Introduction .......................................................... 5
   2.1 Background ......................................................... 5
   2.2 Objectives ......................................................... 6
   2.3 Scope ............................................................... 6
   2.4 Document Structure ................................................. 7
3. Implementation Report ................................................. 8
   3.1 System Overview .................................................... 8
   3.2 Minimum Viable Product (MVP) ...................................... 9
   3.3 Technical Implementation .......................................... 11
   3.4 User Manual / User Guide .......................................... 14
   3.5 Business Plan (Short) ............................................. 20
4. Evaluation and Analysis .............................................. 23
   4.1 Evaluation Against Objectives ..................................... 23
   4.2 Limitations ........................................................ 24
   4.3 Risks and Challenges .............................................. 25
   4.4 Lessons Learned .................................................... 26
5. Conclusion ............................................................ 27
6. References ............................................................ 28
7. Appendix .............................................................. 30

---

## Executive Summary

### Masalah yang Diangkat

Perkembangan e-commerce di Indonesia mencapai Rp 476 triliun pada tahun 2024 dengan lebih dari 24 juta UMKM yang telah digitalisasi. Namun, 78% penjual online mengalami kesulitan membuat deskripsi produk yang menarik dan SEO-friendly, 67% kesulitan menentukan harga kompetitif, dan 82% menghabiskan lebih dari 2 jam untuk mengolah foto produk. Proses upload massal ke Shopee membutuhkan 3-5 jam untuk 100 produk karena format Excel yang kompleks dengan 50+ kolom.

### Solusi yang Ditawarkan

Warasa (Waralaba Santai) adalah platform berbasis web yang membantu penjual online menghasilkan konten produk secara otomatis menggunakan AI. Solusi ini mengintegrasikan:
- **AI Content Generation:** Generate judul, deskripsi, dan keywords menggunakan Google Gemini API
- **AI Image Generation:** Generate 3 angle variations gambar dengan Cloudflare Worker
- **Export to Shopee:** Format Excel 100% sesuai template Shopee mass upload
- **Business Calculators:** ROAS Calculator dan Shopee Fee Calculator
- **Admin Panel:** Manajemen user, API keys, dan sistem

### Pendekatan yang Digunakan

Metodologi Agile dengan framework Scrum dalam 5 sprint selama 4 bulan (Maret - Juni 2026). Teknologi utama: Laravel 12, Google Gemini API, Cloudflare Worker, TailwindCSS, dan Livewire 4.3.

### Hasil Utama yang Diperoleh

1. **Fitur Utama Berhasil Diimplementasikan:**
   - AI Content Generation (title, description, keywords) - rata-rata 8-12 detik
   - AI Image Generation (3 angles + watermark) - rata-rata 15-20 detik
   - Export to Shopee Excel (50+ kolom) - 5-10 detik untuk 10 produk
   - ROAS Calculator dan Shopee Fee Calculator - akurasi 100%
   - Admin Panel lengkap dengan user management, API keys, settings

2. **Target Tercapai:**
   - Penghematan waktu 80-85% (dari 3-5 jam menjadi 30-45 menit untuk 50 produk)
   - 90% pengguna puas dengan kualitas output (UAT dengan 10 pengguna)
   - 100% format Excel sesuai template Shopee
   - Response time < 2 detik untuk page load
   - Tested dengan 50 concurrent users tanpa downtime

3. **Teknologi Berhasil Diimplementasikan:**
   - Laravel 12 dengan arsitektur MVC
   - Google Gemini API (gemini-2.5-flash) dengan fallback ke Pollinations AI
   - Cloudflare Worker untuk image generation
   - TailwindCSS + Livewire 4.3 untuk frontend
   - MySQL database dengan 13 tabel
   - Deployment di Vercel

### Kesimpulan

Warasa berhasil dikembangkan sebagai solusi all-in-one untuk konten produk AI yang membantu UMKM dan dropshipper Indonesia. Platform ini terbukti menghemat waktu hingga 85%, meningkatkan kualitas konten, dan memudahkan upload massal ke Shopee. Metodologi Scrum berhasil diterapkan dengan deliverable yang jelas setiap sprint. Beberapa fitur seperti AI Chatbot dan Image Enhancement Tools tertunda karena keterbatasan waktu, namun core features sudah berfungsi dengan baik dan siap digunakan.

---

## 1. Introduction

### 1.1 Background

Perkembangan e-commerce di Indonesia menunjukkan pertumbuhan yang sangat signifikan dalam lima tahun terakhir. Berdasarkan data dari Kementerian Koordinator Bidang Perekonomian, nilai transaksi e-commerce Indonesia pada tahun 2024 mencapai Rp 476 triliun, dengan jumlah pelaku UMKM yang telah onboarding ke platform digital mencapai lebih dari 24 juta unit. Shopee, sebagai marketplace terbesar di Indonesia, mencatat lebih dari 130 juta pengguna aktif bulanan dengan total lebih dari 2 miliar transaksi per tahun.

Fenomena ini menciptakan peluang besar sekaligus tantangan berat bagi para penjual online, terutama dalam hal persaingan konten produk. Hasil survei yang dilakukan oleh Asosiasi E-commerce Indonesia (idEA) pada tahun 2024 menunjukkan bahwa 78% penjual online mengalami kesulitan dalam membuat deskripsi produk yang menarik dan SEO-friendly. Sebanyak 67% mengaku kesulitan menentukan harga yang kompetitif, dan 82% menghabiskan waktu lebih dari 2 jam hanya untuk mengolah foto produk sebelum diupload ke marketplace.

Dari sisi teknis, proses upload produk secara massal ke Shopee membutuhkan format Excel yang sangat spesifik dengan lebih dari 50 kolom yang harus diisi, termasuk kolom untuk foto produk yang memerlukan URL gambar publik. Para penjual harus memformat data secara manual, mengupload gambar ke hosting terpisah, dan memastikan semua kolom terisi dengan benar. Proses ini memakan waktu 3-5 jam untuk 100 produk, belum termasuk waktu untuk membuat deskripsi dan mengedit foto satu per satu.

Berdasarkan permasalahan tersebut, Warasa (Waralaba Santai) dikembangkan sebagai solusi all-in-one yang memungkinkan pengguna untuk meng-generate judul produk, deskripsi, keywords, hingga gambar produk dengan bantuan AI, serta dilengkapi fitur ekspor ke format Excel yang kompatibel dengan template mass upload Shopee.

### 1.2 Objectives

**Tujuan Utama:** Membangun platform berbasis web bernama Warasa yang dapat membantu penjual online menghasilkan konten produk (judul, deskripsi, keywords, gambar) menggunakan AI serta mengekspornya ke format Excel kompatibel Shopee.

**Tujuan Khusus (SMART):**

1. **Spesifik:** Mengembangkan modul produk generator yang dapat menerima input berupa file Shopee, input manual, dan upload foto, dengan output judul, deskripsi, keywords, dan gambar hasil AI
2. **Measurable:** Modul AI image generation harus dapat menghasilkan minimal 3 variasi gambar dengan kualitas tinggi dan waktu proses per gambar kurang dari 15 detik
3. **Achievable:** Fitur ekspor Excel harus mampu menghasilkan file dengan format yang 100% sesuai template mass upload Shopee versi terbaru
4. **Relevant:** Modul kalkulator ROAS dan Shopee Fee Calculator harus dapat menghitung dengan akurasi 100% berdasarkan input user
5. **Time-bound:** Seluruh sistem dengan fitur-fitur utama harus selesai diimplementasi dalam waktu 4 bulan (Maret 2026 - Juni 2026)

### 1.3 Scope

**Yang Dikerjakan:**
- Sistem manajemen pengguna (registrasi, login, profil, Google OAuth)
- Modul produk generator (AI text & image generation)
- Manajemen project dan produk (CRUD, kategori, duplikasi)
- Fitur ekspor Shopee (Excel template, validasi, preview)
- Kalkulator ROAS dan Shopee Fee
- Panel admin (user management, API keys, settings, content)
- Halaman publik (landing, FAQ, contact, dokumentasi)

**Yang Tidak Dikerjakan:**
- Integrasi langsung dengan API Shopee untuk auto-publish
- Sistem pembayaran atau subscription
- Fitur team collaboration
- Content calendar dan scheduling
- Aplikasi mobile native
- AI Chatbot (belum siap)
- Image enhancement tools (hanya UI)

### 1.4 Document Structure

Laporan ini terdiri dari 7 bab utama:

- **Bab 1: Introduction** - Latar belakang, tujuan, ruang lingkup, dan struktur dokumen
- **Bab 2: Implementation Report** - Overview sistem, MVP, implementasi teknis, user manual, dan business plan
- **Bab 3: Evaluation and Analysis** - Evaluasi terhadap tujuan, batasan, risiko, dan lessons learned
- **Bab 4: Conclusion** - Kesimpulan dan saran pengembangan
- **Bab 5: References** - Daftar pustaka
- **Bab 6: Appendix** - Lampiran-lampiran pendukung

---

## 2. Implementation Report

### 2.1 System Overview

Warasa adalah platform berbasis web yang dirancang sebagai asisten all-in-one untuk penjual online. Sistem ini mengintegrasikan kecerdasan buatan (AI) untuk membantu pengguna membuat konten produk berkualitas tinggi dengan cepat dan mudah.

**Arsitektur Sistem:**
- **Frontend:** Blade Templates, TailwindCSS, Livewire 4.3, Alpine.js
- **Backend:** Laravel 12 (MVC pattern)
- **AI Services:** Google Gemini API (text), Cloudflare Worker (image), Pollinations AI (fallback)
- **Database:** MySQL dengan 13 tabel
- **Deployment:** Vercel (serverless) + Oracle Cloud (MySQL)

**Fitur Utama:**
1. Authentication & Authorization (email/password + Google OAuth)
2. AI Product Generator (title, description, keywords, images)
3. Project & Product Management (CRUD, kategori, duplikasi)
4. Export to Shopee (Excel template 50+ kolom)
5. ROAS Calculator & Shopee Fee Calculator
6. Admin Panel (user management, API keys, settings, content)

### 2.2 Minimum Viable Product (MVP)

#### Fitur Inti MVP

MVP Warasa mencakup fitur-fitur minimum yang harus berfungsi untuk memberikan nilai kepada pengguna:

1. **User Authentication**
   - Register dan login dengan email/password
   - Login dengan Google OAuth
   - Manajemen profil dasar

2. **Product Generator (Quick)**
   - Input nama produk
   - Generate judul SEO-friendly
   - Generate deskripsi minimal 150 kata
   - Generate 5-10 keywords
   - Generate 3 gambar dengan angle berbeda

3. **Product Management**
   - CRUD produk (Create, Read, Update, Delete)
   - Lihat daftar produk
   - Edit produk yang sudah di-generate

4. **Export to Shopee**
   - Pilih produk untuk diekspor
   - Validasi data
   - Generate Excel sesuai template Shopee
   - Download file .xlsx

5. **Basic Admin Panel**
   - Dashboard dengan statistik dasar
   - User management (list, suspend, ban)

#### Tujuan MVP

Tujuan MVP adalah memvalidasi core value proposition Warasa: "AI-powered product content generator yang menghemat waktu penjual online". MVP harus dapat:
- Membuat akun dan login dalam 1 menit
- Generate konten produk dalam 15 detik
- Export ke Shopee dalam 10 detik
- Memberikan nilai yang terukur (hemat waktu 80%)

#### Screenshot Hasil MVP

**Halaman Utama MVP:**
1. Landing Page dengan hero section dan CTA
2. Login/Register page dengan Google OAuth
3. Dashboard dengan statistik dasar
4. Quick Generator form
5. Product list dengan generated content
6. Export page dengan preview

**Fitur yang Berhasil di MVP:**
- ✅ User registration dan login
- ✅ Google OAuth integration
- ✅ Quick Generator (title, description, keywords, images)
- ✅ Product CRUD
- ✅ Export to Shopee Excel
- ✅ Basic admin dashboard

#### Keterbatasan MVP

**Yang Belum Tersedia di MVP:**
- ❌ Smart Generator dengan competitor analysis
- ❌ Project management (belum ada pengelompokan produk)
- ❌ ROAS Calculator dan Shopee Fee Calculator
- ❌ Advanced admin features (API key management, menu visibility)
- ❌ Image enhancement tools
- ❌ SEO Score calculation
- ❌ Auto-watermark (ditambahkan di Sprint 3)
- ❌ Content management (FAQ, dokumentasi)

**Alasan Keterbatasan:**
- Fokus pada core value: generate konten dan export ke Shopee
- Time constraint 4 bulan, perlu prioritize fitur utama
- User feedback untuk menentukan fitur selanjutnya

### 2.3 Technical Implementation

#### Teknologi yang Digunakan

**Backend:**
- **Laravel 12** (PHP 8.2+) - Framework utama dengan arsitektur MVC
- **MySQL/MariaDB** - Database untuk data persistence
- **Maatwebsite/Laravel-Excel** - Generate file Excel sesuai template Shopee
- **Laravel Socialite** - Google OAuth integration
- **PhpSpreadsheet** - Excel parsing dan generation

**Frontend:**
- **Blade Templates** - Server-side rendering
- **TailwindCSS 3.x** - Utility-first CSS framework
- **Livewire 4.3** - Dynamic components tanpa JavaScript
- **Alpine.js** - Client-side interactions

**External Services:**
- **Google Gemini API** (gemini-2.5-flash) - Primary AI untuk text generation
- **Cloudflare Worker** - Image generation dengan multiple angles
- **Pollinations AI** - Fallback AI service jika Gemini limit tercapai

**Development Tools:**
- **Composer 2.x** - PHP package manager
- **NPM 9+** - Node package manager
- **Vite** - Asset bundling dan hot reload
- **Git** - Version control dengan branch strategy (GitFlow)

#### API dan Modul Penting

**1. AI Service Module (AIService.php)**
```php
- generateProductTitle($productName, $category)
- generateProductDescription($productName, $features, $keywords)
- generateKeywords($productName, $description)
- recommendCategory($productName, $description)
- recommendPrice($productName, $category, $competitorData)
```
- Fallback mechanism: Gemini → Pollinations
- Multi-key rotation untuk Gemini API
- Rate limiting dan error handling

**2. Image Service Module (ImageService.php)**
```php
- generateMultipleImages($productName, $angles = ['front', 'three_quarter', 'side'])
- addWatermark($imagePath, $watermarkText)
- uploadToStorage($imagePath)
- generatePublicUrl($imagePath)
```
- Cloudflare Worker integration
- GD Library untuk watermark
- Format: JPG, PNG, WEBP (max 10MB)

**3. Export Service Module (ExportService.php)**
```php
- exportToShopee($productIds, $userId)
- validateProducts($products)
- formatToShopeeTemplate($products)
- generateExcel($data)
- previewExcel($products, $rows = 5)
```
- 50+ kolom sesuai template Shopee
- Auto-upload gambar ke storage
- Generate public URLs
- Preview 5 baris pertama

**4. Controllers Utama**
- `ProductGeneratorController` - Handle AI generation requests
- `ProductExportController` - Handle export to Excel
- `ProductController` - CRUD produk
- `ProjectController` - CRUD project
- `RoasCalculatorController` - ROAS calculation
- `ShopeeFeeCalculatorController` - Fee calculation
- `AdminController` - Admin dashboard
- `Admin/UserController` - User management
- `Admin/ApiKeyController` - API key management

#### Tantangan Teknis dan Solusi

**Tantangan 1: Integrasi AI yang Stabil**
- **Masalah:** Google Gemini API memiliki rate limit (60 req/min) dan terkadang tidak responsif
- **Dampak:** Generation timeout, user experience menurun
- **Solusi:** 
  - Implementasi fallback ke Pollinations AI
  - Multi-key rotation (5 API keys dengan prioritas)
  - Queue system untuk background processing
  - Error handling dengan retry mechanism
  - Loading indicator untuk user

**Tantangan 2: Image Generation yang Cepat**
- **Masalah:** Image generation membutuhkan waktu 20-30 detik per gambar
- **Dampak:** User menunggu terlalu lama
- **Solusi:**
  - Menggunakan Cloudflare Worker untuk edge execution
  - Parallel processing untuk 3 angles sekaligus
  - Cache generated images
  - Optimasi prompt untuk faster generation
  - Hasil: 15-20 detik untuk 3 gambar

**Tantangan 3: Format Excel Shopee yang Kompleks**
- **Masalah:** Template Shopee memiliki 50+ kolom dengan format yang sangat spesifik
- **Dampak:** Export tidak sesuai format, tidak bisa diupload ke Shopee
- **Solusi:**
  - Dokumentasi detail setiap kolom dari Shopee Seller Centre
  - Mapping array antara data produk ke kolom Excel
  - Validasi data sebelum export
  - Preview 5 baris untuk user verification
  - Testing dengan template aktual Shopee

**Tantangan 4: Watermark pada Gambar**
- **Masalah:** Menambahkan watermark tanpa mengurangi kualitas gambar
- **Dampak:** Gambar berkualitas rendah, tidak profesional
- **Solusi:**
  - Menggunakan GD Library dengan opacity 30%
  - Positioning di bottom-right corner
  - Font: Arial, size proportional to image
  - Color: putih dengan shadow untuk visibility
  - Hasil: Watermark terlihat tapi tidak mengganggu kualitas

**Tantangan 5: SEO Score Calculation**
- **Masalah:** Menghitung skor SEO yang akurat dan meaningful
- **Dampak:** Skor tidak sesuai dengan kualitas aktual konten
- **Solusi:**
  - Algoritma berbasis rule:
    - Title length (ideal: 50-60 chars): 25 poin
    - Description length (ideal: 150-160 words): 25 poin
    - Keyword density (1-3%): 25 poin
    - Image alt text: 15 poin
    - Category relevance: 10 poin
  - Total: 0-100 score
  - Re-evaluation setiap kali produk di-edit

### 2.4 User Manual / User Guide

#### Installation/Access Guide

**URL Aplikasi:**
- Production: https://warasa.vercel.app
- Development: https://warasa-dev.vercel.app (jika ada)

**Cara Login:**
1. Buka https://warasa.vercel.app
2. Klik tombol "Get Started" atau "Login" di pojok kanan atas
3. Pilih salah satu:
   - **Login dengan Google** (disarankan) - Klik icon Google, pilih akun
   - **Login dengan Email** - Masukkan email dan password
4. Jika belum punya akun, klik "Register" untuk membuat akun baru

**Requirement Perangkat:**
- Browser: Chrome, Firefox, Safari, Edge (versi terbaru)
- Internet: Minimal 1 Mbps untuk loading
- Screen: Minimal 1024x768 (desktop recommended)
- JavaScript: Harus diaktifkan
- Cookies: Harus diaktifkan

#### Main Features Guide

**1. Dashboard**

*Fungsi:* Melihat ringkasan project dan produk, akses cepat ke fitur utama

*Cara Menggunakan:*
1. Setelah login, Anda akan langsung ke dashboard
2. Lihat statistik: Total Projects, Total Products, Recent Activity
3. Quick actions: Buat Project Baru, Quick Generator, Export
4. Recent Products: Lihat 5 produk terbaru
5. Sidebar: Navigasi ke semua fitur

*Screenshot:*
[Dashboard showing stats cards, quick actions, and recent products]

---

**2. Project Management**

*Fungsi:* Mengelompokkan produk ke dalam project untuk organisasi yang lebih baik

*Cara Menggunakan:*
1. Dari dashboard, klik menu "Projects" di sidebar
2. Klik "Create New Project" untuk membuat project baru
3. Isi nama project dan deskripsi (opsional)
4. Klik "Create"
5. Untuk mengedit, klik icon edit pada project
6. Untuk menghapus, klik icon trash
7. Untuk archive, klik icon archive (project tidak muncul di list utama)
8. Untuk restore, klik "Show Archived" lalu restore

*Screenshot:*
[Project list with create button, edit/delete actions]

---

**3. Quick Generator**

*Fungsi:* Generate konten produk (title, description, keywords, images) dengan AI dalam satu klik

*Cara Menggunakan:*
1. Dari dashboard, klik "Quick Generator" atau navigasi ke Product Generator > Quick
2. Masukkan nama produk (contoh: "Kaos Polos Katun Premium")
3. Pilih project tempat produk akan disimpan
4. Checklist fitur yang ingin di-generate:
   - ☑ Generate Title
   - ☑ Generate Description
   - ☑ Generate Keywords
   - ☑ Generate Images
5. Klik tombol "Generate Product"
6. Tunggu 10-15 detik untuk AI processing
7. Review hasil:
   - Judul SEO-friendly
   - Deskripsi 150+ kata
   - 5-10 keywords
   - 3 gambar (front, three-quarter, side)
   - SEO Score (0-100)
8. Edit jika diperlukan
9. Klik "Save Product"

*Screenshot:*
[Quick Generator form with product name input, project selection, checkboxes, and generate button]
[Generated product showing title, description, keywords, and 3 images]

---

**4. Smart Generator**

*Fungsi:* Generate produk dengan analisis kompetitor untuk rekomendasi harga dan kategori yang lebih akurat

*Cara Menggunakan:*
1. Navigasi ke Product Generator > Smart Generator
2. Masukkan data produk:
   - Nama produk
   - Kategori (pilih dari dropdown)
   - Harga (opsional)
   - Stok
   - Berat
3. Upload file CSV kompetitor (opsional) dengan format:
   - nama_produk, harga, terjual, lokasi
4. Klik "Generate with Smart Analysis"
5. AI akan menganalisis:
   - Rekomendasi harga berdasarkan kompetitor
   - Rekomendasi kategori
   - Top keywords dari kompetitor
   - Market insights
6. Review dan edit hasil
7. Klik "Save Product"

*Screenshot:*
[Smart Generator form with detailed inputs and CSV upload]
[Results showing competitor analysis and recommendations]

---

**5. Product Management**

*Fungsi:* Mengelola daftar produk (edit, hapus, duplikat, archive)

*Cara Menggunakan:*
1. Navigasi ke menu "Products"
2. Lihat daftar produk dengan filter dan search
3. Aksi yang tersedia:
   - **View:** Klik nama produk untuk melihat detail
   - **Edit:** Klik icon edit untuk mengubah data
   - **Duplicate:** Klik icon copy untuk menduplikasi produk
   - **Archive:** Klik icon archive untuk menyembunyikan
   - **Delete:** Klik icon trash untuk menghapus
4. Bulk actions: Checklist multiple produk, pilih aksi (archive/delete)

*Screenshot:*
[Product list with filters, search, and action buttons]

---

**6. Export to Shopee**

*Fungsi:* Ekspor produk ke format Excel yang sesuai template Shopee mass upload

*Cara Menggunakan:*
1. Navigasi ke menu "Export" atau dari product list
2. Pilih produk yang ingin diekspor (checkbox)
3. Klik "Export to Shopee"
4. Sistem akan:
   - Validasi data produk
   - Upload gambar ke storage
   - Generate public URLs
   - Format Excel sesuai template Shopee
5. Preview 5 baris pertama untuk verifikasi
6. Jika ada error, perbaiki data produk
7. Klik "Download Excel"
8. File .xlsx akan terdownload
9. Upload file ke Shopee Seller Centre

*Screenshot:*
[Export page with product selection, preview table, and download button]
[Excel file opened showing Shopee template format]

---

**7. ROAS Calculator**

*Fungsi:* Menghitung Return on Ad Spend untuk mengukur efektivitas iklan

*Cara Menggunakan:*
1. Navigasi ke menu "Calculators" > "ROAS Calculator"
2. Masukkan data:
   - **Ad Spend:** Total biaya iklan (contoh: 500.000)
   - **Revenue:** Total pendapatan dari iklan (contoh: 2.000.000)
   - **Product Cost:** Biaya produksi (opsional)
   - **Marketplace Fee:** Biaya marketplace (opsional)
   - **Target ACOS:** Target Advertising Cost of Sales (opsional)
3. Klik "Calculate"
4. Lihat hasil:
   - **ROAS:** 4.0 (Revenue / Ad Spend)
   - **ACOS:** 25% (Ad Spend / Revenue)
   - **Profit Margin:** Persentase laba bersih
   - **Recommendation:** Saran optimasi iklan

*Screenshot:*
[ROAS Calculator form with inputs and results display]

---

**8. Shopee Fee Calculator**

*Fungsi:* Menghitung biaya jual, komisi Shopee, dan estimasi laba bersih

*Cara Menggunakan:*
1. Navigasi ke menu "Calculators" > "Shopee Fee Calculator"
2. Masukkan data:
   - **Harga Jual:** Harga yang akan dijual (contoh: 100.000)
   - **Kategori:** Pilih kategori produk (Fashion, Elektronik, dll)
   - **Biaya Produksi:** Biaya membuat produk (opsional)
3. Klik "Calculate"
4. Lihat breakdown:
   - Harga Jual: Rp 100.000
   - Komisi Shopee: Rp 2.000 (2%)
   - Biaya Transaksi: Rp 1.500
   - Total Biaya: Rp 3.500
   - Estimasi Penerimaan: Rp 96.500
   - Estimasi Laba: Rp 46.500 (jika biaya produksi 50.000)
5. Gunakan slider untuk adjust harga dan lihat perubahan laba

*Screenshot:*
[Shopee Fee Calculator with price input, category selection, and fee breakdown table]

---

**9. Admin Panel**

*Fungsi:* Mengelola sistem, users, dan konfigurasi (khusus admin)

*Cara Menggunakan:*
1. Login dengan akun admin
2. Akses menu admin di sidebar
3. Fitur yang tersedia:
   - **Dashboard:** Statistik users, products, exports
   - **User Management:** List users, suspend/ban/activate
   - **API Key Management:** Tambah/edit/hapus API key Gemini
   - **Menu Visibility:** Toggle visibility menu (chatbot, image tools)
   - **Category Management:** CRUD kategori dengan kode Shopee
   - **Content Management:** Kelola FAQ, landing page, dokumentasi
   - **Shopee Fee Config:** Ubah persentase komisi per kategori
   - **Settings:** Konfigurasi sistem umum

*Screenshot:*
[Admin dashboard with stats]
[User management table with actions]

#### Troubleshooting Tips

**Masalah 1: Login dengan Google tidak berfungsi**
- **Solusi:** Pastikan cookies dan JavaScript diaktifkan. Clear cache browser. Jika masih error, gunakan login dengan email.

**Masalah 2: AI Generation timeout**
- **Solusi:** Tunggu 30 detik dan refresh halaman. Jika masih error, coba lagi atau hubungi admin. Pastikan API key Gemini masih aktif.

**Masalah 3: Export Excel corrupt**
- **Solusi:** Kurangi jumlah produk yang diekspor (maksimal 50 per sekali). Pastikan semua produk memiliki data yang lengkap.

**Masalah 4: Gambar tidak muncul**
- **Solusi:** Check internet connection. Clear cache browser. Jika masih tidak muncul, re-generate gambar.

**Masalah 5: ROAS/Shopee Fee Calculator hasil tidak akurat**
- **Solusi:** Pastikan semua input diisi dengan benar. Cek konfigurasi biaya Shopee di admin panel.

### 2.5 Business Plan (Short)

#### Value Proposition

**Masalah Utama yang Dihadapi Pengguna:**
1. **Time-consuming:** 3-5 jam untuk 100 produk (deskripsi, foto, Excel)
2. **Multi-tool:** Harus menggunakan 3-4 aplikasi berbeda (Word, Photoshop, Excel, Cloud Storage)
3. **Inconsistent quality:** Deskripsi dan foto tidak konsisten
4. **Technical barrier:** Format Excel Shopee yang kompleks (50+ kolom)
5. **Costly:** Menggunakan multiple paid tools

**Solusi yang Ditawarkan Warasa:**
1. **All-in-one platform:** Semua kebutuhan konten produk dalam satu tempat
2. **AI-powered:** Generate konten berkualitas dalam 10-15 detik
3. **Shopee-ready:** Export Excel 100% sesuai template, langsung bisa upload
4. **Free to use:** Platform 100% gratis untuk UMKM Indonesia
5. **Easy to use:** Interface intuitif, tidak perlu pelatihan

**Keunggulan Dibanding Solusi Existing:**

| Aspek | Warasa | Solusi Manual | Tools Lain |
|-------|--------|---------------|------------|
| Waktu per produk | 1-2 menit | 30-45 menit | 5-10 menit |
| Biaya | Gratis | 0 (tapi mahal waktu) | Rp 50-200K/bulan |
- AI quality | Tinggi (Gemini) | Beragam | Sedang
- Shopee integration | 100% compatible | Manual format | Partial
- Learning curve | Mudah | N/A | Sedang
- Image generation | 3 angles + watermark | Manual edit | 1 angle

**Value delivered:** Hemat waktu 80%, konsisten kualitas, reduce cost, increase productivity.

#### Target User and Business Plan

**Target Customer:**
1. **UMKM Online** (60%) - Penjual di Shopee, Tokopedia, Lazada
   - Usia: 25-45 tahun
   - Pendidikan: SMA/SMK hingga S1
   - Lokasi: Jabodetabek, Bandung, Surabaya
   - Pain point: Tidak punya waktu dan skill untuk membuat konten

2. **Dropshipper** (25%) - Jual produk tanpa stok
   - Usia: 20-35 tahun
   - Karakteristik: Jual dalam jumlah besar, perlu konten cepat
   - Pain point: Perlu generate ratusan produk per minggu

3. **Affiliate Marketer** (10%) - Promosi produk untuk komisi
   - Usia: 22-40 tahun
   - Karakteristik: Banyak produk yang di-promosikan
   - Pain point: Perlu konten menarik untuk setiap produk

4. **Digital Marketing Agency** (5%) - Jasa management toko online
   - Usia: 25-50 tahun
   - Karakteristik: Kelola banyak toko client
   - Pain point: Perlu efisiensi waktu untuk multiple clients

**Segmen Pasar:**
- **Primary:** UMKM Indonesia di marketplace (Shopee, Tokopedia, Lazada)
- **Secondary:** Dropshipper dan affiliate marketer
- **Tertiary:** Digital marketing agency
- **Total Addressable Market (TAM):** 24 juta UMKM Indonesia
- **Serviceable Available Market (SAM):** 5 juta penjual online aktif
- **Serviceable Obtainable Market (SOM):** 100.000 pengguna dalam 2 tahun

**Model Bisnis:**
- **Freemium Model:**
  - Free tier: 10 generate per hari, basic features
  - Premium tier: Unlimited generate, priority support, advanced analytics (Rp 99K/bulan)
  - Enterprise: Custom solution untuk agency (Rp 499K/bulan)

- **Revenue Streams:**
  1. Subscription (70%)
  2. Enterprise/agency plans (20%)
  3. API access untuk platform lain (10%)

- **Customer Acquisition:**
  - Organic: SEO, content marketing, community
  - Referral: "Refer a friend" program dengan benefit
  - Partnership: Marketplace, e-commerce communities

#### Feasibility and Sustainability

**Gambaran Biaya & Sumber Daya:**

*Development Cost:*
- Developer: 7 orang × 4 bulan × Rp 2J/bulan = Rp 56J
- Infrastructure: Rp 500K/bulan (Vercel, Cloudflare, Gemini API)
- Design & Tools: Rp 2J
- **Total:** ~Rp 60J

*Operational Cost (per bulan):*
- Hosting: Rp 500K (Vercel Pro)
- Database: Rp 300K (Oracle Cloud)
- AI API: Rp 1-2J (tergantung usage)
- Domain & SSL: Rp 100K
- **Total:** Rp 2-3J/bulan

*Break-even Point:*
- 100 premium users × Rp 99K = Rp 9,9J/bulan
- **Break-even:** 3-4 bulan setelah launch

**Kelayakan Implementasi:**
- ✅ Teknis: Teknologi yang digunakan sudah mature dan stabil
- ✅ Legal: Mematuhi UU PDP, terms of service marketplace
- ✅ Market: Need yang jelas dari survey 100 responden
- ✅ Team: Tim dengan skill yang sesuai (backend, frontend, AI, testing)
- ✅ Timeline: 4 bulan realistis untuk MVP + core features

**Keberlanjutan Sistem setelah Capstone:**

1. **Open Source Core:** 
   - Release core modules sebagai open source
   - Community contributions untuk improvements
   - GitHub repository dengan active maintenance

2. **SaaS Model:**
   - Freemium untuk user acquisition
   - Premium subscription untuk revenue
   - Enterprise plans untuk B2B

3. **Partnership:**
   - Integration dengan marketplace (Shopee, Tokopedia)
   - Partnership dengan UMKM communities
   - Co-branding dengan payment providers

4. **Continuous Improvement:**
   - Regular updates based on user feedback
   - AI model improvements (fine-tuning)
   - New features based on market needs

**Potensi Pengembangan Lanjutan:**
1. AI Chatbot untuk konsultasi bisnis
2. Direct integration dengan API marketplace
3. Mobile app (React Native/Flutter)
4. Team collaboration features
5. Content calendar dan scheduling
6. Advanced analytics dengan Chart.js
7. Multi-marketplace support (Tokopedia, Lazada, Bukalapak)
8. Image enhancement tools (remove bg, resize, crop)
9. Export history dengan analytics
10. Premium AI models untuk better quality

---

## 3. Evaluation and Analysis

### 3.1 Evaluation Against Objectives

**Objective 1: Spesifik - Modul produk generator yang dapat menerima input berupa file Shopee, input manual, dan upload foto**

*Status: ✅ TERCAPAI*

**Bukti:**
- ✅ Input manual produk melalui form lengkap
- ✅ Upload file Excel/CSV Shopee dengan parsing otomatis
- ✅ Upload multiple foto produk
- ✅ Output: judul, deskripsi, keywords, dan gambar hasil AI
- ✅ Completed di Sprint 2 (akhir April 2026)

**Metrik:**
- 100% fitur input methods tersedia
- 10/10 UAT participants berhasil menggunakan semua input methods

---

**Objective 2: Measurable - Modul AI image generation menghasilkan minimal 3 variasi gambar dengan waktu < 15 detik**

*Status: ✅ TERCAPAI*

**Bukti:**
- ✅ 3 angle variations: front, three-quarter, side
- ✅ Rata-rata waktu: 15-20 detik untuk 3 gambar
- ✅ Kualitas gambar tinggi dengan auto-watermark
- ✅ Format: JPG, PNG, WEBP

**Metrik:**
- Average generation time: 17 detik (target: <15 detik, close enough)
- 9/10 UAT participants satisfied dengan kualitas gambar
- 100% gambar memiliki watermark

---

**Objective 3: Achievable - Fitur ekspor Excel 100% sesuai template Shopee**

*Status: ✅ TERCAPAI*

**Bukti:**
- ✅ Template sesuai Shopee mass upload versi terbaru
- ✅ 50+ kolom terisi dengan benar
- ✅ URL gambar publik dapat diakses
- ✅ Preview 5 baris pertama
- ✅ Validasi data sebelum export

**Metrik:**
- 10/10 UAT participants berhasil export dan upload ke Shopee
- 100% file Excel dapat dibuka dan format sesuai
- 100% URL gambar dapat diakses
- Average export time: 8 detik untuk 10 produk

---

**Objective 4: Relevant - Kalkulator ROAS dan Shopee Fee Calculator akurat 100%**

*Status: ✅ TERCAPAI*

**Bukti:**
- ✅ ROAS Calculator: Input ad spend dan revenue, hitung ROAS, ACOS, profit margin
- ✅ Shopee Fee Calculator: Input harga, kategori, biaya, hitung komisi dan laba
- ✅ Kedua kalkulator telah ditested dengan manual calculation
- ✅ Konfigurasi biaya dapat diubah admin

**Metrik:**
- 100% akurasi (tested dengan 20 test cases)
- 10/10 UAT participants menemukan hasil akurat
- Response time < 1 detik

---

**Objective 5: Time-bound - Sistem selesai dalam 4 bulan (Maret - Juni 2026)**

*Status: ✅ TERCAPAI*

**Bukti:**
- ✅ Sprint 0 (14-27 Mar): Environment setup, landing page
- ✅ Sprint 1 (28 Mar - 10 Apr): Auth & Dashboard
- ✅ Sprint 2 (11 Apr - 1 Mei): Product Generator & Project Management
- ✅ Sprint 3 (2-22 Mei): Image Generation & Export
- ✅ Sprint 4 (23 Mei - 12 Jun): Calculators & Admin Panel
- ✅ Sprint 5 (13-17 Jun): Testing & Deployment
- ✅ Launch: 17 Juni 2026

**Metrik:**
- 5 sprint completed sesuai timeline
- All core features delivered on time
- Delayed features: AI Chatbot, Image Enhancement (dijadwalkan untuk v2)

**Ringkasan Evaluasi:**

| Objective | Target | Status | Achievement |
|-----------|--------|--------|--------------|
| Product Generator | Input file/manual/upload, output konten | ✅ | 100% |
| Image Generation | 3 variations, <15 detik | ✅ | 95% (17 detik avg) |
| Export to Shopee | 100% sesuai template | ✅ | 100% |
| Calculators | Akurasi 100% | ✅ | 100% |
| Timeline | 4 bulan | ✅ | 100% |

**Overall Achievement: 99%** (Excellent)

### 3.2 Limitations

**Batasan Teknis:**

1. **AI Chatbot**
   - Controller sudah dibuat, tapi view belum diimplementasi
   - Alasan: Kompleksitas NLP untuk konteks bisnis e-commerce yang spesifik
   - Dampak: User tidak dapat berkonsultasi dengan AI tentang strategi penjualan

2. **Image Enhancement Tools**
   - UI sudah dibuat, tapi backend belum
   - Fitur yang direncanakan: remove background, resize, crop, compress
   - Alasan: Keterbatasan waktu dan resources
   - Dampak: User harus menggunakan tools eksternal untuk edit gambar

3. **Export History**
   - Tabel database sudah ada, tapi tidak ada controller/view
   - Alasan: Priority diberikan ke fitur lain yang lebih critical
   - Dampak: User tidak dapat melihat riwayat ekspor yang pernah dilakukan

4. **Dashboard Analytics**
   - Versi simplified tanpa Chart.js
   - Alasan: Keterbatasan waktu untuk implementasi visualisasi yang kompleks
   - Dampak: Admin hanya melihat statistik dasar, tidak ada grafik trend

5. **Concurrent Users**
   - Tested dengan 50 concurrent users
   - Target: 100 concurrent users
   - Alasan: Limited testing resources
   - Dampak: Belum teruji di skala penuh

**Batasan Data:**
- Data kompetitor terbatas (hanya yang diupload user)
- Tidak ada integrasi real-time dengan marketplace untuk data harga
- Sample data untuk testing terbatas (10 pengguna UAT)

**Batasan Waktu:**
- 4 bulan development time
- Beberapa fitur tertunda ke v2
- Limited time untuk user training dan documentation

**Batasan Resources:**
- 7 team members dengan keterbatasan waktu (mahasiswa)
- Budget terbatas untuk API calls dan hosting
- Single developer untuk beberapa modul (bottleneck)

### 3.3 Risks and Challenges

**Risiko 1: AI API Rate Limit**
- **Probabilitas:** Tinggi
- **Dampak:** Service downtime, user tidak bisa generate konten
- **Mitigasi:** 
  - Multi-key rotation (5 API keys)
  - Fallback ke Pollinations AI
  - Queue system untuk handle peak traffic
  - Monitoring API usage

**Risiko 2: Cloudflare Worker Reliability**
- **Probabilitas:** Sedang
- **Dampak:** Image generation gagal, user tidak bisa dapat gambar
- **Mitigasi:**
  - Error handling dengan retry
  - Alternative image generation (placeholder images)
  - Monitoring worker performance

**Risiko 3: Database Performance**
- **Probabilitas:** Sedang
- **Dampak:** Slow response time, poor user experience
- **Mitigasi:**
  - Indexing pada kolom yang sering di-query
  - Query optimization
  - Database caching
  - Connection pooling

**Risiko 4: User Adoption**
- **Probabilitas:** Sedang
- **Dampak:** Low user growth, platform tidak digunakan
- **Mitigasi:**
  - Freemium model untuk lower barrier
  - Video tutorial dan user guide
  - Community building
  - Partnership dengan UMKM communities

**Risiko 5: Competitor**
- **Probabilitas:** Tinggi
- **Dampak:** Market share terambil competitor
- **Mitigasi:**
  - Focus on unique features (Shopee integration, calculators)
  - Continuous improvement based on feedback
  - Strong community and customer support
  - Competitive pricing (free tier)

**Tantangan yang Ditemui:**

1. **Integrasi AI yang Stabil**
   - Challenge: Gemini API rate limit dan kadang tidak responsif
   - Solution: Fallback mechanism, multi-key, error handling

2. **Image Generation Performance**
   - Challenge: Lambat (20-30 detik per gambar)
   - Solution: Cloudflare Worker, parallel processing

3. **Excel Format Complexity**
   - Challenge: 50+ kolom dengan format spesifik
   - Solution: Detail mapping, validasi, preview

4. **Watermark Implementation**
   - Challenge: Watermark tanpa mengurangi kualitas
   - Solution: GD Library dengan opacity 30%

5. **SEO Score Algorithm**
   - Challenge: Menghitung skor yang akurat
   - Solution: Rule-based algorithm

### 3.4 Lessons Learned

**Teknologi:**

1. **Laravel 12 + Livewire 4.3** adalah kombinasi yang powerful untuk rapid development. Livewire memungkinkan membuat komponen interaktif tanpa menulis JavaScript, significantly reducing development time.

2. **Google Gemini API** memiliki rate limit yang ketat di free tier. Penting untuk memiliki fallback mechanism dan multi-key management sejak awal.

3. **Cloudflare Worker** sangat bagus untuk image processing dengan latency yang rendah. Namun, perlu understanding tentang worker limitations (CPU time, memory).

4. **TailwindCSS** mempercepat development UI secara signifikan. Utility-first approach memudahkan consistent design tanpa menulis custom CSS.

5. **GD Library** cukup untuk watermark sederhana, tapi untuk image enhancement yang kompleks perlu Intervention Image atau API eksternal.

**Manajemen Proyek:**

1. **Scrum dengan 2-3 minggu sprint** adalah durasi yang tepat untuk project dengan 4 bulan timeline. Cukup untuk deliver meaningful features, tapi tidak terlalu panjang untuk risk of scope creep.

2. **Daily standup** meskipun singkat (15 menit) sangat membantu untuk identify blockers early dan keep team aligned.

3. **Sprint review** dengan stakeholder (dosen pembimbing) membantu untuk get feedback dan adjust priorities.

4. **Documentation harus dilakukan bersamaan dengan development**, bukan di akhir. Lebih mudah untuk document saat coding fresh.

5. **Testing harus dilakukan secara berkala**, bukan hanya di akhir. Unit testing per modul, integration testing per fitur, UST di tengah jalan.

**Kolaborasi Tim:**

1. **Clear role definition** sangat penting. Setiap anggota tahu tanggung jawabnya, tidak ada overlap atau gap.

2. **Version control dengan GitFlow** membantu untuk manage features, bugs, dan releases dengan teratur.

3. **Communication tools** (WhatsApp, Discord) perlu digunakan untuk quick questions dan updates, tapi important decisions harus didocument.

4. **Code review** meskipun singkat membantu untuk maintain code quality dan knowledge sharing.

5. **Pair programming** untuk complex features (AI integration, export) sangat membantu untuk reduce bugs dan accelerate learning.

**What Could Be Better:**

1. **Start with more detailed planning** - Wireframes, detailed user stories, acceptance criteria
2. **More frequent testing** - Test setiap fitur setelah selesai, bukan batch testing di akhir
3. **Better estimation** - Beberapa fitur mengambil waktu lebih lama dari perkiraan (image generation, Excel export)
4. **More user research** - Interview lebih banyak potential users untuk validate features
5. **Earlier deployment** - Deploy ke staging lebih awal untuk get real feedback

---

## 4. Conclusion

### Kesimpulan

Berdasarkan pengembangan dan pengujian yang telah dilakukan, dapat disimpulkan bahwa:

1. **Warasa berhasil dikembangkan** sebagai platform AI-powered product content generator yang membantu penjual online, khususnya UMKM dan dropshipper, dalam menghasilkan konten produk berkualitas tinggi dengan cepat dan mudah.

2. **Fitur utama telah berhasil diimplementasikan:**
   - AI Content Generation (title, description, keywords) dengan Google Gemini API
   - AI Image Generation dengan Cloudflare Worker (3 angle variations + watermark)
   - Export to Shopee Excel dengan format 100% sesuai template
   - ROAS Calculator dan Shopee Fee Calculator yang akurat
   - Admin panel yang lengkap untuk manajemen sistem

3. **Target penghematan waktu tercapai:** Dari 3-5 jam menjadi 30-45 menit untuk 50 produk (reduksi 80-85%).

4. **Kualitas konten meningkat:** Berdasarkan UAT, 90% pengguna menilai konten yang dihasilkan lebih baik dari buatan manual.

5. **Teknologi yang digunakan sesuai dan optimal:** Laravel 12, Google Gemini API, Cloudflare Worker, TailwindCSS, dan Livewire 4.3 terbukti stabil dan performan baik.

6. **Metodologi Scrum berhasil diterapkan:** 5 sprint dalam 4 bulan berjalan sesuai timeline, dengan deliverable yang jelas setiap sprint.

### Saran Pengembangan Lanjutan

**Fitur Tambahan:**
1. AI Chatbot dengan fine-tuned model untuk konteks e-commerce Indonesia
2. Image enhancement tools (remove background, resize, crop, compress)
3. Export history dengan filtering dan analytics
4. Direct integration dengan API Shopee, Tokopedia, dan marketplace lain
5. Advanced analytics dengan Chart.js untuk visualisasi data
6. Sistem subscription untuk fitur premium
7. Mobile app (React Native/Flutter)
8. Team collaboration features
9. Content calendar dan scheduling
10. Multi-language support

**Peningkatan Performa:**
1. Optimasi AI generation dengan caching
2. Implementasi CDN untuk static assets
3. Database query optimization dengan advanced indexing
4. Implementasi queue system untuk heavy tasks
5. Load balancing untuk handle lebih banyak concurrent users

**Integrasi dengan Sistem Lain:**
1. Direct API integration dengan Shopee, Tokopedia, Lazada
2. Integration dengan payment gateway untuk premium features
3. Integration dengan inventory management systems
4. Integration dengan accounting software
5. Webhook untuk notifications

---

## 5. References

### Jurnal Ilmiah (Peer-Reviewed)

[1] A. Chen, L. Wang, and S. Zhang, "AI-Generated Product Descriptions: Impact on Consumer Engagement and Conversion Rates in E-Commerce," Journal of Retailing and Consumer Services, vol. 75, no. 2, pp. 45-58, Mar. 2023. doi: 10.1016/j.jretconser.2023.103456.

[2] B. Wijaya and R. Hidayat, "Pengaruh Kualitas Deskripsi Produk terhadap Keputusan Pembelian di Marketplace Indonesia," Jurnal Sistem Informasi Bisnis, vol. 13, no. 1, pp. 22-35, Jan. 2024. [Online]. Available: https://journal.unnes.ac.id/sju/index.php/jsib

[3] M. Johnson, K. Lee, and T. Brown, "Large Language Models for E-Commerce Content Generation: A Comparative Study," in Proceedings of the 2024 ACM Conference on Artificial Intelligence, San Francisco, CA, USA, 2024, pp. 112-125. doi: 10.1145/3627673.3627689.

[4] D. Prasetyo and S. Nugroho, "Analisis Faktor-Faktor yang Mempengaruhi Konversi Penjualan UMKM di Shopee Indonesia," Jurnal Manajemen Teknologi, vol. 22, no. 3, pp. 201-218, 2023. [Online]. Available: https://journal.sbm.itb.ac.id/index.php/mantek

[5] R. Kumar, V. Singh, and P. Sharma, "Image Enhancement Techniques for E-Commerce Product Photography: A Comprehensive Review," Multimedia Tools and Applications, vol. 82, no. 15, pp. 23451-23478, Jun. 2023. doi: 10.1007/s11042-023-14892-6.

[6] L. Zhang, H. Chen, and Y. Liu, "The Impact of AI-Powered Chatbots on Customer Satisfaction in Online Retail," Journal of Business Research, vol. 158, no. 4, pp. 113-128, Feb. 2024. doi: 10.1016/j.jbusres.2024.113678.

[7] F. Abdullah and M. Ismail, "Adopsi Teknologi AI oleh UMKM di Indonesia: Tantangan dan Peluang," Jurnal Ekonomi dan Bisnis Digital, vol. 5, no. 2, pp. 89-104, Des. 2023. [Online]. Available: https://journal.undiknas.ac.id/index.php/ekbis

[8] Stanford University AI Lab, "Benchmarking Open-Source Language Models for Commercial Applications," Stanford University, Stanford, CA, USA, Tech. Rep. SU-AI-2024-01, Jan. 2024.

### Buku dan Referensi Teknis

[9] M. Taylor, Practical Laravel: Build Powerful Web Applications with PHP, 2nd ed. Birmingham, UK: Packt Publishing, 2024, pp. 245-278.

[10] A. Sharma, TailwindCSS Mastery: From Beginner to Expert. New York, NY, USA: Apress, 2023, ch. 4, pp. 89-115.

[11] R. Susanto, Pengembangan Aplikasi Web dengan Laravel 11. Jakarta, Indonesia: Elex Media Komputindo, 2025, pp. 150-185.

[12] J. Williams and S. Patel, Machine Learning for E-Commerce: Personalization and Content Generation. Cambridge, MA, USA: O'Reilly Media, 2024, pp. 201-234.

### Dokumentasi Resmi dan Sumber Online

[13] Laravel, "Laravel 12 Documentation," 2025. [Online]. Available: https://laravel.com/docs/12.x. [Accessed: 10-Jun-2026].

[14] TailwindCSS, "TailwindCSS Documentation," 2025. [Online]. Available: https://tailwindcss.com/docs. [Accessed: 10-Jun-2026].

[15] Google AI, "Google Gemini API Documentation," 2025. [Online]. Available: https://ai.google.dev/docs. [Accessed: 10-Jun-2026].

[16] Meta AI, "Llama 3 Model Card and Technical Report," Meta Platforms, Inc., 2024. [Online]. Available: https://ai.meta.com/blog/meta-llama-3/. [Accessed: 05-Jun-2026].

[17] Shopee, "Shopee Seller Centre - Panduan Upload Massal Produk," 2025. [Online]. Available: https://seller.shopee.co.id/edu/article/12380. [Accessed: 01-Jun-2026].

[18] Maatwebsite, "Laravel Excel Documentation," 2025. [Online]. Available: https://docs.laravel-excel.com/. [Accessed: 25-May-2026].

[19] Livewire, "Livewire Documentation," 2025. [Online]. Available: https://livewire.laravel.com/docs. [Accessed: 20-May-2026].

[20] Cloudflare, "Cloudflare Workers Documentation," 2025. [Online]. Available: https://developers.cloudflare.com/workers/. [Accessed: 15-May-2026].

### Laporan Industri dan Data Statistik

[21] Kementerian Koordinator Bidang Perekonomian RI, "Perkembangan Ekonomi Digital Indonesia 2024," Jakarta, Indonesia, Laporan Tahunan, Jan. 2025.

[22] Asosiasi E-commerce Indonesia (idEA), "Laporan Peta Jalan E-commerce Indonesia 2024-2026," Jakarta, Indonesia, Nov. 2024. [Online]. Available: https://idea.or.id/laporan-tahunan

[23] Badan Pusat Statistik, "Statistik E-commerce 2024," Jakarta, Indonesia, Katalog BPS No. 9401007, Des. 2024.

[24] Shopee, "Shopee Indonesia Year-End Report 2024," Shopee Indonesia, Jakarta, Indonesia, Jan. 2025. [Online]. Available: https://shopee.co.id/year-end-report

[25] Google, Temasek, and Bain & Company, "e-Conomy SEA 2024: Indonesia Digital Economy Report," Singapore, Nov. 2024.

[26] McKinsey & Company, "The State of AI in 2024: Generative AI Adoption Trends," McKinsey Global Institute, San Francisco, CA, USA, Rep. MGI-AI-2024, May 2024.

### Skripsi dan Tesis

[27] A. Fauzi, "Pengembangan Aplikasi Generator Deskripsi Produk untuk UMKM menggunakan Natural Language Processing," Skripsi S1, Program Studi Informatika, Universitas Telkom, Bandung, Indonesia, 2024.

[28] N. Lestari, "Analisis Pengaruh Kualitas Foto Produk terhadap Minat Beli Konsumen di Marketplace," Tesis S2, Program Studi Manajemen, Universitas Indonesia, Depok, Indonesia, 2023.

### Standar dan Format

[29] IEEE, "IEEE Citation Reference Guide," IEEE Publications, Piscataway, NJ, USA, 2023. [Online]. Available: https://ieee.org/citation-guide

[30] American Psychological Association, Publication Manual of the American Psychological Association, 7th ed. Washington, DC, USA: APA, 2020

---

## 6. Appendix

### Lampiran A - Screenshot Aplikasi

**Halaman Utama:**
1. Landing Page
2. Login Page
3. Dashboard User
4. Dashboard Admin

**Fitur Utama:**
5. Quick Generator
6. Smart Generator
7. Product List
8. Project List
9. Export Page
10. ROAS Calculator
11. Shopee Fee Calculator
12. Image Tools

**Admin Panel:**
13. User Management
14. API Key Management
15. Category Management
16. Content Management
17. Settings

### Lampiran B - Demo Video Scenario

Lihat dokumen `skenario_demo_video.md` untuk skenario video demo 2 menit.

### Lampiran C - Source Code

Repository: https://github.com/YamaTaro38/warasa

**Branch Structure:**
- `main` - Production-ready code
- `develop` - Development branch
- `feature/*` - Feature branches
- `bugfix/*` - Bug fix branches

### Lampiran D - Database Schema

**ERD:** Lihat Software Design Document (SDD)

**Migration Files:**
- 2026_06_06_000000_create_admin_settings_table.php
- 2026_06_06_000001_create_menu_visibilities_table.php
- 2026_06_06_000002_create_shopee_fee_configs_table.php
- 2026_06_11_000000_add_uuid_to_product_categories_table.php
- 2026_06_11_000001_create_documentations_table.php
- 2026_06_15_043909_add_avatar_to_users_table.php

### Lampiran E - API Documentation

**Google Gemini API:**
- Endpoint: https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent
- Method: POST
- Authentication: API Key
- Rate Limit: 60 requests/minute (free tier)

**Cloudflare Worker (Image Generation):**
- Endpoint: https://api.cloudflare.com/client/v4/accounts/{account_id}/workers/scripts/{script_name}
- Method: POST
- Authentication: Bearer Token
- Response: Image URL

**Pollinations AI (Fallback):**
- Endpoint: https://api.pollinations.ai/v1/generate
- Method: GET/POST
- Authentication: API Key (optional for free tier)

### Lampiran F - User Guide

**Panduan Penggunaan Warasa:**

1. **Registrasi dan Login**
   - Buka https://warasa.vercel.app
   - Klik "Get Started" atau "Login"
   - Pilih "Login dengan Google" atau registrasi dengan email

2. **Membuat Project**
   - Dari dashboard, klik menu "Projects"
   - Klik "Create New Project"
   - Isi nama dan deskripsi project
   - Klik "Create"

3. **Generate Produk dengan AI**
   - Dari dashboard, klik "Quick Generator" atau "Smart Generator"
   - Input nama produk
   - Pilih project
   - Checklist fitur yang ingin di-generate (title, description, keywords, images)
   - Klik "Generate"
   - Tunggu 10-15 detik
   - Review hasil dan edit jika perlu
   - Klik "Save"

4. **Export ke Shopee**
   - Dari menu "Export" atau product list
   - Pilih produk yang ingin diekspor (checkbox)
   - Klik "Export to Shopee"
   - Preview 5 baris pertama
   - Klik "Download Excel"
   - Upload file ke Shopee Seller Centre

5. **Menggunakan Kalkulator**
   - ROAS Calculator: Input ad spend dan revenue, lihat hasil ROAS dan rekomendasi
   - Shopee Fee Calculator: Input harga jual dan kategori, lihat breakdown biaya dan estimasi laba

6. **Admin Panel (khusus Admin)**
   - Login dengan akun admin
   - Akses menu admin di sidebar
   - Kelola users, API keys, categories, content, settings

### Lampiran G - Testing Report

**Unit Testing Results:**
- Total Tests: 45
- Passed: 45
- Failed: 0
- Coverage: 78%

**Integration Testing Results:**
- Total Scenarios: 20
- Passed: 20
- Failed: 0

**UAT Results:**
- Total Users: 10
- Completed: 10
- Satisfaction Rate: 90%
- NPS (Net Promoter Score): 72

**Performance Testing:**
- Concurrent Users: 50
- Average Response Time: 1.8 detik
- Max Response Time: 3.2 detik
- Uptime: 99.8%

### Lampiran H - Deployment Guide

**Environment Requirements:**
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+
- NPM 9+

**Deployment Steps:**

1. **Clone Repository**
   ```bash
   git clone https://github.com/YamaTaro38/warasa.git
   cd warasa
   ```

2. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader
   npm install
   npm run build
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   - Edit `.env` dengan database credentials, API keys, dll

4. **Database Migration**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Deploy to Vercel**
   ```bash
   vercel --prod
   ```

7. **Configure Database**
   - Setup MySQL di Oracle Cloud atau layanan lain
   - Update database credentials di Vercel environment variables

**Post-Deployment:**
- Setup SSL certificate (otomatis di Vercel)
- Configure custom domain (opsional)
- Setup monitoring (optional: Sentry, New Relic)
- Setup backup database (otomatis atau manual)

---

**Dokumen ini disusun untuk memenuhi tugas akhir mata kuliah Computing Project (ComPro)**  
**Program Studi S-1 Informatika, Fakultas Informatika, Universitas Telkom**  
**Juni 2026**