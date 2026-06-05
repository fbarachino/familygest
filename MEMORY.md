# MEMORY.md — FamilyGest

## Stato Attuale (5 Giugno 2026)

### ✅ Completato

#### Infrastruttura Base
- [x] Laravel 13 installato e configurato
- [x] AdminLTE 3 installato e configurato (`jeroennoten/laravel-adminlte`)
- [x] Laravel Sanctum installato per API token auth
- [x] dompdf, maatwebsite/excel, spatie/laravel-backup installati (pronti all'uso)

#### Sistema Modulare
- [x] `app/Modules/ModuleInterface.php` — Interfaccia base per tutti i moduli
- [x] `app/Modules/ModuleManager.php` — Gestore centrale moduli (register/boot/discover)
- [x] `config/modules.php` — Configurazione registrazione moduli
- [x] Autoloading PSR-4 per `App\Modules\` in `composer.json`
- [x] Registrazione moduli via `AppServiceProvider`

#### Modulo FamilyMembers
- [x] **Migration**: `family_members` con campi estesi (nome, cognome, data_nascita, luogo_nascita, relazione, CF, telefono, email, indirizzo, foto, note + soft delete)
- [x] **Model**: `FamilyMember` con `$fillable`, `$casts`, attributo calcolato `eta`, accessor `foto_url`, soft deletes, factory, relazione `belongsTo User`
- [x] **User Model**: relazione `hasMany FamilyMember`
- [x] **Form Requests**: `StoreFamilyMemberRequest` e `UpdateFamilyMemberRequest` con validazione completa
- [x] **Web Controller**: CRUD completo con upload foto
- [x] **API Controller**: CRUD RESTful JSON protetto da `auth:sanctum`
- [x] **Views**: index, create, edit, show con layout AdminLTE
- [x] **Routes Web**: `resource` sotto `family-members`
- [x] **Routes API**: `apiResource` sotto `api/v1/family-members`
- [x] **ServiceProvider**: Caricamento migrations, views e routes del modulo
- [x] **Fix**: Routes module wrappate in middleware group `web` + `auth` per risolvere `Undefined variable $errors` (mancava `ShareErrorsFromSession`)
- [x] **User-FamilyMember association**: migration `add_user_id_to_family_members_table`, FK `user_id` → `users`. Se l'email del FamilyMember corrisponde a uno User, `user_id` viene impostato automaticamente in `store()`/`update()` (sia web che API)

### Struttura File

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── ResetPasswordController.php
│   │   │   ├── ConfirmPasswordController.php
│   │   │   └── VerificationController.php
│   │   ├── Controller.php              # Estende Illuminate\Routing\Controller
│   │   ├── HomeController.php
│   │   ├── DashboardController.php
│   │   └── DashboardSettingsController.php
├── Models/
│   ├── User.php
│   └── UserDashboardPreference.php
├── Modules/
│   ├── ModuleInterface.php
│   ├── ModuleManager.php
│   ├── DashboardWidget.php
│   ├── DashboardManager.php
│   ├── FamilyMembers/
│   └── Economy/
│       ├── FamilyMembersServiceProvider.php
│       ├── Controllers/
│       │   ├── FamilyMemberController.php
│       │   └── FamilyMemberApiController.php
│       ├── Models/
│       │   └── FamilyMember.php
│       ├── Requests/
│       │   ├── StoreFamilyMemberRequest.php
│       │   └── UpdateFamilyMemberRequest.php
│       ├── Routes/
│       │   ├── web.php
│       │   └── api.php
│       └── Views/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
config/
├── modules.php
└── adminlte.php          # use_route_url: true, route names per auth, menu Economia + Dashboard Settings
resources/
├── views/
│   └── dashboard/
│       ├── index.blade.php
│       └── settings.blade.php
└── lang/
    └── it/
        └── menu.php      # Traduzioni menu italiani
database/
├── factories/
│   └── FamilyMemberFactory.php
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── 0001_01_01_000001_create_cache_table.php
    ├── 0001_01_01_000002_create_jobs_table.php
    ├── 2026_06_05_000001_create_family_members_table.php
    ├── 2026_06_05_051545_create_personal_access_tokens_table.php
    └── 2026_06_05_110000_create_user_dashboard_preferences_table.php
routes/
└── web.php               # Auth routes + dashboard + dashboard settings
```

### Campi Modello FamilyMember

| Campo | Tipo | Note |
|---|---|---|
| nome | string | required |
| cognome | string | required |
| data_nascita | date | required, before:today |
| luogo_nascita | string | nullable |
| relazione | enum | padre/madre/figlio/figlia/nonno/nonna/zio/zia/cugino/cugina/altro |
| codice_fiscale | string(16) | unique, nullable |
| telefono | string(20) | nullable |
| email | email | nullable |
| indirizzo | text | nullable |
| foto | string (path) | nullable, image mimes |
| user_id | FK (users) | nullable, associato automaticamente se email corrisponde a User |
| note | text | nullable |
| deleted_at | timestamp | soft delete |

### Rotte Web (middleware: web + auth)
- `GET /family-members` — index
- `GET /family-members/create` — create form
- `POST /family-members` — store
- `GET /family-members/{id}` — show
- `GET /family-members/{id}/edit` — edit form
- `PUT/PATCH /family-members/{id}` — update
- `DELETE /family-members/{id}` — destroy

### Rotte API (auth:sanctum)
- `GET /api/v1/family-members` — index
- `POST /api/v1/family-members` — store
- `GET /api/v1/family-members/{id}` — show
- `PUT/PATCH /api/v1/family-members/{id}` — update
- `DELETE /api/v1/family-members/{id}` — destroy

### Auth Scaffolding
- [x] **LoginController** — `showLoginForm()` + `login()` + `logout()`
- [x] **RegisterController** — `showRegistrationForm()` + `register()` (con validazione, creazione utente, login automatico)
- [x] **ForgotPasswordController** — `showLinkRequestForm()` + `sendResetLinkEmail()` (via `Password::sendResetLink`)
- [x] **ResetPasswordController** — `showResetForm()` + `reset()` (via `Password::reset`)
- [x] **ConfirmPasswordController** — `showConfirmForm()` + `confirm()`
- [x] **VerificationController** — `show()` + `verify()` + `resend()` (email verification)
- [x] **HomeController** — Dashboard protetta da `auth` middleware
- [x] **Routes** — Rotte guest (login, register, password reset) e auth (logout, confirm, verify, home)
- [x] **Config `adminlte.php`**: `use_route_url => true`, URL aggiornati con nomi route corretti
- [x] **Controller base aggiornato**: estende `Illuminate\Routing\Controller`, usa `AuthorizesRequests` + `ValidatesRequests`
- [x] **Tests**: login page e home autenticata funzionanti

#### Modulo Economy
- [x] **Migration**: `account_types`, `categories`, `transactions` con FK e soft delete
- [x] **Models**: `AccountType` (con `hasMany Transaction`), `Category` (con `hasMany Transaction`, enum `tipo: entrata/spesa`), `Transaction` (con `belongsTo AccountType`, `belongsTo Category`, `SoftDeletes`)
- [x] **Form Requests**: Store/Update per ogni model con validazione
- [x] **Web Controllers**: CRUD per AccountTypes, Categories, Transactions
- [x] **API Controllers**: CRUD JSON sotto `api/v1/economy/*` (auth:sanctum)
- [x] **Views**: CRUD con AdminLTE per ogni risorsa (index, create, edit, show)
- [x] **Routes Web**: `economy/account-types`, `economy/categories`, `economy/transactions`, `economy/import` (auth)
- [x] **Routes API**: `api/v1/economy/account-types`, `api/v1/economy/categories`, `api/v1/economy/transactions` (auth:sanctum)
- [x] **ServiceProvider**: `EconomyServiceProvider` caricamento migrations, views, routes web
- [x] **CSV Import**: upload file, rilevamento automatico delimitatore, preview prime 10 righe, mappatura colonne → campi DB (data, importo, descrizione, note), import transazionale
- [x] **Menu AdminLTE**: sottomenu Economia con Tipi Conto, Categorie, Movimenti, Importa CSV
- [x] **Lang**: `resources/lang/it/menu.php` traduzioni menu italiani
- [x] **Seeders**: `AccountTypeSeeder` (7 tipi predefiniti), `CategorySeeder` (8 entrate + 16 spese)

#### Dashboard Dinamica
- [x] **DashboardWidget** (`app/Modules/DashboardWidget.php`) — Value object con: id, title, description, icon, view, width, dataCallback, enabledByDefault
- [x] **ModuleInterface** aggiornato con `getDashboardWidgets(): array` — ogni modulo dichiara i propri widget
- [x] **DashboardManager** (`app/Modules/DashboardManager.php`) — Service singleton che registra widget dai moduli, filtra per utente, sincronizza preferenze
- [x] **Migration**: `user_dashboard_preferences` (user_id, widget_id, enabled, order, column_width)
- [x] **Model**: `UserDashboardPreference` con relazione `belongsTo User`
- [x] **User Model**: relazione `hasMany UserDashboardPreference`
- [x] **DashboardController**: renderizza dashboard con widget attivi per l'utente, esegue dataCallback per ogni widget
- [x] **DashboardSettingsController**: pagina impostazioni con toggle on/off, riordino drag, larghezza personalizzabile
- [x] **View dashboard**: `resources/views/dashboard/index.blade.php` — renderizza widget in card AdminLTE
- [x] **View settings**: `resources/views/dashboard/settings.blade.php` — toggle, ordine, larghezza widget
- [x] **Widget FamilyMembers**: `total-members` (totale membri + nuovi questo mese)
- [x] **Widget Economy**: `monthly-income` (entrate mese), `monthly-expense` (spese mese), `monthly-balance` (bilancio), `recent-transactions` (ultime 5 transazioni), `categories-chart` (spese per categoria)
- [x] **Menu AdminLTE**: voce "Impostazioni Dashboard" aggiunta
- [x] **Home route** (`/`) → DashboardController (sostituisce HomeController vuoto)

### Prossimi Passi (da fare)
- [ ] Modulo Documents con export PDF
- [ ] Configurazione backup (spatie/laravel-backup)
- [ ] Testing e ottimizzazione
