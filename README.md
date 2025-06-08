<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## 🚌 Bus Monitoring API with Laravel + Reverb

A Laravel-based backend API for a real-time bus monitoring system with RESTful endpoints, GPS updates, and Laravel Reverb (WebSocket) integration.

---

## 🔗 Base URL

## 🔐 Authentication

## 🔸 Register

**POST** `/api/register`

**Request JSON:**
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "driver"
}
```

## 🔸 Login

**POST** `/api/login`

**Request JSON:**
```json
{
  "email": "budi@example.com",
  "password": "password123"
}
``` 

## 🔸 Get Authenticated User

**POST** `/api/user`

**Headers:** `Authorization: Bearer <token>`

## 🚌 Bus Endpoints 

**GET** `/api/buses`  - Get all buses \
**GET** `/api/buses/active`  - Get active buses \
**GET** `/api/buses/{bus}/locations`  - Get location history \
**GET** `/api/buses/nearby?lat=-6.2&lng=106.8`  - Get nearby buses 

## 🛣️ Route Endpoints 

**GET** `/api/routes`  - List all routes \
**GET** `/api/routes/{route}`  - Route details 


## 📡 GPS Update Endpoint

**POST** `/api/gps-update` \
**Middleware:** `gps.device.auth`

**Request JSON:**
```json
{
  "bus_id": 1,
  "latitude": -6.2011,
  "longitude": 106.8200,
  "speed": 35.5,
  "heading": 90.0,
  "device_time": "2025-06-08T10:00:00Z"
}
```


## 📢 WebSocket Auth 

**POST** `/broadcasting/auth` 


## 📥 Required Headers

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```


---

## 🚀 Getting Started

### 🔧 Requirements

- PHP 8.4.6+
- Composer
- Node.js & npm
- Redis (for broadcasting)
- Laravel Reverb installed

### 📦 Installation

```bash
git clone https://github.com/your-username/bus-monitoring-api.git
cd bus-monitoring-api

# Install dependencies
composer install
npm install && npm run build

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your .env (DB, Redis, Sanctum, Broadcasting, etc.)
