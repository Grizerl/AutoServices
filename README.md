<div align="center">

# 🚗 Auto Service

**A complete website for a car service: public site, cars for sale, subscription plans and an admin panel.**

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5-646CFF?logo=vite&logoColor=white)
![SCSS](https://img.shields.io/badge/SCSS-CC6699?logo=sass&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Tests](https://img.shields.io/badge/tests-110%20passing-2e9e57)

</div>

---

## Table of contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Quick start](#quick-start)
  - [With Laradock (PHP 8.4)](#with-laradock-php-84)
  - [Without Docker](#without-docker)
- [Configuration](#configuration)
- [Admin panel](#admin-panel)
- [Pages and routes](#pages-and-routes)
- [Project structure](#project-structure)
- [Front-end](#front-end)
- [Testing](#testing)
- [Deployment](#deployment)
- [Notes](#notes)

## Features

### Public website
- **Home page** with hero slider, services, advantages, featured cars, team, testimonials slider and a booking form.
- **Cars for sale**: catalog with search, brand / fuel / transmission / price filters, sorting and pagination (filters work **without page reload**); a page for every car with specs, discount badge and a *Request this car* form.
- **Monthly subscriptions**: plans stored in the database, monthly/yearly price toggle, checkout form and a confirmation with a request number. No payment is taken online – a manager confirms every request.
- **About**, **News & FAQ** (sliders and an accordion), **Partners** and **Contacts** (details, map, question form) pages.
- Responsive from 320 px up, accessible burger menu, scroll animations (respecting `prefers-reduced-motion`), back-to-top button, sticky header.
- **Forms without reloads**: every public form is sent with `fetch()`. Laravel validates the request and the errors are highlighted next to each field; without JavaScript the forms still work as normal forms. Public forms are rate limited.
- Everything is **self-hosted** (fonts, icons, Swiper) – no blocking third-party requests.

### Admin panel (AdminLTE)
- Dashboard with counters and notifications for new requests.
- **Blog posts**, **reviews**, **team members** (photo upload), **repair requests** (status workflow), **questions**.
- **Cars for sale**: photo upload, Available / Reserved / Sold status, old price → discount badge, featured flag; **car requests** (New → Contacted → Closed).
- **Subscription plans** and **subscriptions**: activating a subscription fills in its term automatically; the price and plan name are frozen when the request is made.
- Pagination, flash messages, validation, responsive tables, role protection (`Admin`).

## Tech stack

| Layer      | Technology                                                                 |
| ---------- | -------------------------------------------------------------------------- |
| Backend    | PHP 8.4, Laravel 11, Laravel UI / Fortify, spatie/laravel-permission       |
| Database   | MySQL (SQLite in memory for tests)                                         |
| Front-end  | Blade, SCSS, vanilla JS, Swiper 11, Font Awesome 6, Bootstrap 5 (auth pages) |
| Admin UI   | AdminLTE 3 + custom SCSS                                                   |
| Tooling    | Vite 5, PHPUnit 11, Laradock                                               |

## Quick start

### With Laradock (PHP 8.4)

1. In your Laradock `.env` make sure the PHP 8.4 containers are available (`php-fpm-84`, `workspace-84`) together with `nginx` and `mysql`.
2. Add an nginx site for the project, for example `auto.local`:

   ```nginx
   server {
       listen 80;
       server_name auto.local;
       root /var/www/<path-to-project>/public;
       index index.php;

       client_max_body_size 64M;

       location / { try_files $uri $uri/ /index.php$is_args$args; }

       location ~ \.php$ {
           try_files $uri /index.php =404;
           fastcgi_pass php-fpm-84:9000;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```
3. Add `127.0.0.1 auto.local` to your `hosts` file.
4. Create the database (e.g. `auto`) and configure `.env` (see [Configuration](#configuration), host is `mysql`).
5. Run the commands inside the workspace container:

   ```bash
   docker compose exec workspace-84 bash
   cd /var/www/<path-to-project>
   umask 000                         # keep new files writable for php-fpm
   composer install
   cp .env.example .env && php artisan key:generate
   php artisan migrate --seed
   ```
6. Build the front-end on the host (Node 18+; the workspace image may ship an older Node):

   ```bash
   npm install
   npm run build
   ```
7. Open <http://auto.local>.

### Without Docker

Requirements: PHP 8.4 (`pdo_mysql` / `pdo_sqlite`, `gd`, `intl`, `mbstring`, `zip`), Composer 2, Node 18+, MySQL 8 (or SQLite).

```bash
composer install
cp .env.example .env
php artisan key:generate
# set DB_* in .env (or keep DB_CONNECTION=sqlite and `touch database/database.sqlite`)
php artisan migrate --seed

npm install
npm run build        # or `npm run dev` for hot reload

php artisan serve    # http://127.0.0.1:8000
```

## Configuration

Main `.env` values:

| Variable                       | Description                                                       |
| ------------------------------ | ----------------------------------------------------------------- |
| `APP_URL`                      | Public URL (also used for uploaded file URLs), e.g. `http://auto.local` |
| `DB_CONNECTION`, `DB_HOST` …   | Database connection (`DB_HOST=mysql` inside Laradock)             |
| `ADMIN_EMAIL`, `ADMIN_PASSWORD`| First administrator created by the seeder                         |
| `MAIL_*`                       | Mail settings (the default `log` driver only writes to the log)   |

`php artisan db:seed` runs:

- `RoleSeeder` – `Admin` and `User` roles,
- `AdminUserSeeder` – the first administrator (outside production the defaults below are used; **in production set `ADMIN_PASSWORD` first**, otherwise no admin is created),
- `SubscriptionPlanSeeder` – default Basic / Standard / Premium plans (every environment),
- `DemoContentSeeder`, `DemoCarsSeeder` – sample content and cars (not in production).

## Admin panel

| | |
| --- | --- |
| URL | `/control` (prefix defined in `routes/web.php`) |
| Login page | `/login` |
| Development account | `admin@auto.local` / `password` |

Only users with the `Admin` role can open the panel. Change the development password before publishing the site.

## Pages and routes

| Page                     | URL                                      |
| ------------------------ | ---------------------------------------- |
| Home                     | `/`                                      |
| About the company        | `/About/History`                         |
| News & FAQ               | `/About/News`                            |
| Cars for sale            | `/Pages/Offer`                           |
| Car page                 | `/Pages/Offer/{id}`                      |
| Subscription plans       | `/Pages/Pricing/Plan`                    |
| Subscription checkout    | `/Pages/Pricing/Plan/{plan}/subscribe`   |
| Partners                 | `/Pages/Partners`                        |
| Contacts                 | `/Contacts/Detailed`                     |
| Admin panel              | `/control`                               |

The full list is available with `php artisan route:list`.

## Project structure

```text
app/
  Http/Controllers/Auto/      public site controllers
  Http/Controllers/Admin/     admin panel controllers
  Http/Requests/              form requests (all validation rules)
  Models/                     Car, Subscription, SubscriptionPlan, Members, ...
  Models/Concerns/            HasUploadedImage (photo handling)
database/
  migrations/  seeders/
resources/
  views/
    layouts/  partials/  components/   shared layouts, header, banner, form fields
    auto/                              public pages
    admin/                             admin pages
  scss/                                SCSS source (abstracts, base, layout, components, pages)
  js/                                  Vite entries (site.js, admin.js)
public/
  assets/js/                           page scripts (index.js, about.js, plan.js)
  uploads/                             uploaded photos (git-ignored)
tests/Feature/                         PHPUnit tests
```

## Front-end

Styles are SCSS compiled by Vite into `public/build` (git-ignored – run `npm run build` after pulling).

| Entry                        | Used by                                         |
| ---------------------------- | ----------------------------------------------- |
| `resources/js/site.js` + `resources/scss/site.scss` | public website            |
| `resources/js/admin.js` + `resources/scss/admin.scss` | admin panel overrides on top of AdminLTE |
| `resources/sass/app.scss` + `resources/js/app.js`   | login / register pages (Bootstrap 5) |

- Page-specific styles are scoped with a `page-*` class on `<body>` (`@section('body-class', 'page-home')`).
- Design tokens (colours, radii, shadows, breakpoints) live in `resources/scss/abstracts/`.
- Behaviour that is not bundled (sliders, menu, AJAX forms, scroll reveal) is in `public/assets/js/index.js`.
- Uploaded photos use the `uploads` disk (`public/uploads`), so no `storage:link` is needed.

## Testing

```bash
php artisan test
```

110 feature tests (SQLite in memory) cover public pages, forms (normal and AJAX), the cars catalog, the subscription flow and all admin sections including access control and file uploads.

## Deployment

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan db:seed --force     # roles, plans (+ admin when ADMIN_PASSWORD is set)
npm ci && npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Point the web server document root to `public/`, make `storage`, `bootstrap/cache` and `public/uploads` writable, and set `APP_ENV=production`, `APP_DEBUG=false` and a real `APP_URL`.

## Notes

- **Laravel 11 security advisories:** Composer blocks all 11.x releases because the branch no longer receives security fixes, so only targeted updates were made. Upgrading to a supported Laravel version is recommended before a public launch.
- Social network links in the header are placeholders (`#`) – add the real URLs in `resources/views/partials/site-header.blade.php`.
- Contact details (address, phones, working hours) are sample data; update them in the header partial, the contact strip (`partials/contact-strip.blade.php`), the footer (`layouts/auto_layouts.blade.php`) and the contacts page.

## License

Private project. All rights reserved.
