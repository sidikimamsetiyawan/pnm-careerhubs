# Laravel Career Hubs
# PT. Permodalan Nasional Madani (PNM)

## Deskripsi Proyek

This repository contains the solution for the technical test provided by PT. Permodalan Nasional Madani (PNM). The test evaluates skills in SQL Server, RESTful API concepts, and implementation.

## Test Instructions and Solutions

### 1. Employee Data Report
The objective is to create an SQL query that generates a report including:
- **EMP_ID**: Employee ID
- **Employee Name**: Name of the employee
- **Position**: Current or last-held position
- **Work Unit**: Current or last-held unit
- **Unit ID**
- **Area ID**
- **Regional ID**
- **Start Date**: Date of joining
- **End Date**: Date of resignation
  
#### Solution:
You can find the SQL solution [here](https://onecompiler.com/sqlserver/433nz3nch).

### 2. Employee Statistics
Create SQL queries to calculate:
- The number of employees joining each year.
- The number of employees resigning each year.
- The number of employees with tenure exceeding one year.
- Active employee counts per:
  - Unit
  - Area
  - Region
- The number of Unit Heads who have previously served as Account Officers.

#### Solution:
You can find the SQL solution [here](https://onecompiler.com/sqlserver/433nz3nch).

### 3. RESTful API Implementation
#### Concept:
RESTful APIs are web service interfaces that adhere to the principles of Representational State Transfer (REST). They utilize HTTP methods (GET, POST, PUT, DELETE) for CRUD operations and are structured around resources.

#### Persyaratan
* PHP (versi sesuai dengan Laravel)
* Composer
* Node.js (untuk asset compilation, jika menggunakan frontend framework)

#### Instalasi
1. **Clone repository:**
   ```bash
   git clone [https://github.com/sidikimamsetiyawan/nm-careerhubs.git](https://github.com/sidikimamsetiyawan/nm-careerhubs.git)
   ```
2. **Install dependencies:**
   ```bash
   cd your-project
    npm install
   ```
4. **Generate key:**
   ```bash
   php artisan key:generate
   ```
6. **Database migration:**
   ```bash
   php artisan migrate
   ```
8. **Start development server:**
   ```bash
   npm run dev
   ```
#### Testing With Postman
You can access the Postman collection for testing the API endpoints here: [Postman Collection](https://orange-trinity-586014.postman.co/workspace/Laravel-11~da50da20-5de2-4989-8fd3-86387fc66dc0/collection/9072736-d9b051a5-e438-4e24-82c6-4e02b4c5adc6?action=share&creator=9072736).

#### API Documentation
The complete API documentation for this project is available online. You can access it at the link below:

[View API Documentation on Postman](https://documenter.getpostman.com/view/9072736/2sAYHxoQAE)

## Screenshots
### Screen Login

### Dashboard

### User Management

### Role Management

### Hobby Management

