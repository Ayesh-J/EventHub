📄 Project Documentation: EventHub – College Event Management System
🧑‍💻 Developed By:
Ayesh Jamadar
Course: Second-Year BCA
College: Goa Multi-Faculty College – Dharbandora

📘 Project Overview:
EventHub is a PHP-based w
interface for students to view, register, and manage their event participations, while allowing admins to create, update, and manage event details.

🧩 Tech Stack Used:
Frontend: HTML, CSS, JavaScript (No frameworks used)

Backend: PHP

Database: MySQL (via MySQL Workbench)

Server Environment: XAMPP (Apache & MySQL)

🗂 File Structure Overview:
pgsql
Copy
Edit
EventHub/
├── assets/
│   ├── css/
│   ├── js/
│   └── certificates/
├── config/
│   └── db.php
├── actions/
│   ├── login.php
│   ├── register_event.php
│   └── cancel_registration.php
├── admin/
│   └── dashboard.php
├── users/
│   └── dashboard.php
├── auth/
│   ├── login.php
│   └── register.php
├── index.php
└── README.md
🔐 Modules and Functionalities:
🧑‍🎓 Student Side:
Secure login and registration

View all available events

Register for events (with team name, college name, members)

Cancel event registrations

View registered events

🛠 Admin Side:
Admin login

Create, edit, delete events

View all event registrations

Delete unwanted registrations

🧾 Database Schema:
users
id (INT, PK)

name, email, password, role (student/admin)

events
id, title, event_date, time, venue, organizer

event_registrations
id, user_id, event_id, college_name, team_name, participant_name, member_names

feedback
id, user_id, event_id, feedback_text, submitted_at

✅ Completed Features:
🔐 User authentication

📅 Event creation and management

📥 Event registration and cancellation

🧾 Admin dashboard

🎨 Responsive UI with consistent theme

🧪 Testing and Debugging:
Tested all modules using live localhost (XAMPP)

Ensured proper validation and redirection

Fixed errors related to certificate generation (scrapped as per decision)

❌ Dropped Features:
Automatic certificate generation (Due to complexity in image rendering on server)

🏁 Conclusion:
EventHub successfully meets the objective of managing events within a college setup. It provides a complete flow from event listing to user registration, with robust admin control. 
Developed single-handedly, this project reflects strong understanding of full-stack development and database integration.
