# Sistem BSAN (Budaya Sekolah Aman dan Nyaman)

Sistem informasi untuk monitoring dan pengelolaan Pokja (Kelompok Kerja) Budaya Sekolah Aman dan Nyaman di seluruh Indonesia — dibangun dengan CodeIgniter 4 dan Supabase.

## Fitur Utama

- **Dashboard Interaktif** — Visualisasi data Pokja dengan peta Indonesia, grafik, dan tabel
- **Peta Indonesia SVG** — Drill-down dari provinsi ke kabupaten/kota dengan status Pokja
- **Data Publik** — Halaman publik untuk melihat status pembentukan Pokja nasional
- **Manajemen Pokja** — CRUD anggota, SK, dan status Pokja per wilayah
- **Sumber Rujukan** — Kelola daftar sumber rujukan dan dukungan
- **Admin Panel** — Kelola pengguna, role, dan undangan (Puspeka & Irjen only)
- **Multi-role Auth** — Demo accounts + Supabase auth dengan 4 role (admin, kementerian, dinas_prov, dinas_kab)
- **Dark Mode** — Full dark mode support di semua halaman

---

## Arsitektur

```
┌─────────────────────────────────────────────────────┐
│                     BROWSER                         │
│   Public Pages ─── Dashboard ─── Admin Panel        │
│   (main.php)       (dashboard.php layout)           │
└──────────┬──────────────────────────┬───────────────┘
           │                          │
┌──────────▼──────────────────────────▼───────────────┐
│              CodeIgniter 4 (PHP 8.x)                │
│  Routes.php ── Controllers ── Views ── Filters      │
│                     │                               │
│              SupabaseClient.php                      │
└──────────────────────┬──────────────────────────────┘
                       │ REST API (PostgREST + GoTrue)
              ┌────────▼────────┐
              │    Supabase     │
              │  PostgreSQL DB  │
              │  Auth (GoTrue)  │
              │  Row Level Sec  │
              └─────────────────┘
```

### Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | CodeIgniter 4 (PHP 8.x) |
| Database | Supabase (PostgreSQL + GoTrue Auth) |
| Frontend | HTML, CSS, JavaScript (vanilla) |
| Dashboard CSS | Tailwind CSS |
| Public CSS | Vanilla CSS (app.css, components.css) |
| Charts | Chart.js 4 |
| Tables | DataTables.net |
| Maps | Custom SVG (admin-map.js, map-visualization.js) |

---

## Quick Start

### Prerequisites

- PHP 8.1+
- Composer
- Supabase project (or demo mode)

### Installation

```bash
git clone <repo-url> sistem-bsan-dev
cd sistem-bsan-dev
composer install
cp env .env
```

### Environment Variables

| Variable | Deskripsi | Default | Required |
|----------|-----------|---------|----------|
| `SUPABASE_URL` | URL Supabase project | Hardcoded default | No |
| `SUPABASE_ANON_KEY` | Supabase anon/public key | Hardcoded default | No |
| `SUPABASE_SERVICE_KEY` | Supabase service role key | — | **Yes (production)** |
| `CI_ENVIRONMENT` | `development` atau `production` | `development` | No |

> ⚠️ **PENTING**: `SUPABASE_SERVICE_KEY` **TIDAK BOLEH** di-hardcode. Gunakan environment variable.

### Menjalankan

```bash
php spark serve --port 8080
```

Buka `http://localhost:8080`

---

## Demo Accounts

| Email | Password | Role | Unit Kerja |
|-------|----------|------|-----------|
| `admin@bsan.id` | `admin123` | `admin` (super admin) | Puspeka |
| `irjen@bsan.id` | `irjen123` | `kementerian` | Inspektorat Jenderal |
| `jateng@bsan.id` | `jateng123` | `dinas_prov` | Jawa Tengah |
| `surakarta@bsan.id` | `surakarta123` | `dinas_kab` | Kota Surakarta |
| `dki@bsan.id` | `dki123` | `dinas_prov` | DKI Jakarta |
| `bandung@bsan.id` | `bandung123` | `dinas_kab` | Kota Bandung |

### Role Hierarchy

```
admin (Puspeka)         → Full access, admin panel, semua wilayah
kementerian (Irjen)     → Admin panel access, semua wilayah
dinas_prov              → Dashboard per provinsi
dinas_kab               → Dashboard per kabupaten/kota
```

