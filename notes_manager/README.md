# Notes Manager System (NMS)

## Description
NMS is a modern PHP web application for managing personal notes and categories.  
Users can create, edit, delete notes, organize them into categories, and view a visual dashboard with charts.

## Test Login
You may use this test account:

- Email: admin@gmail.com  
- Password: admin123  

Or register your own account using the Register page.

## How to run locally
1. Place the **notes_manager** folder inside your web server root (XAMPP htdocs).  
2. Start **Apache** and **MySQL** from XAMPP.  
3. Create a database named `notes_manager`.  
4. Import your SQL tables (users, notes, categories).  
5. Update database credentials in `db.php` if needed.  
6. Open this URL in your browser:  


## Files included
- index.php, register.php, logout.php  
- dashboard.php (with Chart.js graph)  
- notes-list.php, add-note.php, edit-note.php, delete-note.php  
- categories.php, add-category.php, edit-category.php, delete-category.php  
- db.php, auth.php, header.php, footer.php  
- assets/style.css  
- Chart.js link included in header

## Features
- User login using **email & password**
- Password hashing (bcrypt)
- Show/hide password toggle (eye icon)
- Add / edit / delete notes  
- Add / edit / delete categories  
- Dashboard with **Notes by Category** bar chart (Chart.js)
- Summary cards (Total Notes, Categories, Status)
- Responsive and modern UI using Bootstrap 5
- Pink–purple gradient login design
