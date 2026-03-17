# Order Management System

A modern, real-time device and order management application built with Laravel and Livewire.

## Project Overview

This application is a full-stack web platform designed to:
- **Manage Devices**: Register and track multiple devices with IMEI and model information
- **Process Orders**: Create and manage service, orders for devices unlock
- **Track Transactions**: Monitor all financial transactions including payments and refunds
- **User Authentication**: Secure login with two-factor authentication (2FA)
- **Dashboard Analytics**: Real-time dashboard with key metrics and insights
- **Wallet Management**: Integrated wallet system for tracking user balances and transactions

### Key Features
- ✨ Real-time reactive interface powered by Livewire
- 🔐 Secure authentication with email verification and 2FA via Laravel Fortify
- 📱 Responsive design with Flux UI components and Tailwind CSS
- 🎯 Device management with order tracking
- 💰 Transaction and wallet management system
- 📊 Interactive dashboard with Livewire components
- 🧪 Full test coverage with Pest PHP
- 📡 WebSocket support with Laravel Reverb for real-time features

## Tech Stack

### Backend
- **PHP**: 8.4.16
- **Laravel Framework**: v12 (Latest)
- **Laravel Fortify**: v1 (Headless authentication backend)
- **Livewire**: v4 (Reactive component framework)
- **Laravel Reverb**: v1 (WebSocket server for real-time features)

### Frontend
- **Livewire Flux**: v2 (Free edition - Official Livewire component library)
- **TallStackUI**: v3 (Component library)
- **Tailwind CSS**: v4
- **Alpine.js**: Integrated with Livewire for client-side interactions
- **Vite**: v7 (Modern frontend build tool)
- **Laravel Echo**: v2 (Real-time event broadcasting)

### Database & ORM
- **Eloquent ORM**: Laravel's powerful ORM with relationships
- **Database Agnostic**: MySQL, PostgreSQL, SQLite supported

### Development & Testing
- **Pest PHP**: v4 (Modern testing framework)
- **PHPUnit**: v12 (Unit testing)
- **Laravel Pint**: v1 (PHP code formatting)
- **Laravel Sail**: v1 (Docker environment)
- **Laravel Pail**: v1 (Log viewing)

### Additional Tools
- **Laravel Tinker**: Interactive REPL for debugging
- **Faker**: For generating test data
- **TallStackUI**: Component library for enhanced UI
- **Laravel Boost**: v2 (Development tools and MCP server)

## Project Structure

```
changeSystem/
├── app/
│   ├── Actions/              # Application actions (Fortify actions)
│   ├── Concerns/             # Reusable traits for models
│   ├── Enums/                # PHP Enums (OrderStatus, TransactionType)
│   ├── Helpers/              # Application helpers
│   ├── Http/
│   │   └── Controllers/      # HTTP controllers
│   ├── Livewire/             # Livewire components
│   │   ├── Dashboard.php
│   │   ├── MyDevices.php
│   │   ├── Orders.php
│   │   ├── Transactions.php
│   │   ├── Settings/         # Settings-related components
│   │   └── Actions/          # Component actions
│   ├── Models/               # Eloquent models
│   │   ├── User.php
│   │   ├── Device.php
│   │   ├── Order.php
│   │   ├── Service.php
│   │   └── Transaction.php
│   ├── Providers/            # Service providers
│   └── Services/             # Business logic services
├── bootstrap/                # Application bootstrap
│   ├── app.php              # Main application configuration
│   └── providers.php         # Service provider registration
├── config/                   # Configuration files
├── database/
│   ├── factories/            # Factory classes for testing
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/                   # Web root
├── resources/
│   ├── css/                  # Tailwind CSS
│   ├── js/                   # JavaScript/Alpine.js
│   └── views/                # Blade templates
├── routes/
│   ├── web.php              # Web routes
│   ├── channels.php         # Broadcasting channels
│   ├── console.php          # Artisan commands
│   └── settings.php         # Settings routes
├── storage/                  # Logs, uploads, cache
├── tests/                    # Pest tests
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
└── vendor/                   # Composer dependencies
```

