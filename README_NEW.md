# SpaceAlchemy - E-commerce & Service Management Platform

A modern, full-stack web application built with Laravel 11 for managing products, services, and packages with a complete admin dashboard and customer-facing storefront.

## 🎯 Project Overview

**SpaceAlchemy** is a comprehensive e-commerce and service management platform that enables businesses to:

- **Manage Products**: Create, edit, and delete products with images, descriptions, and pricing
- **Manage Services**: Organize and offer services with icons and detailed descriptions
- **Manage Packages**: Bundle products and services into attractive packages
- **Admin Dashboard**: Intuitive backend interface for complete control over inventory and operations
- **Customer Storefront**: Beautiful frontend for browsing products and services
- **Shopping Cart**: Persistent localStorage-based cart system for seamless shopping experience
- **Search & Filter**: Real-time AJAX search functionality for quick product discovery

### Key Features

✨ **Frontend Features:**
- Dynamic product catalog with image galleries
- Real-time search with dropdown suggestions
- Shopping cart with local storage persistence
- Checkout flow with order processing
- Responsive design built with Bootstrap 5
- Best-selling products showcase

🔧 **Admin Features:**
- Product management with image uploads
- Service management with icon support
- Package creation and configuration
- Real-time search for all resources
- CRUD operations (Create, Read, Update, Delete)
- Session-based authentication

🚀 **Technical Stack:**
- **Backend**: Laravel 11 with Blade templating
- **Frontend**: Bootstrap 5, vanilla JavaScript, Tailwind CSS
- **Database**: MySQL with Eloquent ORM
- **Asset Pipeline**: Vite with Laravel plugin
- **API**: RESTful API endpoints for packages

---

## 📋 Setup Instructions

### Prerequisites

Before you begin, ensure you have installed:
- **PHP 8.2 or higher**
- **Composer** (PHP dependency manager)
- **Node.js** (v18 or higher) and **npm**
- **MySQL** (v8.0 or higher) or compatible database
- **Git** (optional, for version control)

### Step 1: Clone or Download the Project

```bash
# Navigate to your web server directory (e.g., xampp/htdocs)
cd c:\xampp\htdocs

# If using git:
git clone <repository-url> spaceAlchemy-SCDTheoryProject
cd spaceAlchemy-SCDTheoryProject
```

### Step 2: Install PHP Dependencies

```bash
# Install Laravel packages using Composer
composer install
```

### Step 3: Configure Environment

```bash
# Copy the example environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

Then edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spacealchemy_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database

```bash
# Create a new MySQL database
# Using MySQL command line or phpMyAdmin
CREATE DATABASE spacealchemy_db;
```

### Step 5: Run Database Migrations

```bash
# Create all database tables
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

### Step 6: Install Node Dependencies

```bash
# Install JavaScript packages
npm install
```

### Step 7: Build Assets

```bash
# Development build with hot reload
npm run dev

# Or production build (in another terminal)
npm run build
```

### Step 8: Start Development Server

```bash
# In a new terminal, run the Laravel development server
php artisan serve

# The application will be available at http://127.0.0.1:8000
```

---

## 🚀 Usage Guide

### For Customers (Frontend)

