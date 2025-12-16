# Mosaic Laravel Starter Kit

This is a Laravel 12 starter kit based on the Mosaic admin template by Cruip. It provides a production-ready foundation for building admin dashboards, SaaS applications, and business tools.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Livewire 3, Livewire Volt, Livewire Flux UI
- **Styling:** Tailwind CSS 4
- **Charts:** Chart.js 4 with dark mode support
- **Build:** Vite 6
- **Development:** Laravel Sail (Docker)

## Quick Start

```bash
# Start development environment (with Sail)
sail up -d
sail composer install
sail npm install
sail artisan migrate --seed
sail npm run dev

# Or without Sail
composer install
npm install
php artisan migrate --seed
npm run dev
```

## Project Structure

```
app/
├── Console/Commands/       # Artisan commands (mosaic:add, mosaic:remove)
├── Http/Controllers/       # Route controllers
├── Models/                 # Eloquent models
├── Services/               # ModuleGenerator service
└── View/Components/        # Layout classes

resources/
├── css/                    # Tailwind CSS with custom themes
├── js/
│   ├── components/         # Chart.js components for dashboards
│   └── app.js             # Main JS entry point
└── views/
    ├── components/         # 114+ Blade components
    ├── layouts/            # App and auth layouts
    ├── livewire/           # Volt single-file components
    └── pages/              # Page templates

routes/
├── web.php                 # Main routes
└── domains/                # Module-specific routes (auto-generated)

stubs/mosaic/               # Templates for module generation
```

## Modular System (Mosaic Generator)

Add new CRUD modules using the CLI:

```bash
# Add a module with demo data
php artisan mosaic:add ecommerce.products

# Add a module without demo data
php artisan mosaic:add blog.posts --empty

# Remove a module
php artisan mosaic:remove ecommerce.products
```

This generates: Model, Migration, Controller, Views, Seeder, and Routes.

### Pre-configured Modules (in manifest)

- **ecommerce:** customers, orders, invoices
- **community:** members
- **finance:** transactions
- **job:** listings
- **campaigns:** campaigns, marketers

## Available Components

### Dashboard Cards (`resources/views/components/dashboard/`)

| Component | Type | Description |
|-----------|------|-------------|
| dashboard-card-01 | Line Chart | Acme Plus sales trend |
| dashboard-card-02 | Line Chart | Acme Advanced metrics |
| dashboard-card-03 | Line Chart | Acme Professional data |
| dashboard-card-04 | Bar Chart | Direct vs indirect comparison |
| dashboard-card-05 | Stacked Bar | Sales over time |
| dashboard-card-06 | Doughnut | Top countries breakdown |
| dashboard-card-07 | Table | Top channels list |
| dashboard-card-08 | Line Chart | Sales vs refunds |
| dashboard-card-09 | Card | Weekly top customer |
| dashboard-card-10 | Widget | Recent activity feed |
| dashboard-card-11 | Widget | Income/expense summary |

### Analytics Cards (`resources/views/components/analytics/`)

11 analytics-focused chart and metric cards (analytics-card-01 through 11)

### Fintech Cards (`resources/views/components/fintech/`)

14 financial dashboard cards plus intro component (fintech-card-01 through 14)

### UI Components (`resources/views/components/`)

- **Buttons:** button, secondary-button, danger-button
- **Forms:** input, label, validation-errors, input-error, form-section
- **Modals:** modal, dialog-modal, confirmation-modal, modal-search
- **Dropdowns:** dropdown, dropdown-filter, dropdown-notifications, dropdown-help, dropdown-profile
- **Navigation:** nav-link, responsive-nav-link, pagination-classic, pagination-numeric
- **Layout:** section-title, section-border, placeholder-pattern
- **Date:** datepicker, date-select

### Settings Components (`resources/views/components/settings/`)

- settings-sidebar, account-panel, notifications-panel, billing-panel
- apps-panel, plans-panel, feedback-panel

## Layouts

### App Layout (`x-layouts.app`)

Main application layout with sidebar navigation, user dropdown, and dark mode toggle.

```blade
<x-layouts.app>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Your content -->
    </div>
</x-layouts.app>
```

### Auth Layouts

- `x-layouts.auth.simple` - Centered form layout
- `x-layouts.auth.card` - Card-based layout
- `x-layouts.auth.split` - Split view layout

## Routes

