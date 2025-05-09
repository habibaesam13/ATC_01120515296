
# Event Booking System

## Overview

This is a Laravel-based event booking system where users can view, book, and manage event tickets. The application provides an admin panel for event management, along with API endpoints for managing events, user authentication, and role-based permissions. The project uses Laravel 11, middleware for authentication and role-checking, and service layers to separate business logic.

## Features

### User Features

* **Authentication:** Users can register and log in using Laravel’s built-in authentication system.
* **Event Listings:** Users can view events displayed using a responsive grid or flexbox layout. Events already booked by the user display a "Booked" label.
* **Event Details:** Users can view full details of an event, including:

  * Event Name, Description, Category, Date, Venue, Price, and Image
  * Book a ticket (1 ticket per click)
  * After booking, users are redirected to a Congratulations page.
* **Booking Management:**

  * Users can book more than one ticket for an event.
  * Users can unbook a ticket or cancel all their booked tickets.

### Admin Features

* **Event Management:**

  * Admin can **Create**, **Read**, **Update**, and **Delete** events.
  * Admin can manage event categories and images.
  * Admin can create tickets for events.
* **Role-Based Access Control:**

  * Admin has full access to all entities (events, users, categories).
  * User can only view and book events.

### API Features

* **Event Management API:**

  * Admin can create, update, and delete events via the API.
  * Public API route to view event details.
* **Authentication API:**

  * Users can register, log in, and log out via API routes with token-based authentication (Sanctum).
* **Role-Based Access Control API:**

  * Admin role required for event creation and management.
  * User role allows access to event booking and ticket management.

### Additional Features

* **Event Categories:** Admin can create, update, or delete categories for events. Categories are seeded into the database for easy management.
* **User Dashboard:** User can view his info and booked events details , he also able to unbooked event.
* **Ticket Management:**

  * Admin can assign tickets to events.
  * Users can book multiple tickets, each tied to their profile.
* **Service Layer:** A service layer is used to handle business logic for events and ticket bookings, promoting separation of concerns and reusability.
* **Enums:** Roles are managed through an enum class for better readability and maintenance.
* **Pagination & Lazy Loading:** Events and tickets are paginated or lazily loaded to enhance performance.
* **Responsive Design:** The UI is built using Bootstrap to ensure a responsive layout, optimized for desktop views.

## Requirements

* **Laravel 11** or higher
* PHP 8.x
* Composer
* MySQL or another compatible database

## Installation

Follow these steps to install and set up the project:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/habibaesam13/ATC_01120515296.git
   ```

2. **Install dependencies:**

   ```bash
   cd ATC_01120515296
   composer install
   ```

3. **Set up the .env file:**
   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   Update your database credentials in the `.env` file.

4. **Generate the application key:**

   ```bash
   php artisan key:generate
   ```

5. **Run migrations:**

   ```bash
   php artisan migrate
   ```

6. **Seed the database (including categories):**

   ```bash
   php artisan db:seed
   ```

7. **Start the development server:**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

## API Routes

### Authentication Routes

* **POST /register:** Register a new user.
* **POST /login:** Log in an existing user and get an authentication token.
* **POST /logout:** Log out the user (requires authentication).

### Event Management (Admin Only)

* **GET /admin/events/create:** Show form to create a new event.
* **POST /admin/events/save:** Save a new event.
* **GET /admin/events/edit/{id}:** Show form to edit an existing event.
* **POST /admin/events/update/{id}:** Update an existing event.
* **DELETE /admin/events/delete/{id}:** Delete an event.

### Public Routes

* **GET /events/show/{id}:** Show event details (available to both Admin and Users).

### Role-Based Middleware

* **Admin Routes:** Protected by role middleware to ensure only admins have access to event creation and management.
* **User Routes:** Protected by role middleware to ensure only authenticated users can book/unbook tickets.

## Technologies Used

* **Backend:** Laravel 11
* **Frontend:** HTML, CSS, Bootstrap (for responsive UI)
* **Database:** MySQL (or any compatible database)
* **Authentication:** Laravel Sanctum
* **Middleware:** Role-based access control middleware
* **Service Layer:** Business logic separation using services
* **Enums:** Enum class for user roles and event status

## UI Design

The UI is designed for web browsers only (no mobile support). The application is fully responsive and optimized for desktop use. No design files were provided, allowing flexibility for custom UI development.


