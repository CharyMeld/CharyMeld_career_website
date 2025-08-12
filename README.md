TeamO Digital Solutions Website
A Staff Database Management System designed to help monitor and track staff attendance, daily work reports, progress, and challenges. The system supports different user roles including Admin, Supervisor, and Employee for effective management.

Features
Staff attendance tracking (sign-in/sign-out)

Daily work report submissions including progress and challenges

Role-based user management (Admin, Supervisor, Employee)

Secure login and access control

Responsive UI built with Bootstrap

MySQL database for data storage

Technologies Used
PHP

MySQL (via XAMPP)

HTML, CSS

Bootstrap

Installation Instructions
Install XAMPP: Download and install XAMPP from https://www.apachefriends.org/index.html

Clone this repository to your local machine:

bash
Copy
Edit
git clone https://github.com/CharyMeld/CharyMeld_career_website.git
Copy the project files to your XAMPP htdocs folder (e.g., /opt/lampp/htdocs or C:\xampp\htdocs)

Create a MySQL database:

Open phpMyAdmin via http://localhost/phpmyadmin

Create a new database (e.g., teamodigital)

Import the database schema:

Use the provided .sql file in the project (if available) or run migrations

Configure the database connection in your PHP config file (e.g., config.php) with your MySQL credentials

Start Apache and MySQL services via XAMPP control panel

Access the app at: http://localhost/myphpproject (adjust based on your folder name)

Usage
Login with your user credentials (default Admin login if available)

Admin can manage users and monitor reports

Supervisors and employees submit attendance and daily work reports

Contributing
Feel free to fork the project and submit pull requests for improvements or bug fixes.

License
This project is open-source and available under the MIT License.
