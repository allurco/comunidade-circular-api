# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application called "Comunidade Circular" (Circular Community), which appears to be a platform for item exchange and community interaction.

## Development Commands

### Running the Application
```bash
# Start all services (server, queue, logs, vite)
composer run dev

# Or run services individually:
php artisan serve       # Start the Laravel server
npm run dev            # Start Vite dev server
php artisan queue:listen --tries=1  # Start queue worker
php artisan pail --timeout=0        # Watch logs
```

### Build Commands
```bash
npm run build          # Build frontend assets with Vite
composer install       # Install PHP dependencies
npm install           # Install Node dependencies
```

### Testing
```bash
composer test          # Run tests (clears config and runs PHPUnit)
php artisan test      # Run tests directly
```

### Code Quality
```bash
vendor/bin/pint       # Run Laravel Pint for code formatting
```

### Database Commands
```bash
php artisan migrate                # Run database migrations
php artisan migrate:fresh         # Drop all tables and re-run migrations
php artisan db:seed              # Run database seeders
php artisan tinker               # Interactive PHP shell with Laravel
```

## Architecture Overview

### Laravel Structure
- **Models**: Located in `app/Models/` - currently includes User, Item, Exchange, and Comment models
- **Controllers**: Located in `app/Http/Controllers/`
- **Routes**: Defined in `routes/` directory (web.php, api.php)
- **Migrations**: Database schema in `database/migrations/`
- **Views**: Blade templates in `resources/views/`

### Key Models and Relationships
Based on the migrations, the application has:
- **Users**: Standard Laravel user model with avatar support
- **Items**: Things users can exchange in the community
- **Exchanges**: Records of item exchanges between users
- **Comments**: User comments on exchanges

### Frontend Stack
- **Vite**: Build tool for frontend assets
- **Tailwind CSS 4.0**: Utility-first CSS framework (configured with Vite)
- **Blade**: Laravel's templating engine

### Environment Configuration
- Uses `.env` file for environment variables (copy from `.env.example` if missing)
- Laravel Herd configuration present (`herd.yml`)
- Database: SQLite by default (identifier.sqlite)

## Development Workflow

1. Ensure `.env` file exists with proper configuration
2. Run `composer install` to install PHP dependencies
3. Run `npm install` to install Node dependencies
4. Run `php artisan migrate` to set up database
5. Use `composer run dev` to start all development services simultaneously