### Dashboard

- `GET /dashboard` - Main dashboard
- `GET /dashboard/analytics` - Analytics dashboard
- `GET /dashboard/fintech` - Fintech dashboard

### Settings

- `GET /settings/account` - Account settings (profile)
- `GET /settings/notifications` - Notification preferences
- `GET /settings/apps` - Connected apps
- `GET /settings/plans` - Subscription plans
- `GET /settings/billing` - Billing info
- `GET /settings/feedback` - Feedback form

### Utility

- `/utility/changelog`, `/utility/roadmap`, `/utility/faqs`
- `/utility/empty-state`, `/utility/404`

### Component Demos

- `/component/button`, `/component/form`, `/component/dropdown`
- `/component/alert`, `/component/modal`, `/component/pagination`
- `/component/tabs`, `/component/breadcrumb`, `/component/badge`
- `/component/avatar`, `/component/tooltip`, `/component/accordion`
- `/component/icons`

## Authentication

Built with Laravel Fortify:

- Login/Register with rate limiting (5 attempts/min)
- Password reset via email
- Email verification
- Two-factor authentication ready
- Profile management (Livewire Volt)

Auth views location: `resources/views/livewire/auth/`

## Data Visualization

Charts use the DataFeed model (`app/Models/DataFeed.php`):

```php
// Get chart data
$data = DataFeed::getDataFeed(dataType: 1, field: 'label', limit: 10);

// Sum dataset
$total = DataFeed::sumDataSet(dataType: 1, dataset: 0);
```

API endpoint: `GET /json-data-feed` returns chart data for JavaScript components.

## Styling

### Dark Mode

Built-in dark mode with:
- Toggle in sidebar/header
- Persisted in localStorage
- All components support dark mode
- Charts update colors dynamically

### Custom Theme

Edit `resources/css/app.css` for Tailwind theme customization:

```css
@theme {
    --color-gray-50: oklch(0.985 0 0);
    /* ... */
    --color-violet-500: oklch(0.606 0.25 292.717);
}
```

## Development Commands

```bash
# Full dev environment (server + queue + logs + vite)
composer dev

# Or individually:
sail artisan serve
sail artisan queue:listen --tries=1
sail npm run dev

# Code formatting
./vendor/bin/pint

# Run tests
sail artisan test
```

## Creating New Features

### 1. Add a New Page

```blade
{{-- resources/views/pages/my-page.blade.php --}}
<x-layouts.app>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h1>My Page</h1>
    </div>
</x-layouts.app>
```

```php
// routes/web.php
Route::get('/my-page', fn() => view('pages.my-page'))->name('my-page');
```

### 2. Add to Sidebar

Edit `resources/views/components/layouts/app/sidebar.blade.php`:

```blade
<flux:navlist.item icon="icon-name" href="{{ route('my-page') }}" wire:navigate>
    My Page
</flux:navlist.item>
```

### 3. Add a Dashboard Card

Use existing components as templates:

```blade
<x-dashboard.dashboard-card-01 />
```

Or create custom ones in `resources/views/components/dashboard/`.

### 4. Add a Module with CRUD

```bash
php artisan mosaic:add myapp.products
```

## Conventions

- **Models:** Singular, PascalCase (`Customer`, `Order`)
- **Controllers:** PascalCase with Controller suffix (`CustomerController`)
- **Views:** kebab-case in nested folders (`pages/ecommerce/customers.blade.php`)
- **Components:** kebab-case (`dashboard-card-01.blade.php`)
- **Routes:** kebab-case URLs, camelCase names

## Database

Default: SQLite (file-based, no config needed)

Migrations include:
- users, sessions, password_reset_tokens
- datafeeds (chart data)
- cache, jobs (queue)

## Important Files

- `app/Services/ModuleGenerator.php` - Module generation logic
- `stubs/mosaic/module-manifest.json` - Pre-configured module definitions
- `resources/js/components/` - Chart.js implementations
- `resources/views/components/layouts/app/sidebar.blade.php` - Navigation

## Flux UI Components

This project uses Livewire Flux for UI components. Common usage:

```blade
<flux:button>Click me</flux:button>
<flux:input wire:model="name" label="Name" />
<flux:modal name="confirm">...</flux:modal>
<flux:navlist>...</flux:navlist>
```

See Flux documentation: https://fluxui.dev/docs
