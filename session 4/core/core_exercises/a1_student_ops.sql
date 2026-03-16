-- Create the database with utf8mb4_unicode_ci collation
CREATE DATABASE IF NOT EXISTS student_management_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE student_management_db;

-- Create the classes table
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    department VARCHAR(100)
);

-- Create the students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_code VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    class_id INT,
    FOREIGN KEY (class_id) REFERENCES classes(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);