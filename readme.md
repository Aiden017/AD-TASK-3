<a name="readme-top"></a>

<div align="center">
  <h3 align="center">AD-TASK-3</h3>
</div>

<div align="center">
  Part 1
</div>

![](https://visit-counter.vercel.app/counter.png?page=aiden017/AD-TASK-3)

[![wakatime](https://wakatime.com/badge/user/144d2c3f-82f0-440d-89df-023ce97ebda9/project/58db26d2-ae72-4b5f-bbc6-fcf7e2e3e440.svg)](https://wakatime.com/badge/user/144d2c3f-82f0-440d-89df-023ce97ebda9/project/58db26d2-ae72-4b5f-bbc6-fcf7e2e3e440)

---

## 📑 Table of Contents

- [Overview](#overview)
  - [Key Components](#key-components)
  - [Technology](#technology)
- [Rules, Practices and Principles](#rules-practices-and-principles)
- [Resources](#resources)

---

## 📘 Overview

This project is a web application built with PHP for user and task management. It features authentication, user roles, PostgreSQL and MongoDB support, Docker integration, and reusable component-based structure.

### 🧩 Key Components

- User Authentication (Login/Logout)
- PostgreSQL + MongoDB integration
- Component-based UI (`.component.php`)
- Utility functions and database seeders
- Static data insertion for dummy users

### 🧪 Technology

#### Language  
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

#### Framework/Library  
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

#### Databases  
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white)  
![MongoDB](https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white)

---

## 🧱 Rules, Practices and Principles

1. Always use `AD-` in the project name.
2. Do not rename `.php` files in `pages/`; always use `index.php`.
3. Components use `.component.php`; e.g., `loginForm.component.php`
4. Utility scripts use `.util.php`; e.g., `envSetter.util.php`
5. Place files in their respective folders.
6. Naming Cases:
   | Naming Case | Type of Code         | Example                           |
   |-------------|----------------------|-----------------------------------|
   | Pascal      | Utility              | EnvSetter.util.php                |
   | Camel       | Pages/Components     | loginForm.component.php, index.php|

7. Page folder names should reflect function (e.g., `Login`, `Logout`)
8. Git commits use proper labels: `feat`, `fix`, `refactor`, `docs`
9. Follow the file structure shown below:

---

## 📁 File Structure
AD-TASK-3
├── assets/
├── components/
│ ├── componentGroup/
│ └── templates/
│ ├── example.component.php
│ └── loginForm.component.php
├── database/
│ ├── users.model.sql
│ ├── projects.model.sql
│ ├── tasks.model.sql
│ ├── project_users.model.sql
│ └── other .sql files
├── docs/
├── errors/
│ ├── errorName.error.php
│ └── unauthorized.error.php
├── handlers/
│ ├── auth.handler.php
│ ├── mongodbChecker.handler.php
│ └── postgreChecker.handler.php
├── layouts/
├── pages/
│ ├── Login/
│ │ └── index.php
│ ├── Logout/
│ │ └── index.php
│ └── index.php
├── sql/
│ ├── Old Table Auto Increment.sql
│ ├── New Table Auto Increment Script.sql
│ └── other .sql files
├── src/
├── staticDatas/
│ └── Dummies/
│ └── users.staticData.php
├── utils/
│ ├── auth.util.php
│ ├── dbMigratePostgresql.util.php
│ ├── dbResetPostgresql.util.php
│ ├── dbSeederPostgresql.util.php
│ ├── envSetter.util.php
│ └── htmlEscape.util.php
├── .env
├── .gitignore
├── bootstrap.php
├── compose.yaml
├── composer.json
├── composer.lock
├── Dockerfile
├── index.php
├── README.Docker.md
├── readme.md
└── router.php



---

## 📚 Resources

- [PHP Manual](https://www.php.net/manual/en/)
- [PostgreSQL Docs](https://www.postgresql.org/docs/)
- [MongoDB Manual](https://www.mongodb.com/docs/)
- [Bootstrap Docs](https://getbootstrap.com/docs/5.0/getting-started/introduction/)

