# 💳 Mini Bank System

> A full-stack banking application built as a personal practice project to master **Vue 3 + Inertia.js + Laravel Sanctum**. Features a modern SPA experience with secure token-based authentication.

---

## ✨ Features

### 🏦 Banking Modules
- Account creation and management
- Deposit, withdrawal, and fund transfer
- Transaction history with filters
- Account balance dashboard

### 📊 Analytics
- Interactive charts using Chart.js
- Transaction trends visualization
- Account summary reports

### 🔐 Security
- Token-based authentication (Laravel Sanctum)
- Session handling and route protection
- Input validation on all operations

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel (PHP) |
| Frontend | Vue 3 (Composition API) |
| Routing | Inertia.js (SPA without separate API) |
| Auth | Laravel Sanctum |
| Styling | Tailwind CSS |
| Charts | Chart.js |
| Database | MySQL |

---

## 💡 Why I Built This

I wanted to learn **Vue 3 + Inertia.js** in a real-world context — not just follow tutorials. Building a banking system forced me to handle:
- Complex state management
- Secure authentication flows
- Real-time data visualization
- Financial transaction logic with data integrity

---

## 🚀 Getting Started

```bash
# Clone the repo
git clone https://github.com/Triveni-Hemne/mini-bank.git
cd mini-bank

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start servers
php artisan serve
npm run dev
```

---

## 📂 Project Structure

```
mini-bank/
├── app/
│   ├── Http/Controllers/    # Account, Transaction, Auth
│   └── Models/              # User, Account, Transaction
├── resources/
│   └── js/
│       ├── Pages/           # Vue 3 Inertia pages
│       └── Components/      # Reusable components
├── routes/
│   └── web.php              # Inertia routes
└── database/
    └── migrations/          # DB schema
```

---

## 👩‍💻 Developer

**Triveni Hemne** — Full Stack Developer | Laravel + Vue.js  
🔗 [LinkedIn](https://linkedin.com/in/triveni-hemne-6a30b1211)  
🌐 [Portfolio](https://triveni-hemne.github.io/my-portfolio/)  
📧 trivenihemne1999@gmail.com