#### Browsing Products
1. Navigate to **Home** page (http://127.0.0.1:8000/)
2. View **Best-Selling Products** section on homepage
3. Click on **Products** in navigation to see full catalog
4. Use the search bar to find specific products by name or description

#### Shopping Cart
1. Click product image to view product details
2. Click **"View Details"** to open the product detail page
3. Add desired quantity using **+/-** buttons
4. Click **"Add to Cart"** button
5. Cart count updates in the header automatically
6. Click **Cart** icon to view shopping cart
7. Manage quantities or remove items
8. Click **Checkout** to proceed with purchase

#### Checkout
1. Review your cart items and quantities
2. Verify shipping address
3. Complete the order

#### Services & Packages
- Browse **Services** section to see available business services
- Check **Packages** for bundled offerings combining products and services

---

### For Administrators (Backend)

#### Admin Login
1. Navigate to **Admin Dashboard** (http://127.0.0.1:8000/admin)
2. Log in with your admin credentials
3. You will be redirected to the dashboard

#### Managing Products

**Create Product:**
1. Click **Products** in the sidebar
2. Click **"Add Product"** button
3. Fill in product details:
   - Product Name
   - Description
   - Price
   - Upload product image
4. Click **Save** to create

**Edit Product:**
1. Go to **Products** list
2. Click **Edit** button next to product
3. Modify product information
4. Click **Update** to save changes

**Delete Product:**
1. Go to **Products** list
2. Click **Delete** button next to product
3. Confirm deletion in the popup

**Search Products:**
1. Use the search bar on Products page
2. Type product name or description
3. Click **Search** or press Enter
4. Results update in real-time
5. Click **Clear** to reset search

#### Managing Services

**Create Service:**
1. Click **Services** in the sidebar
2. Click **"Add Service"** button
3. Fill in service details:
   - Service Title
   - Description
   - Icon (upload image or Font Awesome class like "fas fa-cog")
4. Click **Save**

**Edit Service:**
1. Go to **Services** list
2. Click **Edit** button
3. Update service information
4. Click **Update**

**Search Services:**
1. Use search bar on Services page
2. Search by title or description
3. Results display in real-time

#### Managing Packages

**Create Package:**
1. Click **Packages** in the sidebar
2. Click **"Add Package"** button
3. Fill in package details:
   - Package Name
   - Description
   - Select associated product
   - Add services to package
   - Set price
4. Click **Save**

**Edit Package:**
1. Go to **Packages** list
2. Click **Edit** button
3. Modify package information
4. Click **Update**

**Search Packages:**
1. Use search bar on Packages page
2. Search by name or description
3. Results update instantly

---

## 📁 Project Structure

```
spaceAlchemy-SCDTheoryProject/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BackendProductController.php      # Admin product management
│   │   │   ├── BackendServiceController.php      # Admin service management
│   │   │   ├── BackendPackageController.php      # Admin package management
│   │   │   ├── Api/
│   │   │   │   └── PackageApiController.php      # REST API for packages
│   │   │   └── Frontend/
│   │   │       ├── ProductsController.php        # Frontend products display
│   │   │       ├── ProductDetailController.php   # Product detail page
│   │   │       ├── CartController.php            # Cart management
│   │   │       └── CheckoutController.php        # Checkout flow
│   │   └── Requests/                             # Form validation requests
│   ├── Models/
│   │   ├── Product.php                           # Product model
│   │   ├── Service.php                           # Service model
│   │   ├── Package.php                           # Package model
│   │   └── User.php                              # User authentication
│   └── Providers/
│       └── AppServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── products/                         # Admin product templates
│   │   │   ├── services/                         # Admin service templates
│   │   │   └── packages/                         # Admin package templates
│   │   └── frontend/
│   │       ├── index.blade.php                   # Homepage
│   │       ├── products.blade.php                # Products page
│   │       ├── product-detail.blade.php          # Product detail page
│   │       ├── cart.blade.php                    # Shopping cart
│   │       └── checkout.blade.php                # Checkout page
│   ├── css/
│   │   └── app.css                               # Tailwind styles
│   └── js/
│       └── app.js                                # JavaScript entry point
├── routes/
│   ├── web.php                                   # Web routes (frontend & admin)
│   ├── api.php                                   # API routes
│   └── auth.php                                  # Authentication routes
├── database/
│   ├── migrations/                               # Database schemas
│   ├── factories/                                # Model factories for testing
│   └── seeders/                                  # Database seeders
├── public/
│   ├── storage/                                  # Product/service images storage
│   ├── index.php                                 # Application entry point
│   └── frontend/
│       ├── main.js                               # Frontend JavaScript (cart logic)
│       ├── style.css                             # Custom frontend styles
│       └── images/                               # Frontend images
├── config/
│   ├── app.php                                   # Application configuration
│   ├── database.php                              # Database configuration
│   └── auth.php                                  # Authentication configuration
├── .env                                          # Environment variables (create from .env.example)
├── composer.json                                 # PHP dependencies
├── package.json                                  # Node.js dependencies
├── vite.config.js                                # Vite configuration
└── README.md                                     # This file
```

---

## 🔌 API Documentation

The application includes a RESTful API for package management. See `API_DOCUMENTATION.md` for detailed endpoint information.

### Base URL
```
http://127.0.0.1:8000/api
```

### Available Endpoints

#### Packages
- `GET /api/packages` - List all packages
- `GET /api/packages/{id}` - Get package details
- `POST /api/packages` - Create new package
- `PUT /api/packages/{id}` - Update package
- `DELETE /api/packages/{id}` - Delete package
- `GET /api/packages/product/{productId}` - Get packages for specific product
- `GET /api/packages/search?query={query}` - Search packages

---

## 🛠️ Common Commands

### Laravel Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Run database migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# List all routes
php artisan route:list

# Run tests
php artisan test
```

### npm Commands

```bash
# Start development server with hot reload
npm run dev

# Build for production
npm run build

# Install new package
npm install package-name
```

---

## 🐛 Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check `.env` file database credentials
- Ensure database exists: `CREATE DATABASE spacealchemy_db;`

### Assets Not Loading
- Run `npm install` to install dependencies
- Run `npm run dev` or `npm run build`
- Clear cache: `php artisan cache:clear`

### 404 Errors on Routes
- Run `php artisan route:clear` to clear route cache
- Verify routes are defined in `routes/web.php` or `routes/api.php`

### File Upload Issues
- Ensure `storage/app/public` directory exists
- Run: `php artisan storage:link` to create symbolic link
- Check file permissions on storage directory

### Authentication Issues
- Ensure user table is migrated: `php artisan migrate`
- Check auth middleware in `app/Http/Middleware/`
- Verify `.env` APP_KEY is set: `php artisan key:generate`

---

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Template Syntax](https://laravel.com/docs/blade)
- [Eloquent ORM Guide](https://laravel.com/docs/eloquent)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)
- [Vite Documentation](https://vitejs.dev/)

---

## 📝 License

This project is open-source and available under the MIT License.

---

## 👥 Support

For issues or questions about this project, please contact the development team or create an issue in the repository.

---

**Last Updated**: December 2025
**Version**: 1.0.0
