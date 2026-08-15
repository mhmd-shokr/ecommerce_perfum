<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


🧴 Luxe Parfum — E-Commerce Platform

A full-stack e-commerce platform for luxury perfumes, built with Laravel, featuring a customer/admin web application and a versioned RESTful API for external clients such as React and Flutter.

✨ Features

🔐 Authentication & Authorization

User registration and login

Laravel Sanctum API authentication

Email verification with OTP

Forgot password / reset password

Update password

Logout / logout from all devices

Role and permission management

Admin / Seller / Customer roles

Policies and authorization

🛍️ E-Commerce

Products management

Categories and Brands

Product filtering

Sorting and pagination

Shopping cart

Wishlist

Checkout

Customer addresses

Coupons and discounts

Product reviews

Admin review approval/rejection

📦 Orders

Customer order creation

Customer order history

Admin order management

Order filtering and sorting

Order pagination

Order status management

Payment status management

Stock management

💳 Payments

Stripe integration

Cash on Delivery

Stripe PaymentIntent

Stripe Webhooks

Payment status synchronization

📊 Admin Dashboard

Products, categories, brands and customer statistics

Orders statistics

Revenue

Monthly revenue

Recent orders

Low-stock products

Top-selling products

🌍 Localization

Arabic / English

Web localization using sessions

API localization using Accept-Language

⚡ Background Processing

Laravel Cache

Queues and Jobs

Asynchronous emails

OTP emails

Welcome emails

Order confirmation emails

Stock management

🏗️ Architecture

The project follows a layered architecture to separate HTTP concerns, business logic, and data access.

Web / React / Flutter
          │
          ▼
     Controllers
          │
          ▼
    Form Requests
          │
          ▼
       Services
          │
          ▼
     Repositories
          │
          ▼
        Models
          │
          ▼
        MySQL

Supporting infrastructure:

              ┌──────────────┐
              │    Redis     │
              └──────┬───────┘
                     │
          ┌──────────┴──────────┐
          ▼                     ▼
        Cache                 Queues
                                │
                                ▼
                               Jobs

Design Principles

Thin Controllers

Business logic isolated in Services

Repository Pattern

Interface-based dependencies

Form Request validation

API Resources

Policies for authorization

Dependency Injection

Separation of concerns

🌐 Web Application

The Laravel web application provides customer and administration interfaces.

Customer

Browse products

Search and filter products

Add products to cart

Manage wishlist

Checkout

Manage addresses

Apply coupons

Place orders

Review products

Manage account

Admin

Manage products

Manage categories

Manage brands

Manage orders

Manage coupons

Manage reviews

View dashboard statistics

Monitor inventory

🔌 REST API

The project also provides a versioned RESTful API:

/api/v1

The API is designed to support external clients such as:

React applications

Flutter applications

Mobile applications

Other third-party clients

API Features

Sanctum token authentication

API Resources

Pagination

Filtering

Sorting

Validation

JSON responses

Localization

Policies and authorization

🔑 API Authentication

API authentication uses Laravel Sanctum.

Authorization: Bearer {token}

API versioning:

/api/v1/...

🌍 API Localization

The API supports Arabic and English using the Accept-Language header.

Arabic:

Accept-Language: ar

English:

Accept-Language: en

Example:

GET /api/v1/...
Accept: application/json
Accept-Language: ar

💳 Payment Flow

The Stripe payment flow is designed around PaymentIntents and webhooks.

Customer
   │
   ▼
Create Order
   │
   ▼
Create PaymentIntent
   │
   ▼
Stripe
   │
   ▼
Payment Confirmation
   │
   ▼
Stripe Webhook
   │
   ▼
Update Order Payment Status
   │
   ▼
Update Stock

📬 Queues & Jobs

Background operations are handled using Laravel Jobs and Queues to avoid blocking normal HTTP requests.

Examples:

Welcome emails

OTP verification emails

Order confirmation emails

Other asynchronous notifications

🧪 Testing

Automated testing is currently being implemented using PHPUnit.

Run the test suite:

php artisan test

Planned/ongoing feature coverage includes:

Authentication

Products

Cart

Checkout

Orders

Coupons

Reviews

Wishlist

Addresses

Payments

Testing is currently in progress and coverage will continue to increase.

⚙️ Installation

1. Clone the repository

git clone YOUR_REPOSITORY_URL
cd Ecommerce_Perfum

2. Install PHP dependencies

composer install

3. Configure environment

cp .env.example .env

Generate the application key:

php artisan key:generate

4. Configure the database

Update the database settings in .env.

Then run:

php artisan migrate

If seeders are available:

php artisan db:seed

5. Create storage link

php artisan storage:link

6. Start the application

php artisan serve

🔐 Environment Variables

Configure the required values in .env.

APP_NAME=
APP_ENV=
APP_KEY=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

QUEUE_CONNECTION=
CACHE_STORE=

Never commit .env files or secret keys to GitHub.

📁 Project Structure

Important backend directories:

app/
├── Filters/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Interfaces/
├── Jobs/
├── Models/
├── Policies/
├── Repositries/
└── Servicies/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── lang/
└── views/

routes/
├── api.php
└── web.php

Directory names reflect the current project structure.

🚀 Current Status

Module

Status

Web Application

✅

REST API

✅

Authentication

✅

Authorization

✅

Products

✅

Categories

✅

Brands

✅

Cart

✅

Wishlist

✅

Checkout

✅

Orders

✅

Reviews

✅

Coupons

✅

Stripe

✅

Cash on Delivery

✅

Admin Dashboard

✅

Localization

✅

Queues & Jobs

✅

PHPUnit Testing

🚧

Performance & DB Optimization

🚧

API Documentation

🚧

Production Deployment

🚧

🔮 Future Improvements

Increase automated test coverage

Database indexing and query optimization

Complete API documentation

Production deployment

Monitoring and logging improvements

Further caching optimization

🛠️ Tech Stack

Backend

PHP 8.2+

Laravel 12

MySQL

Laravel Sanctum

Spatie Laravel Permission

Payments

Stripe

Infrastructure

Redis

Laravel Queue

Testing & Development

PHPUnit

Postman

Git / GitHub

Frontend

Blade

HTML5

CSS3

JavaScript

Bootstrap

👨‍💻 Author

Mohamed Shokr

Laravel Backend Developer

PHP · Laravel · MySQL · REST API · Sanctum · Stripe · Redis · PHPUnit

⭐ Project

If you find this project useful or interesting, feel free to explore the source code and leave a star.
