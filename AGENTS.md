# FamilyGest - Architettura e Specifiche Tecniche

## 📋 Descrizione Applicazione

**FamilyGest** è un'applicazione web modulare costruita con **Laravel 13**, progettata per gestire aspetti familiari attraverso un sistema di moduli estensibili e facilmente scalabile.

## 🔧 Stack Tecnologico

### Framework e Dipendenze Principali
- **Laravel 13** - Framework PHP moderno per lo sviluppo backend
- **jeroennoten/laravel-adminlte** - Template amministrativo responsivo e professionale
- **spatie/backup-laravel** - Sistema di backup automatico per database e file
- **dompdf/dompdf** - Generazione di documenti PDF dinamici
- **maatwebsite/excel** - Generazione di file Excel/ods dinamici
## 🏗️ Architettura

### Approccio Modulare/Plugin

L'applicazione utilizzerà un **sistema modulare a plugin** che consente:

- ✅ **Facilità di implementazione** di nuovi moduli futuri
- ✅ **Isolamento funzionale** - Ogni modulo è auto-contenuto
- ✅ **Scalabilità** - Aggiungere nuove funzionalità senza impattare il core
- ✅ **Manutenibilità** - Moduli indipendenti e testabili
- ✅ **Disabilitazione selettiva** - Attivare/disattivare moduli secondo necessità

### Struttura Directory Modulare (Proposta)

```
app/
├── Modules/
│   ├── ModuleInterface.php          # Interfaccia base per i moduli
│   ├── ModuleServiceProvider.php    # Service provider generico
│   ├── ModuleManager.php            # Gestore centrale moduli
│   │
│   ├── FamilyMembers/               # Modulo 1: Gestione Membri
│   │   ├── Models/
│   │   ├── Controllers/
│   │   ├── Views/
│   │   ├── Routes/
│   │   ├── Migrations/
│   │   └── FamilyMembersServiceProvider.php
│   │
│   ├── Documents/                   # Modulo 2: Gestione Documenti
│   │   ├── Models/
│   │   ├── Controllers/
│   │   ├── Views/
│   │   ├── Routes/
│   │   ├── Migrations/
│   │   └── DocumentsServiceProvider.php
│   │
│   └── [Futuri Moduli]/
│
config/
├── modules.php                      # Configurazione moduli
└── backup.php                       # Configurazione backup

```

## 📦 Moduli Previsti

### Moduli Iniziali (In Sviluppo)
- [x] **Auth** - Scaffolding autenticazione (login, register, password reset, email verify) con AdminLTE
- [x] **FamilyMembers** - Gestione membri famiglia, profili e relazioni
- [x] **Economy** - Gestione delle entrate e delle uscite con rendicontazione mensile in base alle categorie
- [ ] **Documents** - Gestione documenti, archivio digitale con export PDF

### Moduli Futuri (Placeholder)
- [ ] [Modulo aggiuntivo 1]
- [ ] [Modulo aggiuntivo 2]
- [ ] [Continua...]

## 🎨 Frontend

- **Template AdminLTE** - Interfaccia admin-style responsiva
- **Layout personalizzato** - Dashboard principale e moduli specifici
- **Layout in PDF** - professionali e compatti con colori tendenti al verdino o arancine pastello.

## 💾 Backup e Sicurezza

- **Backup automatici** configurati via `spatie/backup-laravel`
- **Database backup** periodici
- **File storage backup** per documenti e allegati

## 📄 Generazione PDF

- **dompdf** per la generazione dinamica di documenti PDF
- Utilizzo per report, certificati, esportazioni da moduli

## REST API
- **sanctum** per le API in quanto l' applicazione avrà anche una app Android che potrà inserire i dati

## 🚀 Roadmap Sviluppo

1. ✅ Setup infrastruttura base Laravel 13
2. ✅ Implementazione sistema modulare
3. ✅ Creazione primo modulo (FamilyMembers)
4. ✅ Auth scaffolding (login/register/password-reset/verify con AdminLTE)
5. ✅ Setup AdminLTE e dashboard
6. ✅ Dashboard dinamica con widget modulari e impostazioni utente
7. ✅ Modulo Economy (account, categorie, transazioni, import CSV)
8. ⏳ Configurazione backup automatici
9. ⏳ Integrazione dompdf per export
10. ⏳ Testing e ottimizzazione

## 📊 Sistema Dashboard

La dashboard è **dinamica e modulare**: ogni modulo può registrare widget che vengono visualizzati automaticamente.

### Come aggiungere un widget da un modulo

1. Il modulo implementa `getDashboardWidgets()` nel suo ServiceProvider
2. Restituisce un array di `DashboardWidget` con: id, title, icon, view, width, dataCallback
3. Il widget view va in `Modules/[Nome]/Views/dashboard/widgets/`
4. Il `DashboardManager` registra automaticamente i widget in fase di boot

### Preferenze Utente

Ogni utente può personalizzare la propria dashboard da `/dashboard/settings`:
- Attivare/disattivare widget
- Riordinare i widget (freccia su/giù)
- Personalizzare la larghezza (3, 4, 6, 8, 12 colonne)

Le preferenze sono salvate nella tabella `user_dashboard_preferences`.

## 📝 Note per lo Sviluppo

- I nuovi moduli possono essere aggiunti in qualsiasi momento
- Ogni modulo deve implementare `ModuleInterface` (incluso `getDashboardWidgets()`)
- I moduli vengono registrati automaticamente in `modules.php`
- Seguire il pattern SOLID e clean code principles
