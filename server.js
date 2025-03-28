const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const QRCode = require('qrcode');
const path = require('path');
const fs = require('fs');

const app = express();
const port = 3000;

// MySQL Database Connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'package_db'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Database connected');
});

// Middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(express.static('public'));  // Serve static files like QR codes

// Create table if it doesn't exist
db.query(`
    CREATE TABLE IF NOT EXISTS packages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        receiver VARCHAR(255),
        phone_number VARCHAR(20),
        pickup_location VARCHAR(255),
        drop_station VARCHAR(255),
        qr_code_image_path VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
`);

// Route to handle package form submission
app.post('/submit-package', (req, res) => {
    const { receiver, phone_number, pickup_location, drop_station } = req.body;

    // Create QR Code
    const qrData = `Receiver: ${receiver}, Tel: ${phone_number}, Pickup: ${pickup_location}, Drop: ${drop_station}`;
    const qrCodeFileName = `qr${Date.now()}.png`; // Unique filename for each QR code
    const qrCodePath = path.join(__dirname, 'public/qr-codes', qrCodeFileName);

    QRCode.toFile(qrCodePath, qrData, (err) => {
        if (err) throw err;

        // Store the package information along with QR code path
        const query = 'INSERT INTO packages (receiver, phone_number, pickup_location, drop_station, qr_code_image_path) VALUES (?, ?, ?, ?, ?)';
        db.query(query, [receiver, phone_number, pickup_location, drop_station, `/qr-codes/${qrCodeFileName}`], (err, result) => {
            if (err) throw err;
            res.json({ message: 'Package added successfully', qrCodeImagePath: `/qr-codes/${qrCodeFileName}`, id: result.insertId });
        });
    });
});

// Route to get package and display QR code
app.get('/package/:id', (req, res) => {
    const packageId = req.params.id;

    // Retrieve package details
    db.query('SELECT * FROM packages WHERE id = ?', [packageId], (err, result) => {
        if (err) throw err;

        if (result.length > 0) {
            const package = result[0];
            res.json({ 
                receiver: package.receiver, 
                phone_number: package.phone_number, 
                pickup_location: package.pickup_location, 
                drop_station: package.drop_station,
                qr_code_image_path: package.qr_code_image_path 
            });
        } else {
            res.status(404).json({ message: 'Package not found' });
        }
    });
});

// Start server
app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
