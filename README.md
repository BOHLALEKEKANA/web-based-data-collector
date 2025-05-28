# web-based data collector

How to Set Up and Use:

Google Sign-In Setup:

Create a project in the Google Developer Console (https://console.developers.google.com).
Enable the Google Sign-In API and generate a Client ID.
Replace YOUR_GOOGLE_CLIENT_ID in index.html with your Client ID.

Database Setup:

Run the SQL script (database.sql) in MySQL to create the checkout_db database and users table.
Update the database credentials in process.php (e.g., $username, $password).

Server Setup:

Host the files on a server with PHP and MySQL support (e.g., Apache with XAMPP).
Ensure the PHP PDO extension is enabled for MySQL.

Usage:

Users sign in with Google, which auto-fills name and email.
The purchase visual shows a sample subscription plan (R19.99/month).
Users enter phone, credit card, and address, which are validated client-side (JavaScript) and server-side (PHP).
Valid data is stored in the MySQL database.

Metrics Note:

The system is designed to achieve a 38% accuracy rate for validated fields and contribute to a 25% increase in sign-ups, as per your description. These are assumed outcomes based on effective validation and clear visuals.

Security Notes:

In production, encrypt sensitive data (e.g., credit card numbers) before storing.
Use HTTPS to secure data transmission.
Implement CSRF protection for the form.
Sanitize and validate all inputs to prevent SQL injection (handled here via PDO).