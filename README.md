# 🎓 Study Tracker

<p align="center">
  <img src="https://readme-typing-svg.herokuapp.com?font=Fira+Code&size=22&pause=1200&color=4CAF50&center=true&vCenter=true&width=800&lines=Track+your+study+progress+the+smart+way;Subjects+%7C+Chapters+%7C+Lectures+%7C+Projects;Built+with+Laravel+%26+MySQL;Clean+Architecture+%7C+Real-Life+Logic" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql" />
  <img src="https://img.shields.io/badge/Architecture-Clean-success" />
  <img src="https://img.shields.io/badge/License-MIT-green" />
</p>

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=rect&color=gradient&height=2"/>
</p>

## 📌 Overview

**Study Tracker** is a Laravel-based web application designed to help students and learners **systematically track their academic progress**.

The system models **real-life academic structures**, allowing flexible relationships between:
- Subjects
- Chapters
- Lectures
- Sections & Labs
- Projects & Assignments

Built with **Laravel + MySQL**, the project follows **clean architecture principles**, making it scalable, maintainable, and production-ready.

---

## 🎬 Demo Preview

<p align="center">
  <img src="docs/demo.gif" alt="Study Tracker Demo" width="900"/>
</p>

> 📌 *Dashboard overview, subject flow, project progress tracking, and theme switching.*

---

## 🚀 Key Features

### 📚 Subject Management
- Create and manage subjects
- Each subject can include:
  - Chapters
  - Lectures
  - Labs / Sections
  - Projects

### 📖 Chapters & Lectures (Real-Life Logic)
- Chapters can be taught across **multiple lectures**
- Lectures can cover **multiple chapters**
- Many-to-many relationships (academic reality)

### 🛠 Projects & Progress Tracking
- Attach projects to subjects
- Track completion percentage
- Visual progress indicators

### 🎨 User Profiles & Themes
- User profile management
- Theme customization:
  - Programmer theme (default)
  - Soft / Academic theme
  - Club-inspired theme

### 🧩 Clean Architecture
- Domain-driven folder structure
- Clear separation of concerns
- Service & domain layers
- Ready for APIs and mobile apps

---

## 🎨 Themes Preview

<p align="center">
  <img src="docs/themes/programmer.gif" width="260"/>
  <img src="docs/themes/soft.gif" width="260"/>
  <img src="docs/themes/club.gif" width="260"/>
</p>

---

## 🧱 Tech Stack

| Layer        | Technology |
|--------------|-----------|
| Backend      | Laravel 12, PHP 8.1+ |
| Database     | MySQL (SQLite / PostgreSQL supported) |
| Frontend     | Blade, Vite |
| Auth         | Laravel Authentication |
| State        | Database sessions, cache, queues |
| Tooling      | Composer, npm |

---

## 📦 Requirements

- PHP 8.1+
- Composer
- Node.js & npm
- MySQL / MariaDB / SQLite / PostgreSQL

---

## ⚙️ Installation

### 1️⃣ Clone the repository
```bash
git clone https://github.com/EngJoe20/study_tracker.git
cd study-tracker
````

### 2️⃣ Install backend dependencies

```bash
composer install
```

### 3️⃣ Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=study_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Run migrations & seeders

```bash
php artisan migrate --seed
```

### 5️⃣ Frontend setup (optional)

```bash
npm install
npm run dev    # Development
npm run build  # Production
```

---

## ▶️ Running the Application

```bash
php artisan serve
```

Access the application at:

👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧪 Testing

```bash
./vendor/bin/phpunit
```

or

```bash
composer test
```

---

## 🔧 Common Commands

```bash
php artisan migrate:fresh --seed
php artisan optimize:clear
php artisan key:generate
```

---

## 🧭 Project Vision

Study Tracker is designed to evolve into:

* 📱 Mobile-ready API backend
* 📊 Study analytics & insights
* 🤖 Smart study recommendations
* 🗂 Full student productivity suite

---

## 🤝 Contributing

Contributions are welcome 🙌
Please open issues or submit pull requests while following existing architecture and coding standards.

---

<p align="center">
  <strong>Built with ❤️ by Eng Joe</strong>
</p>



