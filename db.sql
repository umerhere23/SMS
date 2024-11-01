-- Create the database
CREATE DATABASE SchoolFeeManagementSystem;
USE SchoolFeeManagementSystem;

-- Table for classes
CREATE TABLE Classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    fee_amount DECIMAL(10, 2) DEFAULT 0.00, -- Base fee amount for each class
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for students
CREATE TABLE Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT,
    student_name VARCHAR(100) NOT NULL,
    contact_details VARCHAR(100),
    archived BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(class_id) ON DELETE SET NULL
);

-- Table for storing monthly fee records for each student
CREATE TABLE MonthlyFees (
    fee_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    month_year DATE, -- Format YYYY-MM-DD, only month and year are relevant
    amount_due DECIMAL(10, 2) DEFAULT 0.00,
    amount_paid DECIMAL(10, 2) DEFAULT 0.00,
    balance DECIMAL(10, 2) DEFAULT 0.00,
    status ENUM('Paid', 'Partially Paid', 'Unpaid') DEFAULT 'Unpaid',
    late_fee DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE,
    UNIQUE (student_id, month_year) -- Ensures only one record per student per month
);

-- Table for tracking payment history for each student
CREATE TABLE Payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    payment_date DATE,
    amount_paid DECIMAL(10, 2) NOT NULL,
    payment_mode ENUM('Cash', 'Bank Transfer', 'Credit Card', 'Check', 'Other') DEFAULT 'Cash',
    remaining_balance DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE
);

-- Views for analytics and reporting
-- View for monthly collection report by class
CREATE VIEW MonthlyCollectionReport AS
SELECT
    C.class_name,
    DATE_FORMAT(F.month_year, '%Y-%m') AS month,
    SUM(F.amount_paid) AS total_collected,
    SUM(F.balance) AS total_outstanding
FROM
    MonthlyFees F
JOIN
    Students S ON F.student_id = S.student_id
JOIN
    Classes C ON S.class_id = C.class_id
GROUP BY C.class_name, DATE_FORMAT(F.month_year, '%Y-%m');

-- View for outstanding fees report
CREATE VIEW OutstandingFeesReport AS
SELECT
    S.student_name,
    C.class_name,
    F.amount_due,
    F.amount_paid,
    F.balance,
    F.status
FROM
    MonthlyFees F
JOIN
    Students S ON F.student_id = S.student_id
JOIN
    Classes C ON S.class_id = C.class_id
WHERE
    F.status <> 'Paid';

-- Table for users and access control
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Accountant', 'Viewer') DEFAULT 'Viewer', -- Role-based access
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Backup log for tracking backups and restores
CREATE TABLE BackupLog (
    backup_id INT AUTO_INCREMENT PRIMARY KEY,
    backup_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    backup_status ENUM('Success', 'Failed') DEFAULT 'Success',
    restored BOOLEAN DEFAULT FALSE,
    restored_date TIMESTAMP NULL
);
