# Lander — Laravel Portfolio

A personal portfolio built with **Laravel 12, PHP 8.2+, Blade, Tailwind CSS 4, and Vite 7**. Includes all ten supplied projects, category filters, individual project pages, responsive layouts, and the SDS public website link. The artwork is conceptual, rather than screenshots of the government systems.

## Start on Windows / XAMPP

Extract the `lander-portfolio-laravel` folder into your XAMPP `htdocs` directory. Open Command Prompt there. For example:

```bat
cd /d D:\xampp\htdocs\lander-portfolio-laravel
composer install
copy .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan serve --host=127.0.0.1
```

Open **http://127.0.0.1:8000**. Your actual XAMPP drive may differ.

The zip includes compiled frontend assets. Rebuild with `npm run build` after editing styles or Blade utility classes. PHP Composer packages and `node_modules` are not bundled.

For live frontend changes, use two terminals:

```bat
php artisan serve --host=127.0.0.1
```

```bat
npm run dev
```

Node 20.19+ or 22.12+ is required by Vite 7; your Node 24 setup is suitable. Keep `PHP_CLI_SERVER_WORKERS` unset on Windows. The default configuration uses **file sessions**, **file cache**, and a **synchronous queue**; the portfolio does not query a database and does not require migrations.

## Edit your portfolio

- `config/portfolio.php`: profile, technical skills, project titles, descriptions, roles, status, and public URLs.
- `app/Http/Controllers/PortfolioController.php`: project retrieval, category filtering, and 404 handling.
- `routes/web.php`: homepage and `/projects/{project}` routes.
- `resources/views/layouts/app.blade.php`: shared head, navigation, and footer.
- `resources/views/portfolio/index.blade.php`: homepage sections and project list.
- `resources/views/portfolio/show.blade.php`: project detail page.
- `resources/views/portfolio/partials/artwork.blade.php`: conceptual featured-project artwork.
- `resources/css/app.css`: Tailwind entrypoint, theme, component styling, and artwork.

After changing the configuration on a server that caches config, run `php artisan config:clear` or rebuild the config cache as part of deployment. Do not add framework helper calls or closures inside the portfolio configuration file.

All project links and filters are rendered by Laravel and work with JavaScript disabled. Public external links open in a new tab. Sagad remains marked **In progress**; TIMTA is described as **Maintenance**. No contact form, admin panel, or authentication has been added.

## Verification

`npm run build` completed successfully when preparing this source. PHP and Composer could not be run in the preparation environment; the Laravel runtime and feature tests remain to be verified on your machine:

```bat
php artisan route:list --except-vendor
php artisan view:cache
php artisan test --filter=PortfolioTest
```

The feature suite covers all ten detail pages, category isolation, the Sagad status, the SDS URL, and invalid category/project handling.

## PHP hosting

Point the web server document root at this project's **public** directory. Set `APP_ENV=production`, `APP_DEBUG=false`, and the correct HTTPS `APP_URL` in the server's `.env`. Generate a unique application key, install dependencies, build assets, and ensure `storage` and `bootstrap/cache` are writable. Do not upload the project into a publicly served directory that exposes `.env` or source files.

The earlier ChatGPT-hosted static preview is separate. This archive is the PHP/Laravel implementation for local development or PHP-capable hosting.

## References

- https://laravel.com/docs/12.x/installation
- https://tailwindcss.com/docs/installation/framework-guides/laravel/vite
- Official Laravel 12 application skeleton: https://github.com/laravel/laravel/tree/12.x
