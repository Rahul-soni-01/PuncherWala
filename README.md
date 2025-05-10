# 🚗 PuncherWala - Instant Vehicle Repair Service

![PuncherWala Banner](public/images/banner.png) <!-- Add your banner image if available -->

Demo Video :- https://app.screencastify.com/v3/watch/yy6QsUT382FTHpsLTTI2

## 🌟 Images :-
- **Home**
     -https://prnt.sc/54vrD0m56UAA
     -https://prnt.sc/e9ir-lMDiLdt
     -https://prnt.sc/bU1xPu45JTYH

- **Login**
     -https://prnt.sc/knmiUYQ9aTba

A Laravel-based platform connecting vehicle owners with certified mechanics for instant puncture repair and maintenance services.

![Laravel Version](https://img.shields.io/badge/Laravel-10.x-orange.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.1+-purple.svg)

## 🌟 Features

- **24/7 Emergency Services**
  - Instant mechanic dispatch
  - Real-time technician tracking
- **User Dashboard**
  - Service booking history
  - Payment management
  - Vehicle profiles
- **Mechanic Portal**
  - Job assignment system
  - Route optimization
  - Digital payment collection
- **Admin Panel**
  - Service monitoring
  - User/mechanic management
  - Analytics dashboard

## 🛠️ Tech Stack

**Backend:**
- PHP 8.1+
- Laravel 10
- MySQL/PostgreSQL

**Frontend:**
- Bootstrap 5
- jQuery/Ajax
- AdminLTE (Admin Panel)

**Services:**
- Google Maps API (Tracking)
- Razorpay/PayTM Integration
- Firebase Cloud Messaging (Notifications)

## 🚀 Installation

### Prerequisites
- PHP 8.1+
- Composer 2
- Node.js 16+
- MySQL 5.7+

### Setup Steps

```bash
# Clone the repository
git clone https://github.com/Rahul-soni-01/PuncherWala.git
cd PuncherWala

# Install dependencies
composer install
npm install
npm run build

# Configuration
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Storage link
php artisan storage:link

# Run development server
php artisan serve


PuncherWala/
├── app/               # Core application code
│   ├── Http/         # Controllers
│   ├── Models/       # Database models
│   └── Services/     # Business logic
├── config/           # Configuration files
├── database/         # Migrations and seeds
├── public/           # Public assets
├── resources/        # Views and frontend assets
├── routes/           # Application routes
└── tests/            # Test cases


Demo Credentials:

# User: user@demo.com / password
Garage: rajesh@garage.test / password
Admin: admin@puncherwala.test / password