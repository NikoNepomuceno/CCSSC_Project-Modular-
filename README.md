## Getting Started

### 1. Install PHP dependencies (backend)

```sh
composer install
```

### 2. Install Node.js dependencies (frontend)

```sh
npm install
```

### 3. Run database migrations (if needed)

```sh
php artisan migrate
```

### 4. Start the Laravel backend server

```sh
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

### 5. Start the Vite development server (for hot reload)

```sh
npm run dev
```

-   This enables automatic browser refresh for changes in `resources/js`, `resources/css`, and Blade files.
-   Make sure your Node.js version is **20.19+** or **22.12+**.

---

## Quick Start (Full Workflow)

```sh
composer install
npm install
php artisan migrate
php artisan serve
npm run dev
```

-   Open [http://localhost:8000](http://localhost:8000) in your browser.
-   Edit your frontend files and see changes instantly with hot reload.

---

## Modular structure overview (feature-first)

This project uses a feature-first, modular layout under `app/Modules`. Each module owns its routes, controllers, and views. Example modules included:

-   `Home` → serves `/`
-   `News` → serves `/newsPage`

### What changed

-   Added PSR-4 autoload for `App\Modules\` in `composer.json`.
-   Added `App\Providers\ModulesServiceProvider` to auto-load module routes, views, translations, migrations, and config.
-   Registered the provider in `bootstrap/providers.php`.
-   Moved page views into module view namespaces and simplified `routes/web.php`.

### Where things live now

```
app/Modules/
  Home/
    Http/Controllers/HomeController.php
    Resources/views/welcome.blade.php
    routes/web.php
  News/
    Http/Controllers/NewsController.php
    Resources/views/index.blade.php
    routes/web.php
```

Root routes file:

```
routes/web.php  → (left minimal) modules register their own routes
```

### How it works

-   On boot, `ModulesServiceProvider` scans `app/Modules/*` and for each module:
    -   Loads `routes/web.php` with `web` middleware
    -   Loads `routes/api.php` with `api` middleware (if present)
    -   Registers views from `Resources/views` under a kebab-case namespace of the module name (e.g., `Home` → `home`, `News` → `news`)
    -   Optionally loads translations (`Resources/lang`), migrations (`database/migrations`), and config (`Config/config.php`)

---

This lets you render module views via namespaced lookups, e.g.:

```php
return view('home::welcome');   // from Home module
return view('news::index');     // from News module
```

### Add a new module (quick start)

1. Create folders:

```
app/Modules/Blog/
  Http/Controllers/
  Resources/views/
  routes/
```

2. Controller `app/Modules/Blog/Http/Controllers/BlogController.php`:

```php
<?php
namespace App\Modules\Blog\Http\Controllers;
use Illuminate\Routing\Controller;

class BlogController extends Controller {
    public function index() { return view('blog::index'); }
}
```

3. Routes `app/Modules/Blog/routes/web.php`:

```php
<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Blog\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
```

4. View `app/Modules/Blog/Resources/views/index.blade.php`:

```blade
<h1>Blog</h1>
```

5. Refresh and verify:

```
composer dump-autoload
php artisan config:clear route:clear view:clear
php artisan route:list --path=blog
```

### Commands you may need

-   Regenerate autoload and clear caches after adding/moving modules:

```
composer dump-autoload && php artisan config:clear && php artisan route:clear && php artisan view:clear
```

### Notes

-   Shared layouts/partials can remain under `resources/views` or you can introduce a `Core` module for cross-cutting concerns.
-   Module view namespace is kebab-case of the folder name: `PaymentsGateway` → `payments-gateway::...`.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
