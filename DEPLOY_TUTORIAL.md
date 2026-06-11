# Tutorial Deploy Laravel ke Vercel dengan Database di Aiven

## Overview

Project ini menggunakan:
- **Laravel 12** (PHP 8.2+)
- **Vite** untuk frontend assets
- **Livewire** untuk interaktivitas
- **SQLite** (development) → **MySQL** di Aiven (production)
- **Vercel** untuk hosting (serverless PHP)

---

## Bagian 1: Setup Database di Aiven

### Langkah 1: Buat Akun Aiven

1. Buka [https://aiven.io](https://aiven.io)
2. Klik **Sign Up** (bisa daftar pakai GitHub/Google)
3. Pilih **Free tier** (gratis untuk MySQL/PostgreSQL)

### Langkah 2: Buat Service Database

1. Login ke [https://console.aiven.io](https://console.aiven.io)
2. Klik **Create service**
3. Pilih **MySQL** (recommended untuk Laravel)
4. Pilih cloud provider & region terdekat (misal: `aws` / `ap-southeast-1` Singapore)
5. Pilih plan: **Hobby - Startup** (gratis)
6. Klik **Create**
7. **Tunggu** sampai status service berubah menjadi **Running** (biasanya 2-3 menit)

### Langkah 3: Kumpulkan Informasi Koneksi

Setelah service selesai dibuat, klik nama service Anda dan pergi ke tab **Overview**. Catat informasi berikut:

| Field | Nilai |
|-------|-------|
| Host | `mysql-xxx-yyy.aivencloud.com` |
| Port | `25060` (default MySQL di Aiven) |
| Database Name | `defaultdb` |
| Username | `avnadmin` |
| Password | `xxxxxxx` (klik icon mata untuk reveal) |

> **PENTING**: Simpan password ini dengan aman. Anda akan membutuhkannya di langkah berikutnya.

### Langkah 4: Aktifkan SSL (Opsional tapi Recommended)

Aiven mengharuskan koneksi SSL. Di tab **Overview**, scroll ke bawah dan klik **Download CA Certificate** untuk file `ca.pem`. File ini akan digunakan oleh Laravel untuk koneksi yang aman.

---

## Bagian 2: Setup Environment Variables di Vercel

### Langkah 1: Login ke Vercel CLI

```bash
# Install Vercel CLI jika belum ada
npm i -g vercel

# Login
vercel login
```

### Langkah 2: Set Environment Variables

Set variabel environment ini di Vercel (bisa via dashboard atau CLI):

**Via Dashboard (Recommended):**
1. Buka [https://vercel.com/dashboard](https://vercel.com/dashboard)
2. Klik project **warasa** (atau nama project Anda)
3. Klik tab **Settings** → **Environment Variables**
4. Tambahkan variabel-variabel berikut:

| Name | Value | Environment |
|------|-------|-------------|
| `APP_ENV` | `production` | Production |
| `APP_DEBUG` | `false` | Production |
| `APP_KEY` | (generate dulu, lihat langkah 3) | Production |
| `APP_URL` | `https://warasa.vercel.app` (sesuaikan) | Production |
| `DB_CONNECTION` | `mysql` | Production |
| `DB_HOST` | `mysql-xxx-yyy.aivencloud.com` | Production |
| `DB_PORT` | `25060` | Production |
| `DB_DATABASE` | `defaultdb` | Production |
| `DB_USERNAME` | `avnadmin` | Production |
| `DB_PASSWORD` | `xxxxxxx` (password dari Aiven) | Production |
| `SESSION_DRIVER` | `database` | Production |
| `QUEUE_CONNECTION` | `database` | Production |
| `CACHE_STORE` | `database` | Production |
| `FILESYSTEM_DISK` | `local` | Production |
| `MAIL_MAILER` | `log` | Production |
| `GOOGLE_CLIENT_ID` | `(dari Google Cloud Console)` | Production |
| `GOOGLE_CLIENT_SECRET` | `(dari Google Cloud Console)` | Production |
| `GOOGLE_REDIRECT_URI` | `https://warasa.vercel.app/auth/google/callback` | Production |

**Via CLI (alternatif):**
```bash
# Jalankan perintah berikut satu per satu dari root project
vercel env add APP_ENV production
vercel env add APP_DEBUG false
vercel env add APP_KEY production
vercel env add APP_URL production
vercel env add DB_CONNECTION production
vercel env add DB_HOST production
vercel env add DB_PORT production
vercel env add DB_DATABASE production
vercel env add DB_USERNAME production
vercel env add DB_PASSWORD production
vercel env add SESSION_DRIVER database
vercel env add QUEUE_CONNECTION database
vercel env add CACHE_STORE database
```

### Langkah 3: Generate APP_KEY

Anda bisa generate APP_KEY secara lokal lalu paste ke Vercel:

```bash
# Jalankan di terminal lokal
php artisan key:generate --show
```

Copy hasil outputnya, lalu set di Vercel environment variable:
- Name: `APP_KEY`
- Value: `base64:xxxxx...` (paste hasil di atas)
- Environment: Production

---

## Bagian 3: Konfigurasi SSL untuk Koneksi Aiven

Karena Aiven mengharuskan SSL, buat atau update file berikut di project:

### Buat file `config/database.php` (jika belum ada atau sesuaikan config MySQL)

Pastikan di `config/database.php` bagian MySQL connection sudah benar:

```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DB_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
    'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

**Catatan**: Jika koneksi SSL bermasalah, Anda bisa menonaktifkan SSL verification dengan menambahkan opsi berikut:

```php
'options' => extension_loaded('pdo_mysql') ? array_filter([
    PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
]) : [],
```

> ⚠️ **Catatan keamanan**: Menonaktifkan SSL verification hanya untuk debugging. Untuk production, gunakan SSL certificate yang benar.

---

## Bagian 4: Setup Build Command untuk Vercel

### Update `vercel.json`

File `vercel.json` Anda sudah cukup baik. Namun, pastikan `installCommand` juga menjalankan build assets frontend dan migrasi database:

Update `vercel.json`:

```json
{
    "version": 2,
    "installCommand": "npm install --legacy-peer-deps && npm run build",
    "buildCommand": "php artisan migrate --force",
    "functions": {
        "api/index.php": {
            "runtime": "vercel-php@0.6.2"
        }
    },
    "routes": [
        {
            "src": "/build/(.*)",
            "dest": "/public/build/$1"
        },
        {
            "src": "/(css|js|images|assets)/(.*)",
            "dest": "/public/$1/$2"
        },
        {
            "src": "/favicon.ico",
            "dest": "/public/favicon.ico"
        },
        {
            "src": "/storage/(.*)",
            "dest": "/public/storage/$1"
        },
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        }
    ],
    "outputDirectory": "public"
}
```

### ⚠️ Alternatif: Migrate via Build Command atau Post-Deploy Hook

Karena Vercel serverless tidak menjalankan artisan secara default, Anda punya beberapa opsi untuk menjalankan migration:

#### Opsi A: Menggunakan Build Command (Recommended untuk simplicity)
```json
"buildCommand": "php artisan migrate --force"
```

#### Opsi B: Menggunakan Vercel Post-Deploy Hook
Tambahkan di `vercel.json`:
```json
{
    "hooks": [
        {
            "src": "api/index.php",
            "dest": "/api/index.php"
        }
    ]
}
```

#### Opsi C: Manual Migration
Jalankan migration secara manual via Vercel CLI:
```bash
vercel --prod
# Lalu di production environment, jalankan:
# php artisan migrate --force
```

---

## Bagian 5: Deploy ke Vercel

### Langkah 1: Pastikan Semua Sudah di Push ke GitHub

```bash
# Dari root project
git add .
git commit -m "chore: prepare for vercel deployment"
git push origin main
```

### Langkah 2: Connect Project ke Vercel

**Via Dashboard:**
1. Buka [https://vercel.com/new](https://vercel.com/new)
2. Pilih **Import Git Repository**
3. Pilih repository `YamaTaro38/warasa`
4. Vercel akan mendeteksi framework secara otomatis
5. Pada **Build and Output Settings**, pastikan:
   - **Framework Preset**: Other
   - **Build Command**: `npm install --legacy-peer-deps && npm run build`
   - **Output Directory**: `public`
   - **Install Command**: `npm install --legacy-peer-deps`
6. Klik **Deploy**

**Via CLI:**
```bash
# Dari root project
vercel --prod
```

### Langkah 3: Tunggu Deploy Selesai

Proses deploy biasanya memakan waktu 1-3 menit. Monitor prosesnya di dashboard Vercel atau di terminal.

---

## Bagian 6: Post-Deployment Checklist

### 1. Jalankan Migration (Jika Belum di Build Command)

Jika migration belum jalan otomatis, buka terminal Vercel atau jalankan:
```bash
# Via Vercel CLI dengan SSH (jika tersedia)
vercel env pull .env.production.local
```

Atau buat script khusus untuk migration di production. Cara termudah adalah dengan menambahkan migration ke `buildCommand`.

### 2. Seed Database (Jika Diperlukan)

Jika ingin menjalankan seeder di production:
```bash
# Tambahkan ke buildCommand di vercel.json:
"buildCommand": "php artisan migrate --force && php artisan db:seed --force"
```

> ⚠️ Hati-hati dengan seeder di production! Pastikan seeder idempotent (aman dijalankan berulang kali).

### 3. Generate Storage Link

```bash
# Tambahkan ke buildCommand:
php artisan storage:link --force
```

**Catatan**: Di Vercel, filesystem lokal bersifat ephemeral (hilang setiap cold start). Untuk menyimpan file secara permanen, gunakan cloud storage seperti:
- [AWS S3](https://aws.amazon.com/s3/)
- [Cloudinary](https://cloudinary.com/)
- [Vercel Blob](https://vercel.com/docs/storage/vercel-blob)

Jika ingin menggunakan S3, tambahkan environment variable:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=xxx
AWS_SECRET_ACCESS_KEY=xxx
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=your-bucket-name
```

### 4. Cek Aplikasi

Buka URL deployment Anda:
```
https://warasa.vercel.app
```

### 5. Update Google OAuth Redirect URI

Jika menggunakan Google OAuth, pastikan redirect URI di [Google Cloud Console](https://console.cloud.google.com/) sudah diupdate:

- **Redirect URI**: `https://warasa.vercel.app/auth/google/callback`

---

## Troubleshooting

### Error 500 / Application Error

1. **Cek Environment Variables**: Pastikan semua env var sudah ter-set dengan benar
2. **Disable APP_DEBUG di Production**: Set `APP_DEBUG=false` dan cek logs di Vercel dashboard
3. **Cek Logs**: Buka Vercel Dashboard → Project → Logs

### Database Connection Error

1. **Periksa host/port**: Pastikan benar `mysql-xxx-yyy.aivencloud.com` port `25060`
2. **Whitelist IP**: Di Aiven, pastikan **IP Access List** mengizinkan IP Vercel. Biasanya Aiven sudah mengizinkan semua IP (`0.0.0.0/0`) secara default untuk plan gratis
3. **SSL**: Pastikan SSL connection dikonfigurasi dengan benar

### Assets CSS/JS Tidak Load

1. Pastikan `npm run build` sudah dijalankan saat deploy
2. Cek route `/build/(.*)` ada di `vercel.json`
3. Pastikan file build ada di `public/build/`

### Session/Cache Error

Pastikan environment variable berikut sudah benar:
```
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Dan database sudah di-migrate dengan table `sessions`, `cache`, dan `jobs`.

### PHP Version Error

Vercel PHP runtime (`vercel-php@0.6.2`) mendukung PHP 8.x. Jika ada error, coba cek versi PHP di logs.

---

## Ringkasan Environment Variables untuk Production

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxx...
APP_URL=https://warasa.vercel.app
APP_LOCALE=id
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=mysql-xxx-yyy.aivencloud.com
DB_PORT=25060
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=xxxxxxx

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

BROADCAST_CONNECTION=log
MAIL_MAILER=log

GOOGLE_CLIENT_ID=xxxxx
GOOGLE_CLIENT_SECRET=xxxxx
GOOGLE_REDIRECT_URI=https://warasa.vercel.app/auth/google/callback
```

---

## Tips Penting

1. **Gunakan Branch Deploy**: Vercel mendukung preview deployment untuk branch. Deploy ke preview dulu sebelum merge ke production.
2. **Environment Variables per Environment**: Di Vercel, Anda bisa set environment variables berbeda untuk Production, Preview, dan Development.
3. **Vercel Hobby Plan**: Vercel free tier memiliki limit 100GB bandwidth/bulan dan 1000 serverless function executions/hari.
4. **Aiven Free Tier**: Aiven free tier memberikan 1 service gratis (500MB storage, 1 bulan).
5. **Database Migrations**: Untuk project production, pertimbangkan menggunakan `php artisan migrate --force` hanya di build time atau via manual trigger, bukan di setiap deploy.

---

*Tutorial ini dibuat khusus untuk project warasa - Laravel 12 + Vercel + Aiven MySQL*