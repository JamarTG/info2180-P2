-- Create Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    password VARCHAR(100),
    email VARCHAR(100),
    role VARCHAR(50),
    created_at DATETIME
);

-- Create Contacts table
CREATE TABLE Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100),
    telephone VARCHAR(20),
    company VARCHAR(100),
    type VARCHAR(50),
    assigned_to INT,
    created_by INT,
    created_at DATETIME,
    updated_at DATETIME
);

-- Create Notes table
CREATE TABLE Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    comment TEXT,
    created_by INT,
    created_at DATETIME
);

-- Insert a user
INSERT INTO Users (firstname, lastname, password, email, role, created_at)
VALUES ('Admin', 'User', '$2y$10$OM5emM7Q8sn3jm42Tsg3i.4yHo4zaJiwLc3X5nIB8ViopajOsTyLy', 'admin@project2.com', 'Admin' , NOW());
