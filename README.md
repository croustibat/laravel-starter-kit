# Mosaic Laravel Starter Kit

A comprehensive Laravel 12 starter kit featuring the beautiful Cruip Mosaic admin dashboard design, powered by Livewire 3 and Tailwind CSS 4.

## Features

- **Laravel 12** - Latest version with all modern features
- **Livewire 3** - Reactive components without JavaScript frameworks
- **Livewire Volt** - Single-file Livewire components
- **Livewire Flux** - Beautiful UI component library
- **Cruip Mosaic Design** - Professional admin dashboard UI
- **Tailwind CSS 4** - Utility-first CSS framework
- **114+ Blade Components** - Reusable UI components organized by domain
- **Chart.js Integration** - Beautiful data visualization
- **Dark Mode Support** - Built-in dark mode with localStorage persistence
- **Responsive Design** - Mobile-first approach
- **Authentication** - Complete auth system with Livewire
- **Business Models** - Pre-configured models for common use cases:
  - Customers
  - Orders
  - Invoices
  - Members
  - Transactions
  - Job Listings
  - Campaigns
  - Analytics Data
- **Demo Data** - Comprehensive seeders with realistic data
- **Laravel Boost** - Development tools included

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm (or yarn)
- SQLite, MySQL, or PostgreSQL

## Installation

### Using Laravel Installer (Recommended)

```bash
laravel new my-project --using=your-vendor/mosaic-starter-kit
cd my-project
npm install && npm run build
php artisan serve
```

### Using Composer

```bash
composer create-project your-vendor/mosaic-starter-kit my-project
cd my-project
npm install && npm run build
php artisan serve
```

The installation process automatically:
- Generates application key
- Creates storage symlink
- Creates SQLite database
- Runs migrations
- Seeds demo data

## Configuration

### Database

By default, the starter kit uses SQLite. To use another database:

1. Update `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Run migrations:
```bash
php artisan migrate:fresh --seed
```

### Demo Credentials

The seeder creates demo users. You can create your own user or use the following:

```
Email: demo@example.com
Password: password
```

## Project Structure

```
├── app/
│   ├── Http/Controllers/     # Business logic controllers
│   ├── Models/                # Eloquent models
│   └── View/Components/       # PHP View Components
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/               # Demo data seeders
│   └── factories/             # Model factories
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind CSS + Mosaic theme
│   ├── js/
│   │   ├── app.js            # Main JavaScript entry
│   │   └── components/        # Chart.js components
│   └── views/
│       ├── components/        # 114+ Blade components
│       │   ├── ui/            # Core UI components
│       │   ├── dashboard/     # Dashboard widgets
│       │   ├── ecommerce/     # E-commerce components
│       │   ├── community/     # Community features
│       │   ├── finance/       # Financial components
│       │   └── job/           # Job listing components
│       ├── layouts/           # Layout files
│       ├── livewire/          # Livewire component views
│       └── pages/             # Page views
└── routes/
    └── web.php               # Application routes
```

## Available Pages

The starter kit includes pre-built pages for:

### Dashboards
- Main Dashboard
- Analytics Dashboard
- Fintech Dashboard

### E-commerce
- Product Catalog
- Shopping Cart
- Orders Management
- Customer Management
- Invoices

### Community
- User Directory
- User Profiles
- Activity Feed
- Forum
- Meetups

### Business
- Transactions
- Job Listings
- Campaigns
- Settings Pages

### Utility
- Changelog
- Roadmap
- FAQs
- 404 Page
- Component Showcase

## Components

The starter kit includes 114+ reusable Blade components:

### Core UI Components
- Buttons
- Forms (inputs, labels, selects)
- Modals
- Dropdowns
- Cards
- Pagination
- Date pickers

### Dashboard Components
- Chart cards (11 types)
- Stats widgets
- Activity feeds
- Data tables

### Domain-Specific Components
- E-commerce: product cards, cart items
- Community: user cards, profile widgets
- Finance: transaction lists, balance cards
- Jobs: listing cards, application forms

## Dark Mode

Dark mode is built-in and persisted via localStorage. Users can toggle between light and dark themes using the switcher in the header.

## Charts & Data Visualization

The starter kit includes Chart.js integration with:
- Line charts
- Bar charts
- Pie/Donut charts
- Stacked charts
- Real-time data updates
- Responsive charts

Chart data is provided through the `DataFeed` model and can be customized via seeders.

## Development

### Running Development Server

```bash
composer dev
```

This command starts:
- PHP development server (port 8000)
- Queue worker
- Laravel Pail (log viewer)
- Vite dev server (hot reload)

### Building for Production

```bash
npm run build
```

### Code Quality

```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Run tests
php artisan test
```

## Customization

### Changing Vendor Name

Before publishing to Packagist, update the package name in `composer.json`:

```json
{
    "name": "your-vendor/mosaic-starter-kit"
}
```

### Removing Unused Features

The starter kit includes many business domains (e-commerce, community, etc.). You can safely remove:

1. **Models**: Delete from `app/Models/`
2. **Migrations**: Delete from `database/migrations/`
3. **Seeders**: Remove from `database/seeders/DatabaseSeeder.php`
4. **Controllers**: Delete from `app/Http/Controllers/`
5. **Routes**: Remove from `routes/web.php`
6. **Views**: Delete folders from `resources/views/components/` and `resources/views/pages/`

### Customizing Colors

Edit `resources/css/app.css` to customize the Tailwind theme:

```css
@theme {
    --color-primary-*: /* Your colors */;
}
```

## Publishing to Packagist

1. Create a GitHub repository
2. Push your code
3. Create a release/tag (e.g., `v1.0.0`)
4. Submit to [Packagist.org](https://packagist.org/)
5. Users can install with:
   ```bash
   laravel new my-project --using=your-vendor/mosaic-starter-kit
   ```

## Credits

- **Design**: [Cruip Mosaic](https://cruip.com/) - Professional admin dashboard template
- **Framework**: [Laravel](https://laravel.com/)
- **Frontend**: [Livewire](https://livewire.laravel.com/), [Tailwind CSS](https://tailwindcss.com/)
- **Charts**: [Chart.js](https://www.chartjs.org/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

For issues, questions, or contributions, please visit the [GitHub repository](https://github.com/your-vendor/mosaic-starter-kit).
