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

- User registration
- Form validation
- Session management
- CSRF protection
- Authentication flow
- Library management
- MySQL database integration
- Server-side rendered views
- Responsive interface with Bootstrap

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
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=app
MYSQL_USER=app
MYSQL_PASSWORD=app
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