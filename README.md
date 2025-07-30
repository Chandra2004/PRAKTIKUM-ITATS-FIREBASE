# THE-FRAMEWORK - MVC Native PHP Framework

## 📌 Pengenalan

**THE-FRAMEWORK** adalah framework PHP berbasis MVC (Model-View-Controller) yang dibuat oleh **Chandra Tri A**. Framework ini dirancang untuk memberi struktur yang bersih dan terorganisir pada aplikasi PHP, dengan fitur-fitur utama:

- Manajemen namespace dinamis PSR‑4
- Blade Templating
- Migrasi dan seeding database
- Artisan CLI untuk scaffolding dan manajemen proyek
- Support folder `resources/Views` dan fallback ke `services/`
- Upload file terstruktur di folder `private-uploads/`

## 🚀 Instalasi

### Langkah-langkah

1. **Clone Proyek**:
   ```bash
   git clone https://github.com/Chandra2004/FRAMEWORK.git
   cd FRAMEWORK
   ```

2. **Install Dependensi**:
   ```bash
   composer install
   ```

3. **Setup Proyek Awal**:
   ```bash
   php artisan setup
   ```
   - Perintah ini akan membuat `.env`, memperbarui namespace, dan mempersiapkan struktur awal.

4. **Generate Key Enkripsi**:
   ```bash
   php artisan key:generate
   ```
   - Perintah ini akan menghasilkan `APP_KEY` secara aman dan otomatis menuliskannya ke `.env`.

5. **Jalankan Server**:
   ```bash
   php artisan serve
   ```
   Akses di `http://localhost:8080`.

### Persyaratan
- PHP 8.0+
- Composer
- MySQL (atau kompatibel)

## 📂 Struktur Direktori
```
FRAMEWORK/
├── app/
│   ├── App/
│   │   ├── Blueprint.php
│   │   ├── CacheManager.php
│   │   ├── Config.php
│   │   ├── Database.php
│   │   ├── ImageOptimizer.php
│   │   ├── Logging.php
│   │   ├── RateLimiter.php
│   │   ├── Router.php
│   │   ├── Schema.php
│   │   ├── SessionManager.php
│   │   └── View.php
│   ├── Database/
│   │   └── Migration.php
│   ├── Helpers/
│   │   ├── Helper.php
│   │   └── helpers.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ErrorController.php
│   │       └── HomeController.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   ├── CsrfMiddleware.php
│   │   ├── Middleware.php
│   │   ├── ValidationMiddleware.php
│   │   └── WAFMiddleware.php
│   ├── Models/
│   │   ├── Seeders/
│   │   │   └── UserSeeder.php
│   │   └── HomeModel.php
│   ├── Storage/
│   │   ├── cache/                 
│   │   └── logs/                  
│   └── BladeInit.php
├── database/
│   ├── migrations/
│   │   └── UsersTable.php
│   └── seeders/
│       └── UserSeeder.php
├── private-uploads/
│   ├── dummy/
│   └── user-pictures/
├── resources/
│   ├── css/
│   ├── js/
│   └── Views/
│       └── (...file blade di sini)
├── services/
│   ├── error/
│   │   ├── 404.blade.php
│   │   ├── 500.blade.php
│   │   ├── maintenance.blade.php
│   │   └── payment.blade.php
│   └── debug/
│       ├── exception.blade.php
│       └── fatal.blade.php
├── vendor/
├── .env
├── .env.example
├── .gitignore
├── .htaccess 
├── file.php  
├── index.php 
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

## 🔧 Perintah Artisan

- **Setup proyek**        : `php artisan setup`
- **Generate key**        : `php artisan key:generate`
- **Jalankan server**     : `php artisan serve`
- **Migrasi database**    :
  - `php artisan migrate`
  - `php artisan migrate:fresh`
  - `php artisan rollback`
- **Seeding data**        :
  - `php artisan seed`
  - `php artisan seed --class=ClassName`
- **Scaffold file**       :
  - `php artisan make:controller NameController`
  - `php artisan make:model NameModel`
  - `php artisan make:seeder NameSeeder`
  - `php artisan make:migration CreateNameTable`
  - `php artisan make:middleware NameMiddleware`

> Semua file yang dihasilkan akan menggunakan namespace sesuai PSR‑4 di `composer.json`.

## 🌐 Konfigurasi ENV

Sesuaikan file `.env`:
```ini
APP_ENV=local
APP_DEBUG=false
APP_NAME=TheFramework

BASE_URL=http://localhost:8080

ENCRYPTION_KEY=generated_key_here
APP_KEY=generated_app_key_here

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=the_framework
DB_USER=root
DB_PASS=
```

## 🌐 Konfigurasi Jika Menggunakan Google Project IDX

Sesuaikan file `idx/dev.nix`:
```
{ pkgs, ... }: {
  channel = "stable-24.05";
  packages = [
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.nodejs_20
    pkgs.python3
    pkgs.tailwindcss
  ];
  services.mysql = {
    enable = true;
    package = pkgs.mariadb;
  };
  env = {
    PHP_PATH = "${pkgs.php83}/bin/php";
  };
  idx = {
    extensions = [
      "rangav.vscode-thunder-client"
      "amirmarmul.laravel-blade-vscode"
      "bradlc.vscode-tailwindcss"
      "cweijan.dbclient-jdbc"
      "cweijan.vscode-database-client2"
      "formulahendry.vscode-mysql"
      "imgildev.vscode-tailwindcss-snippets"
      "onecentlin.laravel-blade"
      "shufo.vscode-blade-formatter"
      "yandeu.five-server"
    ];
    previews = {
      enable = true;
      previews = {
        web = {
          command = ["php" "-S" "localhost:$PORT" "-t" "htdocs"];
          manager = "web";
        };
      };
    };
    workspace = {
      onCreate = {
        default.openFiles = ["index.php"];
      };
      onStart = {
        run-server = "php -S localhost:8080";
      };
    };
  };
}
```

## 🤝 Kontribusi

Kami terbuka untuk kontribusi! Silakan buat pull request atau hubungi:

- WhatsApp: 085730676143
- Email   : chandratriantomo123@gmail.com
- Website : https://www.the-framework.ct.ws
