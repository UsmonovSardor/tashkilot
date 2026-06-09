# VelvetHour — Ultra-Premium Concierge & Event Platform

> *Where exclusivity meets experience.*

A high-end, invitation-only concierge platform offering elite companion matching, luxury venue booking, and chauffeur fleet services. Built for investors, VIP clients, and premium lifestyle brands.

---

## Architecture Overview

```
velvet-hour/
├── backend/          # Laravel 11 — Clean Architecture (Repository + Service pattern)
│   ├── app/
│   │   ├── Domain/   # Business logic (pure PHP, framework-agnostic)
│   │   ├── Http/     # Controllers, Middleware, Requests (thin layer)
│   │   ├── Models/   # Eloquent models
│   │   ├── Repositories/  # Data access abstraction
│   │   └── Services/ # Application services (Matching, Escrow, Pricing)
│   └── database/
│       ├── migrations/
│       └── seeders/  # Comprehensive demo data (15+ companions, 8+ vehicles, 5+ venues)
└── frontend/         # Next.js 14 + TailwindCSS + TypeScript
    ├── app/          # App Router pages
    ├── components/   # Reusable UI components
    └── types/        # Strict TypeScript interfaces
```

---

## Database Schema (ERD Summary)

### Core Entities

| Table | Purpose |
|---|---|
| `users` | Auth + RBAC (client, companion, driver, admin) |
| `companions` | Elite partner profiles with skills, languages, rates |
| `companion_photos` | Multi-photo with privacy blur control |
| `venues` | Luxury venues with slot-based availability |
| `venue_slots` | Real-time slot availability & dynamic pricing |
| `vehicles` | Luxury fleet (Rolls-Royce, Maybach, etc.) |
| `drivers` | Chauffeur profiles linked to vehicles |
| `bookings` | Polymorphic bookings (venue/companion/fleet) |
| `booking_addons` | VIP add-ons (catering, florals, security) |
| `payments` | Payment ledger |
| `escrow_transactions` | Escrow state machine (held → released/refunded) |
| `ai_match_scores` | ML-powered companion↔event matching cache |
| `reviews` | Bidirectional verified reviews |

---

## API Endpoint Map

### Auth
```
POST   /api/v1/auth/register
POST   /api/v1/auth/login
POST   /api/v1/auth/refresh
DELETE /api/v1/auth/logout
```

### Companions
```
GET    /api/v1/companions              # Filtered list (gender, skills, language, price)
GET    /api/v1/companions/{id}         # Full profile (blur status based on booking)
POST   /api/v1/companions/{id}/book    # Book a companion
GET    /api/v1/companions/ai-match     # AI-powered matching by event type
```

### Venues
```
GET    /api/v1/venues                  # List with availability
GET    /api/v1/venues/{id}/slots       # Real-time slot availability
POST   /api/v1/venues/{id}/book        # Reserve a slot
GET    /api/v1/venues/{id}/pricing     # Dynamic price calculator
```

### Fleet
```
GET    /api/v1/fleet                   # Available luxury vehicles
GET    /api/v1/fleet/{id}/drivers      # Available chauffeurs
POST   /api/v1/fleet/{id}/book         # Book vehicle + driver
```

### Bookings
```
GET    /api/v1/bookings                # User's booking history
GET    /api/v1/bookings/{id}           # Booking detail with escrow status
PATCH  /api/v1/bookings/{id}/cancel    # Cancel (triggers escrow refund flow)
PATCH  /api/v1/bookings/{id}/complete  # Mark complete (triggers escrow release)
```

### Payments / Escrow
```
POST   /api/v1/payments/intent         # Create payment intent
POST   /api/v1/payments/confirm        # Confirm & lock escrow
POST   /api/v1/escrow/{id}/release     # Release funds to provider
POST   /api/v1/escrow/{id}/dispute     # Open dispute
```

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.3 |
| Database | PostgreSQL 16 |
| Cache | Redis |
| Auth | JWT (tymon/jwt-auth) |
| Frontend | Next.js 14, React 18, TypeScript 5 |
| Styling | TailwindCSS 3, Framer Motion |
| Payments | Stripe (escrow via PaymentIntents) |
| AI Matching | OpenAI Embeddings (cosine similarity) |
| Deployment | Docker + Railway/Render |

---

## Quick Start

```bash
# Backend
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate:fresh --seed   # Loads all demo data
php artisan serve

# Frontend
cd frontend
npm install
cp .env.local.example .env.local
npm run dev
```

---

## Design System

- **Primary Background:** `#0A0A0A` (obsidian)
- **Surface:** `#121212` (rich charcoal)
- **Elevated Surface:** `#1A1A1A`
- **Gold Accent:** `#D4AF37` (luxury gold)
- **Platinum:** `#E8E8E8`
- **Typography:** Playfair Display (headings) + Inter (body)
- **Motion:** Framer Motion — 300ms ease-out standard, skeleton loaders on all data

---

*VelvetHour — Built for the 1%.*
