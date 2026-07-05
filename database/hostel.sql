-- ============================================
-- SMART HOSTEL ALLOCATION AND MANAGEMENT SYSTEM
-- Database
-- ============================================

CREATE DATABASE IF NOT EXISTS if0_42340667_smart_hostel_db;

USE if0_42340667_smart_hostel_db;

-- ============================================
-- TABLE: ADMINISTRATORS
-- ============================================

CREATE TABLE administrators (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Super Admin','Admin') DEFAULT 'Admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLE: STUDENTS
-- ============================================

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    matric_number VARCHAR(30) UNIQUE NOT NULL,
    surname VARCHAR(50) NOT NULL,
    other_names VARCHAR(100) NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    department VARCHAR(100) NOT NULL,
    level VARCHAR(20) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    passport VARCHAR(255),
    status ENUM('Active','Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLE: HOSTELS
-- ============================================

CREATE TABLE hostels (
    hostel_id INT AUTO_INCREMENT PRIMARY KEY,
    hostel_name VARCHAR(100) NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    total_rooms INT NOT NULL,
    description TEXT,
    status ENUM('Active','Inactive') DEFAULT 'Active'
);

-- ============================================
-- TABLE: ROOMS
-- ============================================

CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    hostel_id INT NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    capacity INT NOT NULL,
    occupied INT DEFAULT 0,
    status ENUM('Available','Full') DEFAULT 'Available',
    FOREIGN KEY (hostel_id) REFERENCES hostels(hostel_id)
);

-- ============================================
-- TABLE: HOSTEL APPLICATIONS
-- ============================================

CREATE TABLE hostel_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    application_date DATE NOT NULL,
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    remarks TEXT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- ============================================
-- TABLE: HOSTEL ALLOCATIONS
-- ============================================

CREATE TABLE hostel_allocations (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    student_id INT NOT NULL,
    room_id INT NOT NULL,
    allocated_by INT NOT NULL,
    allocation_date DATE NOT NULL,
    FOREIGN KEY (application_id) REFERENCES hostel_applications(application_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id),
    FOREIGN KEY (allocated_by) REFERENCES administrators(admin_id)
);

-- ============================================
-- TABLE: NOTIFICATIONS
-- ============================================

CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    is_read ENUM('Yes','No') DEFAULT 'No',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- ============================================
-- TABLE: MAINTENANCE REQUESTS
-- ============================================

CREATE TABLE maintenance_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    room_id INT NOT NULL,
    issue TEXT NOT NULL,
    status ENUM('Pending','Resolved') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- ============================================
-- TABLE: ACTIVITY LOGS
-- ============================================

CREATE TABLE activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    activity TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES administrators(admin_id)
);