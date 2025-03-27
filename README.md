# 🚆 Kandy Railway Delivery & Storage Management System

## 📌 Overview
The **Kandy Railway Delivery & Storage Management System** is a web-based application designed to streamline and manage parcel storage and delivery at the Kandy railway station. The system enables efficient handling of **customer parcels** and **government stocks** (such as oil, mail, fuel, and fertilizer) while integrating with the post department for seamless parcel delivery. The platform ensures accurate stock management, pricing calculations, and SMS notifications for parcel arrivals.

## 🎯 Features & Functionality
### 📦 Parcel Management
- Store and manage **customer parcels** and **government stocks**.
- Track parcels from collection to delivery.
- Integrate with the **post department** for seamless dispatching.

### 📊 Stock Tracking
- Keep real-time stock levels for **oil, mail, compost, fuel, fertilizer, and parcels**.
- Update stock records as parcels move in and out.
- Generate reports on storage usage.

### 💰 Price Calculation
- Calculate parcel storage prices based on weight and duration.
- Automatic pricing for different types of parcels.

### 📩 SMS Notifications
- Send **automated SMS alerts** to recipients when their parcels arrive.
- Notify senders and receivers about parcel status updates.

### 👨‍💼 Role-Based Access
- **Station Master:** Manage all operations and monitor reports.
- **Admin:** Control system settings and user management.
- **Parcel Collection Officer:** Enter new parcel details and confirm deliveries.
- **Storage Manager:** Oversee stock levels and warehouse operations.

## 🛠️ Technologies Used
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** Microsoft SQL Server
- **Authentication & Security:** PHP sessions, SQL user management
- **Communication:** SMS API for parcel notifications

## 🚀 Installation Guide
### 🔹 Prerequisites
Before setting up the system, ensure you have:
- **XAMPP** or **WAMP** installed for PHP and MySQL.
- **Microsoft SQL Server** for the database.
- **Git** (if cloning the repository).

### 🔹 Steps to Install
1. **Clone the repository**:
   ```bash
   git clone https://github.com/Sandeep992299/Railway_diliver_and_stock_management_system.git
   ```
2. **Move to the project directory**:
   ```bash
   cd Railway_diliver_and_stock_management_system
   ```
3. **Import the database**:
   - Open **Microsoft SQL Server Management Studio (SSMS)**.
   - Create a new database named `railway_storage`.
   - Import the provided SQL dump file (`database.sql`).

4. **Configure the database connection**:
   - Navigate to the `config.php` file.
   - Update database credentials:
     ```php
     $servername = "your_server";
     $username = "your_username";
     $password = "your_password";
     $dbname = "railway_storage";
     ```

5. **Start the local server**:
   - If using XAMPP, start **Apache** and **MySQL**.
   - If using WAMP, start the server.

6. **Run the application**:
   - Open a browser and go to `http://localhost/Railway_diliver_and_stock_management_system/`

## 📡 Connecting SMS Notification System
1. Sign up for an **SMS API provider** (e.g., Twilio, Nexmo, or a local SMS gateway).
2. Obtain your **API key and credentials**.
3. Configure the **SMS API settings** in `sms_config.php`:
   ```php
   $sms_api_key = "your_api_key";
   $sms_sender_id = "your_sender_id";
   ```
4. Ensure the SMS service is active before testing notifications.

## 🤝 Contribution
Want to improve this project? Follow these steps:
1. **Fork the repository**.
2. **Create a new branch** for your feature:
   ```bash
   git checkout -b feature-name
   ```
3. **Commit your changes**:
   ```bash
   git commit -m "Add new feature"
   ```
4. **Push your branch**:
   ```bash
   git push origin feature-name
   ```
5. **Open a pull request** on GitHub.

## 📜 License
This project is licensed under the **MIT License**.

## 📧 Contact
For any questions or issues, feel free to reach out:
- **GitHub Issues**: [Open an Issue](https://github.com/Sandeep992299/Railway_diliver_and_stock_management_system/issues)
- **Email**: dissanayakesandeep@gmail.com

---
🚆 **Efficient Railway Parcel & Stock Management at Your Fingertips!** 📦
