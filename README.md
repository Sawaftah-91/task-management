# Task Management API
========================

A RESTful API for a simple task management system using CodeIgniter 4 and JWT authentication.

## Table of Contents
-----------------

* [Introduction](#introduction)
* [Features](#features)
* [Installation](#installation)
* [Usage](#usage)
* [Endpoints](#endpoints)
* [Database Schema](#database-schema)
* [Security](#security)
* [License](#license)

## Introduction
---------------

This API allows users to create, read, update, and delete tasks. Each task has a title, description, status, and due date. JWT authentication is implemented to ensure secure access to the API.

## Features
------------

* User registration and login with JWT authentication
* Task creation, retrieval, update, and deletion
* Task fields: id, title, description, status, and due date
* Validation and sanitization of input data
* Proper error handling and response statuses
* Protected routes for authenticated users only

## Installation
------------

1. Clone the repository: `git clone https://github.com/Sawaftah-91/task-management.git`
2. Install dependencies: `composer install`
3. Create a new database and import the SQL file (`task-management.sql`) to create the schema
4. Configure the database settings in `app/Config/Database.php`
5. Run the application: `php spark serve`

## Usage
-----

1. Register a new user: `POST /auth/register`
2. Login and obtain a JWT: `POST /auth/login`
3. Create a new task: `POST /tasks` (authenticated users only)
4. Retrieve a list of all tasks: `GET /tasks` (authenticated users only)
5. Retrieve a specific task by ID: `GET /tasks/{id}` (authenticated users only)
6. Update a task by ID: `PUT /tasks/{id}` (authenticated users only)
7. Delete a task by ID: `DELETE /tasks/{id}` (authenticated users only)

## Endpoints
------------

* `POST /auth/register`: Register a new user
* `POST /auth/login`: Authenticate a user and return a JWT
* `POST /tasks`: Create a new task (authenticated users only)
* `GET /tasks`: Retrieve a list of all tasks (authenticated users only)
* `GET /tasks/{id}`: Retrieve a specific task by ID (authenticated users only)
* `PUT /tasks/{id}`: Update a task by ID (authenticated users only)
* `DELETE /tasks/{id}`: Delete a task by ID (authenticated users only)

## Database Schema
-----------------

The database schema is designed to store task data and user information. The schema consists of two tables: `tasks` and `users`.

## Security
------------

* JWT authentication is implemented to ensure secure access to the API
* Input data is validated and sanitized to prevent SQL injection and cross-site scripting (XSS) attacks
* Proper error handling and response statuses are implemented to prevent information disclosure

## License
---------

This project is licensed under the MIT License.

## Author
-------

[Sawaftah](https://github.com/Sawaftah-91)