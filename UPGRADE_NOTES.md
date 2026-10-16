# CineTrack Enhanced Version

This version keeps the original Module 4 Laravel MVC CRUD requirements and adds presentation, authentication, authorization, and usability improvements.

## Added Features

- Separate Administrator and User login portals
- User registration
- Role-based authorization middleware
- Secure logout with confirmation
- Dashboard with watchlist statistics
- Personal movie ownership (`users` one-to-many `movies`)
- Administrator can view all movie records
- Regular users can only view/edit/delete their own movie records
- Favorites feature
- Search plus status/genre/year filters
- Pagination
- Responsive sidebar navigation and polished layout
- User profile and password update
- Administrator user-account management
- Owner information for administrators
- Existing CRUD, validation, CSRF, Blade views, Eloquent Model, migration, and `Route::resource()` remain intact

## New Database Changes

Run:

```powershell
php artisan migrate
php artisan db:seed
```

The new migrations add:

- `users.role`
- `movies.user_id`
- `movies.is_favorite`

Legacy movie records with no owner are assigned to the demo administrator when the seeder runs.

## Demo Accounts

Administrator:

- Email: `admin@cinetrack.test`
- Password: `Admin@12345`

User:

- Email: `user@cinetrack.test`
- Password: `User@12345`

Change these credentials if this project will be used outside a classroom/demo environment.

## Recommended Local Setup

```powershell
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan optimize:clear
php artisan serve
```

By default `.env.example` uses SQLite for portability. If your existing `.env` already uses MySQL, keep that configuration and simply run the new migrations and seeder.
