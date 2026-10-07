# 🍽️ Bella Artista — Trilingual Restaurant Management, Delivery & Reservation Platform

![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/UI-Blade%20Templates-FF2D20)
![Google OAuth](https://img.shields.io/badge/Auth-Google%20OAuth-4285F4?logo=google&logoColor=white)
![i18n](https://img.shields.io/badge/Languages-FR%20%7C%20EN%20%7C%20AR%20(RTL)-38B2AC)
![License](https://img.shields.io/badge/License-MIT-blue.svg)

> **A comprehensive commercial restaurant platform** featuring full trilingual internationalization (French, English, and Arabic RTL), online table reservations, food delivery ordering with guest tracking, customer accounts with Google OAuth, payment webhook integration, and an administrator management suite.

---

## 🌟 Highlights & Key Features

### 🌍 1. Full Trilingual Support (FR / EN / AR with RTL)
- Live locale switcher (`/lang/{locale}`) dynamically changing interface language across the entire application.
- Full **Right-to-Left (RTL)** layout support for Arabic, tailored for North African & Middle Eastern markets.

### 🛎️ 2. Table Reservations & Delivery
- **Table Booking**: Interactive reservation form with party size, date/time picker, and special requests.
- **Online Delivery**: Menu browsing by category, cart checkout, and delivery zone fee calculation.
- **Guest Order Tracking**: Look up real-time delivery status via reference number (`/track-order`) without requiring login.

### 👤 3. Customer Account System
- Email registration and login with rate-limiting security.
- **Google OAuth Sign-In**: Instant 1-click social authentication.
- Password reset workflow via email tokens.
- Order history and in-app notifications center (`/account/notifications`).

### 💳 4. Payments & Webhooks
- Payment result confirmation workflow (`/payment/result/{order}`).
- Asynchronous webhook listener (`/payment/webhook`) for payment provider callbacks.

### 🛡️ 5. Admin Control Center (`/admin`)
- **Dashboard & Analytics**: Live revenue stats, pending orders, and dine-in customer session counters.
- **Order Management**: Real-time order status lifecycle (Pending $\rightarrow$ Preparing $\rightarrow$ Out for Delivery $\rightarrow$ Completed).
- **Reservation Workflow**: Accept or reject table bookings with automated status notifications.
- **Menu Catalog CRUD**: Add, edit, price, and disable menu dishes and categories.
- **Restaurant Settings**: Manage operating hours, delivery fees, and restaurant profile.

---

## 🏗️ Architecture & Database

```mermaid
graph TD
    Public[Public Storefront\n(Menu, Delivery, Reservations)] --> Controllers[Public & Customer Controllers]
    Admin[Admin Suite\n(/admin/* protected by admin.auth)] --> AdminControllers[Admin & Analytics Controllers]
    Controllers --> Middleware[Locale & Auth Middleware]
    AdminControllers --> Middleware
    Middleware --> Models[Eloquent Models\n(Order, MenuItem, Reservation, User, Category)]
    Models --> MySQL[(MySQL Database - 22 Migrations)]
```

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP 8.0+
- Composer
- MySQL

### Setup & Run

```bash
# 1. Clone repository
git clone https://github.com/your-username/bella-artista-restaurant.git
cd bella-artista-restaurant

# 2. Install dependencies
composer install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Run database migrations
php artisan migrate

# 5. Serve locally
php artisan serve
```

* Public storefront: **`http://127.0.0.1:8000`**
* Table reservation form: **`http://127.0.0.1:8000/reservations`**
* Delivery catalog: **`http://127.0.0.1:8000/delivery`**
* Admin panel: **`http://127.0.0.1:8000/admin`**
