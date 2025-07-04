# Digsiy – Automated Website Scraping & Article Management Platform

A Laravel-based platform for scraping articles from websites, managing content, and providing a robust admin dashboard. Digsiy features modular architecture, event-driven jobs, real-time notifications, and a modern, responsive UI.

---

## 🚀 Project Overview

Digsiy is designed to automate the process of scraping articles from various websites, storing them in a structured database, and providing an admin interface for management. The system supports custom scraping strategies, job queues, user authentication, and real-time feedback via broadcasting.

---

## 🏗️ Architecture & Main Features

- **Backend:** Laravel (PHP), modular structure (`/app`)
  - **Models:** Article, Website, User
  - **Repositories:** Abstract data access for articles and websites
  - **Services:**
    - ArticleService: Handles scraping logic and article creation
    - WebsiteStoreService & WebsiteUpdateService: Manage website records and trigger scraping jobs
    - DomType Strategy: Supports multiple scraping strategies for different website structures
  - **Jobs:**
    - ScrapedJob: Handles background scraping and error reporting
    - UserSeedJob: Batch user creation
  - **Events:**
    - ScrappedMessageEvent: Broadcasts scraping status to users
  - **Traits:** LatestState for global query scopes
- **Authentication:** Laravel Auth (login, register, password reset, email verification)
- **Middleware:** Security, session, CSRF, and custom logic
- **Broadcasting:** Real-time notifications using Laravel Echo and private channels
- **Validation:** Form requests for input validation
- **Localization:** English language files for auth, validation, and UI
- **Views:** Blade templates for admin dashboard, articles, websites, authentication, and alerts
- **Routing:**
  - `/routes/web.php`: Admin dashboard, resource routes for websites and articles
  - `/routes/api.php`: Authenticated API endpoints
  - `/routes/channels.php`: Broadcast channel definitions
  - `/routes/console.php`: Custom Artisan commands

---

## 🧩 Scraping Workflow

1. **Add Website:** Admin adds a website (name, link) via the dashboard.
2. **Trigger Scraping:** On creation/update, a background job (`ScrapedJob`) is dispatched.
3. **Scraping Logic:**
   - The job uses `ArticleService` and a strategy pattern (`DomTypeOne`, `DomTypeTwo`, etc.) to parse articles from the website.
   - Articles are extracted and stored in the database, replacing old ones for that website.
4. **Real-Time Feedback:**
   - Success or failure is broadcast to the user via `ScrappedMessageEvent` and shown as a notification in the UI.

---

## 📁 Project Structure

- `/app`
  - `Console/` – Artisan command kernel
  - `Constants/` – Enum-like constants (e.g., DomType)
  - `Contracts/` – Scraping interface contracts
  - `Events/` – Broadcasting events
  - `Exceptions/` – Custom exception handler
  - `Http/` – Controllers, middleware, requests
  - `Jobs/` – Background jobs (scraping, seeding)
  - `Models/` – Eloquent models (Article, Website, User)
  - `Providers/` – Service providers (auth, events, routes)
  - `Repositories/` – Data access abstraction
  - `Services/` – Business logic (scraping, website management)
  - `Traits/` – Reusable model traits
- `/resources`
  - `views/` – Blade templates for dashboard, auth, articles, websites, layouts
  - `js/` – Bootstrap, Echo, SweetAlert integration
  - `lang/` – English localization files
  - `sass/` – SCSS variables and styles
- `/routes`
  - `web.php` – Web/admin routes
  - `api.php` – API routes
  - `channels.php` – Broadcast channels
  - `console.php` – Custom Artisan commands

---

## 🛠️ Key Features

- **Admin Dashboard:** Manage websites and articles with a modern UI
- **Automated Scraping:** Add or update websites to trigger background scraping
- **Strategy Pattern:** Easily extend scraping logic for new website structures
- **Real-Time Notifications:** Users receive instant feedback on scraping jobs
- **Authentication:** Secure login, registration, password reset, and email verification
- **Validation:** Robust input validation for all forms
- **Localization:** Ready for multi-language support

---

## 🚦 Getting Started

### Prerequisites
- PHP 8.0+
- Composer
- Node.js & npm (for frontend assets)
- MySQL or compatible database

### Installation
1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd digsiy
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install JS dependencies and build assets:
   ```bash
   npm install && npm run dev
   ```
4. Copy `.env.example` to `.env` and configure your database and broadcasting settings.
5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Start the queue worker (for jobs):
   ```bash
   php artisan queue:work
   ```
7. Serve the application:
   ```bash
   php artisan serve
   ```

### Usage
- Log in as admin, add websites, and manage articles from the dashboard.
- Scraping jobs and notifications are handled automatically.

---

## 📚 Extending & Customization
- **Add new scraping strategies:** Implement the `DomType` contract and register in `ArticleService`.
- **Customize notifications:** Edit `ScrappedMessageEvent` and frontend JS for new alert types.
- **Add new resources:** Use Laravel's resource controllers and Blade templates.

---

## 📝 License
This project is open-source and available under the MIT License.
