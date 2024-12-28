# Event Management API

A robust Laravel-based API for managing events, artists, locations, organizers, and registrations. Built with **Laravel**, **Spatie Laravel Permission**, **Laravel Sanctum**, and **Laravel Query Builder**.

---

## Features

- **Event Management**: CRUD operations for events.
- **Role-Based Access Control**: Manage roles and permissions for users.
- **Authentication**: Secure API endpoints using Laravel Sanctum.
- **Media Management**: Upload and manage event images using Laravel Media Library.
- **Excel Import**: Bulk register users for events via Excel upload.
- **PDF Generation**: Download event details as PDF.
- **Search and Filtering**: Advanced search and filtering for events, artists, and more.

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** (>= 8.2)
- **Laragon**
- **Composer**
- **MySQL** or another supported database
- **Git CLI or Desktop**

---

## Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/event-management-api.git
cd event-management-api
```
### Step 2: Install packages

```bash
composer install
```
### Step 3: Install packages

```bash
copy .env.example .env; php artisan key:generate; php artisan migrate --seed
```
### Step 4: Run the app :) Happy Coding