---

## Route Map

### Public Routes (no auth)

| Method | Path | Controller | View |
|--------|------|-----------|------|
| GET | `/` | `Home::index` | `home/index` |
| GET | `/data-publik` | `DataPublik::index` | `data_publik/index` |
| GET | `/faq` | `Faq::index` | `faq/index` |

### Auth Routes

| Method | Path | Controller |
|--------|------|-----------|
| GET/POST | `/auth/login` | `Auth::login / doLogin` |
| GET/POST | `/auth/register` | `Auth::register / doRegister` |
| GET/POST | `/auth/forgot-password` | `Auth::forgotPassword / doForgotPassword` |
| GET/POST | `/auth/reset-password` | `Auth::resetPassword / doResetPassword` |
| GET | `/auth/callback` | `Auth::callback` |
| GET | `/auth/logout` | `Auth::logout` |

### Dashboard Routes (auth required)

| Method | Path | Controller | View |
|--------|------|-----------|------|
| GET | `/dashboard` | `Dashboard::index` | `dashboard/index` |
| GET/POST | `/dashboard/profile` | `Profile::index / update` | `dashboard/profile` |
| GET | `/dashboard/pokja` | `Pokja::index` | `dashboard/pokja` |
| POST | `/dashboard/pokja/invite` | `Pokja::invite` | — |
| GET | `/dashboard/pelaporan` | `Pelaporan::index` | `dashboard/pelaporan` |
| GET | `/dashboard/sumber-dukungan` | `SumberDukungan::index` | `dashboard/sumber_dukungan` |
| GET | `/dashboard/sumber-rujukan` | `Rujukan::index` | `dashboard/rujukan` |
| POST | `/dashboard/sumber-rujukan/store` | `Rujukan::store` | — |
| POST | `/dashboard/sumber-rujukan/update` | `Rujukan::update` | — |
| POST | `/dashboard/sumber-rujukan/delete` | `Rujukan::delete` | — |
| GET | `/dashboard/log-aktivitas` | `Dashboard::logAktivitas` | `dashboard/log-aktivitas` |
| GET | `/dashboard/admin` | `Admin::index` | `dashboard/admin` |
| POST | `/dashboard/admin/invite` | `Admin::invite` | — |
| POST | `/dashboard/admin/update-role` | `Admin::updateRole` | — |
| POST | `/dashboard/admin/update-status` | `Admin::updateStatus` | — |

### API Routes (AJAX)

| Method | Path | Controller |
|--------|------|-----------|
| GET | `/api/dashboard/stats` | `Dashboard::stats` |
| GET | `/api/pokja/list` | `Pokja::list` |
| GET | `/api/admin/users` | `Admin::users` |
| GET | `/api/rujukan/list` | `Rujukan::list` |

---

## Struktur Project

```
sistem-bsan-dev/
├── app/
│   ├── Config/
│   │   └── Routes.php              # Route definitions
│   ├── Controllers/
│   │   ├── Admin.php                # Admin panel (role: admin/kementerian)
│   │   ├── Auth.php                 # Authentication + demo accounts
│   │   ├── Dashboard.php            # Main dashboard + stats API
│   │   ├── DataPublik.php           # Public data page
│   │   ├── Faq.php                  # FAQ page
│   │   ├── Home.php                 # Landing page
│   │   ├── Pelaporan.php            # Reporting page
│   │   ├── Pokja.php                # Pokja management
│   │   ├── Profile.php              # User profile
│   │   ├── Rujukan.php              # Rujukan CRUD
│   │   └── SumberDukungan.php       # Sumber dukungan page
│   ├── Filters/
│   │   └── AuthFilter.php           # Session-based auth (skips on Vercel)
│   ├── Libraries/
│   │   └── SupabaseClient.php       # Supabase REST client
│   └── Views/
│       ├── layouts/
│       │   ├── main.php             # Public layout (vanilla CSS)
│       │   └── dashboard.php        # Dashboard layout (Tailwind)
│       ├── auth/                    # Login, register, forgot/reset password
│       ├── dashboard/               # Dashboard views
│       ├── data_publik/             # Public data visualization
│       ├── faq/                     # FAQ content
│       └── home/                    # Landing page
├── public/
│   └── assets/
│       ├── css/
│       │   ├── app.css              # Main CSS (public + dashboard)
│       │   └── components.css       # Public component styles
│       ├── js/
│       │   ├── admin-map.js         # SVG map for admin dashboard
│       │   ├── app.js               # Theme, nav, helpers
│       │   ├── data-publik.js       # Data publik page logic
│       │   ├── data-publik-data.js  # Wilayah data + demo generator
│       │   ├── map-visualization.js # SVG map renderer
│       │   ├── wilayah-data.js      # Province/kabupaten data (UTF-16)
│       │   └── utils/
│       │       ├── csvExport.js     # CSV export utility
│       │       ├── mapConfig.js     # Map configuration + colors
│       │       └── statusConfig.js  # ★ Centralized status definitions
│       ├── data/                    # GeoJSON, JSON data files
│       └── icon/                    # Logos, favicons
└── composer.json
```

