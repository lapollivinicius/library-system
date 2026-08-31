# Library System

A simple library management system built with PHP using a custom MVC architecture.

This project was developed to practice backend development with PHP and understand the fundamentals of MVC, routing, middleware, sessions, CSRF protection, form validation and MySQL.

The application uses a traditional server-rendered approach with Apache and a lightweight frontend using Bootstrap and jQuery.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

---

## About the Project

Library System is a multi-tenant library management application built to manage the complete book lending workflow.

Each library operates as an independent tenant, allowing its users to manage books, customers, and loan records within their own environment. The system provides functionality for registering and managing books and customers, controlling users, and tracking book loans and returns.

The project was developed using PHP with a custom MVC architecture, focusing on understanding backend fundamentals such as HTTP requests, routing, middleware, authentication, sessions, CSRF protection, server-side validation, and database integration.

## Features

### 📚 Core Functionalities
- **Multi-Tenant System:** Each library operates as an independent, isolated tenant.
- **Book Inventory:** Register, update, search, and track the status of books.
- **Customer Management:** Maintain records of library members and their history.
- **Loan Tracking:** Manage book check-outs, monitor returns, and track due dates.
- **User Access Control:** Manage staff access and permissions within each library environment.

### 🛡️ Security & Authentication
- **Secure Authentication Flow:** Robust user login and registration mechanisms.
- **CSRF Protection:** Built-in middleware to prevent Cross-Site Request Forgery attacks.
- **Session Management:** Secure handling and validation of user sessions.
- **Server-Side Validation:** Dedicated request validators to ensure data integrity and prevent malicious input.

### ⚙️ Technical Highlights
- **Custom MVC Architecture:** Clean separation of concerns built entirely from scratch.
- **Dynamic Routing:** Custom routing engine handling HTTP verbs, dynamic parameters, and middleware.
- **MySQL Integration:** Direct database interactions using PDO and custom data access models.
- **Server-Side Rendered Views:** HTML rendering using native PHP templating mechanisms.
- **Responsive Interface:** Front-end styled with Bootstrap and enhanced with jQuery for dynamic interactions.
- **Dockerized Environment:** Seamless local development setup using Docker and Docker Compose.

## Architecture

This project was built from the ground up without using large frameworks (like Laravel or Symfony) to provide a deep, hands-on understanding of backend concepts. The custom architecture is structured as follows:

- **`src/controllers/`**: The orchestrator. Intercepts incoming HTTP requests, coordinates with models and entities, and returns the appropriate view or redirect.
- **`src/models/`**: The data access layer. Responsible for direct database communication, executing queries, and data mapping.
- **`src/entities/`**: Domain objects representing the core business logic and data structures (e.g., `Book`, `Member`, `Loan`).
- **`src/views/`**: The presentation layer containing HTML/PHP templates. It is strictly separated into public pages and internal application dashboards.
- **`src/validators/`**: Dedicated classes that validate incoming form inputs and ensure data consistency before processing.
- **`src/config/`**: Holds core system configurations, database connection bootstrapping, routing definitions, and schema migrations.
- **`src/public/`**: The designated web root containing the front controller (`index.php`) and static assets (CSS, JS, images). All incoming traffic is routed here to ensure sensitive backend files remain inaccessible.

## Running the Project

### Requirements

- Docker
- Docker Compose

PHP, Apache and MySQL do not need to be installed locally.

#### Clone the repository

```sh
git clone https://github.com/lapollivinicius/library-system.git

cd library-system
```

#### Configure environment variables

```env
DB_ROOT_PASSWORD=root 
DB_DATABASE=database 
DB_USER=app 
DB_PASSWORD=app 
DB_PORT=3306
```

#### Start the containers

```sh
docker compose up -d --build
docker compose ps
```

#### Open the application

- http://localhost -> application
- http://localhost:8080 -> phpmyadmin

If the application is configured to use another port, use the port defined in docker-compose.yml.