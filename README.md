# LARAVEL VUE JS SECOND-ROUND INTERVIEW CODE CHALLENGE

This project is a comprehensive implementation of a library management system using Laravel for the backend and Vue.js for the frontend. The system facilitates CRUD operations on users, books, and book loans, ensuring authentication for secure access.
## In This ReadMe

1. [Project Structure](#project-structure)
    - [Backend (Laravel)](#backend-laravel)
    - [Frontend (Vue.js)](#frontend-vuejs)
2. [Key Functionality](#key-functionality)
    - [Admin Dashboard](#admin-dashboard)
    - [User Access](#user-access)
3. [Additional Features](#additional-features)
4. [Running the Project Locally](#running-the-project-locally)
    - [Prerequisites](#prerequisites)
    - [Installation Steps](#installation-steps)
    - [Accessing the Application](#accessing-the-application)
    - [Additional Notes](#additional-notes)

## Project Structure

### Backend (Laravel)

- Implemented RESTful APIs to manage users, books, and book loans.
- Ensured secure authentication mechanisms for API access.
- Utilized MySQL database for persistent data storage.
- Normalized database schema to meet extended requirements.

### Frontend (Vue.js)

- Developed a user-friendly interface to consume the provided APIs.
- Enabled admins to register users, add books, and manage book loans efficiently.
- Facilitated book borrowing, loan extension, and book return processes for users.

## Key Functionality

### Admin Dashboard

- Register users and manage their access.
- Add, update, and delete books from the library.
- Monitor and manage book loans.

### User Access

- Borrow available books from the library.
- Request loan extensions if unable to return books on time.
- Return borrowed books through the system.

## Additional Features

- Implemented reusable code patterns for scalability.
- Ensured a clean and responsive frontend design.
- Employed quality front-end components like reports and graphs for better visualization and user interaction.
- Leveraged normalized database schemas for extended system capabilities and flexibility.

## Running the Project Locally

### Prerequisites

Before you start, make sure you have the following installed on your system:

- [Composer](https://getcomposer.org/)
- [Node.js and npm](https://nodejs.org/)
- [MySQL](https://www.mysql.com/) or another database of your choice
- [Git](https://git-scm.com/) (optional, for cloning the repository)

### Installation Steps

1. **Clone the Repository**

    ```bash
    git clone https://github.com/your-username/your-repo.git
    cd your-repo
    ```

    _(If you don't have Git, download the repository ZIP and extract it.)_

2. **Backend Setup**

    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

    Update `.env` file with your database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

    Run migrations:

    ```bash
    php artisan migrate --seed
    ```

3. **Frontend Setup**

    ```bash
    npm install
    ```

4. **Run the Application**

    Start the Laravel server:

    ```bash
    php artisan serve
    ```

    Start the Vue.js development server:

    ```bash
    npm run dev
    ```

5. **Access the Application**

    Open your browser and go to `http://localhost:8000` to view the application.
				
				Login with the following credentials:
				- Email: admin@justbooks.com
				- Password: Seol11@3

### Additional Notes

- Ensure you keep your database credentials secure.
- Make sure ports `8000` (for Laravel) and `8080` (for Vue.js) are available.
- For production, configure a proper web server like Apache or Nginx.