---

## Status Pokja (Centralized Config)

Semua status didefinisikan di `public/assets/js/utils/statusConfig.js`:

| Status | Warna | Icon | Raw Keys |
|--------|-------|------|----------|
| Disetujui | `#10b981` (emerald) | ✓ | `approved`, `disetujui` |
| Pending | `#f59e0b` (amber) | ⏳ | `pending` |
| Draft | `#3b82f6` (blue) | 📝 | `draft` |
| Ditolak | `#ef4444` (red) | ✗ | `declined`, `ditolak`, `rejected` |
| Belum Ada | `#9ca3af` (gray) | ○ | `belum_ada`, `none`, `""` |

Files yang menggunakan config ini:
- `admin-map.js` — AM_STATUS computed dari POKJA_STATUS
- `mapConfig.js` — STATUS_COLORS dan getStatusColor()
- `map-visualization.js` — filter options dan legend items
- `data-publik/index.php` — status badge di tabel

---

## Security

- **AuthFilter** — Proteksi route `/dashboard/*` via session check
- **Vercel bypass** — AuthFilter skip auth di Vercel (serverless = no PHP session)
- **Supabase RLS** — Row Level Security sebagai primary data access control
- **Service key** — Hanya via environment variable, TIDAK di-commit
- **Demo accounts** — Bypass Supabase auth, hardcoded credentials untuk development

---

## Data Sync (Dashboard ↔ Data Publik)

Dashboard menulis data Pokja ke `localStorage` (key: `bsan_pokja_sync`) setiap kali data di-render. Halaman Data Publik membaca sync ini untuk menampilkan data yang sama.

```
Dashboard                           Data Publik
   │                                    │
   ├─ Fetches from Supabase             │
   ├─ Renders dashboard                 │
   ├─ Writes to localStorage ──────────►│ Reads localStorage
   │   key: 'bsan_pokja_sync'           ├─ If entry mode + sync: use sync data
   │   { submissions, updatedAt,        ├─ If entry mode + no sync: "Belum Ada" + notice
   │     source: 'demo'|'entry' }       └─ If demo mode: generate demo data
```

---

## Deployment

### Local Development

```bash
php spark serve --port 8080
```

### Vercel (Serverless)

- AuthFilter auto-detects Vercel environment
- Set `SUPABASE_SERVICE_KEY` di Vercel Environment Variables
- PHP sessions tidak tersedia — auth di-bypass

---

## Changelog (2026-02-15)

### Added
- Rujukan CRUD routes (`/dashboard/sumber-rujukan/store|update|delete`)
- Rujukan API endpoint (`/api/rujukan/list`)
- `irjen@bsan.id` demo account (Inspektorat Jenderal, role: kementerian)
- `public/assets/js/utils/statusConfig.js` — single source of truth for all status definitions
- No-sync-data notice on Data Publik entry mode
- `unit_kerja` field in session data

### Changed
- Admin role check: now accepts both `admin` and `kementerian` roles
- Demo admin renamed from "Admin Demo" to "Admin Puspeka"
- `admin-map.js`, `mapConfig.js`, `map-visualization.js` refactored to use centralized statusConfig
- Improved `dpLoadData()` with clearer entry/demo mode separation

### Removed
- `fix_dashboard.js` (stale debug script at project root)
- `public/assets/js/wilayahData.js` (unused duplicate, not loaded by any PHP file)