## Requirements

- **PHP**: 8.2+ (Tested with 8.4.16)
- **Composer**: 2.0+
- **Node.js**: 18+ (for frontend assets)
- **Database**: MySQL 8.0+, PostgreSQL 12+, or SQLite 3
- **Git**: For version control

## Installation & Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd changeSystem
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
# or
pnpm install
```

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Configuration
Update the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=device_orders
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Generate Application Key & Storage Link
```bash
php artisan storage:link
```

## Running the Application

### Development Mode

**Terminal 1 - Laravel Server & WebSocket:**
```bash
composer run dev
```

**Terminal 2 - Frontend Assets (if not using composer run dev):**
```bash
npm run dev
```

This will start:
- Laravel development server on `http://localhost:8000`
- Vite frontend build watch mode
- Laravel Reverb WebSocket server

### Production Build
```bash
npm run build
php artisan config:cache
```

### Access the Application
- **URL**: `http://localhost:8000`
- **Dashboard**: `/dashboard`
- **Devices**: `/devices`
- **Orders**: `/orders`
- **Transactions**: `/transactions`

## Testing

### Run All Tests
```bash
php artisan test
```

### Run with Coverage
```bash
php artisan test --coverage
```

### Run Specific Test File
```bash
php artisan test tests/Feature/DeviceManagementTest.php
```

### Run Tests with Compact Output
```bash
php artisan test --compact
```

## Code Quality

### Format Code with Pint
```bash
vendor/bin/pint --dirty --format agent
```

### Check Code Style
```bash
vendor/bin/pint --test --format agent
```

## Artisan Commands

Common Artisan commands for this application:

```bash
# Seed the database
php artisan db:seed

# View logs
php artisan pail

# List all routes
php artisan route:list

# Tinker - Interactive shell
php artisan tinker
```

## Key Features in Detail

### Livewire Components
- **Dashboard**: Real-time analytics and metrics
- **MyDevices**: Device management and listing
- **Orders**: Order creation, tracking, and management
- **Transactions**: Transaction history and wallet balance

### Authentication
- Email/Password login with email verification
- Two-factor authentication (TOTP)
- Profile management
- Password reset functionality
- Session management

### API & Real-time
- WebSocket support via Laravel Reverb
- Broadcasting channels for order updates
- Real-time transaction notifications
- Live dashboard updates

## Configuration Files

- `config/fortify.php` - Authentication configuration
- `config/livewire.php` - Livewire component settings
- `config/tallstackui.php` - TallStackUI component customization
- `config/broadcasting.php` - Real-time broadcasting setup
- `config/reverb.php` - WebSocket server configuration

## Environment Variables

Key environment variables to configure:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=device_orders
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=reverb
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_DRIVER=log
MAIL_FROM_ADDRESS=noreply@example.com
```

## Docker Setup (with Laravel Sail)

### Initialize Sail
```bash
php artisan sail:install
```

### Run with Docker
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

## Troubleshooting

### Vite Manifest Error
If you see "Unable to locate file in Vite manifest", run:
```bash
npm run build
# or
composer run dev
```

### Database Connection Issues
- Ensure database server is running
- Check `.env` database credentials
- Verify database exists and is accessible

### WebSocket Connection Issues
- Verify Laravel Reverb is running
- Check `BROADCAST_DRIVER` is set to `reverb` in `.env`
- Ensure Reverb server port is accessible

### Permission Issues
```bash
chmod -R 775 storage bootstrap/cache
```

## Deployment

### Preparation
```bash
# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build frontend assets
npm run build
```

### Environment
Set `APP_ENV=production` and `APP_DEBUG=false` in production.

## Contributing

1. Create a feature branch: `git checkout -b feature/amazing-feature`
2. Commit changes: `git commit -m 'Add amazing feature'`
3. Push to branch: `git push origin feature/amazing-feature`
4. Open a Pull Request
---

**Built with ❤️ using Laravel and Livewire**
