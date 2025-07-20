-- Create the database
CREATE DATABASE IF NOT EXISTS event_management;
USE event_management;

-- Table for user roles
CREATE TABLE user_roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(255) NOT NULL UNIQUE
);

-- Table for users
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES user_roles(role_id)
);

-- Table for supplier types
CREATE TABLE supplier_types (
    supplier_type_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_type_name VARCHAR(255) NOT NULL UNIQUE
);

-- Table for suppliers
CREATE TABLE suppliers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(255) NOT NULL,
    supplier_type_id INT,
    user_id INT, -- Link to the user who is a supplier
    FOREIGN KEY (supplier_type_id) REFERENCES supplier_types(supplier_type_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Table for event types
CREATE TABLE event_types (
    event_type_id INT PRIMARY KEY AUTO_INCREMENT,
    event_type_name VARCHAR(255) NOT NULL UNIQUE
);

-- Table for event requests
CREATE TABLE event_requests (
    event_request_id INT PRIMARY KEY AUTO_INCREMENT,
    event_type_id INT,
    user_id INT, -- The user who requested the event
    event_date DATETIME NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (event_type_id) REFERENCES event_types(event_type_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Linking table for event requests and suppliers
CREATE TABLE event_request_suppliers (
    event_request_id INT,
    supplier_id INT,
    PRIMARY KEY (event_request_id, supplier_id),
    FOREIGN KEY (event_request_id) REFERENCES event_requests(event_request_id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
);

-- Insert sample data

-- Insert user roles
INSERT INTO user_roles (role_name) VALUES ('Event Planner'), ('Company Event Planner'), ('Supplier');

-- Insert users
INSERT INTO users (username, password, email, role_id) VALUES
('event_planner_1', 'pass123', 'ep1@example.com', 1),
('company_planner_1', 'pass123', 'cep1@example.com', 2),
('supplier_user_1', 'pass123', 'su1@example.com', 3),
('supplier_user_2', 'pass123', 'su2@example.com', 3);

-- Insert supplier types
INSERT INTO supplier_types (supplier_type_name) VALUES ('Catering'), ('Venue'), ('Entertainment');

-- Insert suppliers
INSERT INTO suppliers (supplier_name, supplier_type_id, user_id) VALUES
('Gourmet Catering', 1, 3),
('Grand Hall', 2, 4),
('Live Band Music', 3, 3);

-- Insert event types
INSERT INTO event_types (event_type_name) VALUES ('Wedding'), ('Corporate Conference'), ('Birthday Party');

-- Insert event requests
INSERT INTO event_requests (event_type_id, user_id, event_date) VALUES
(1, 1, '2024-09-15 18:00:00'),
(2, 2, '2024-10-20 09:00:00');

-- Link suppliers to event requests
INSERT INTO event_request_suppliers (event_request_id, supplier_id) VALUES
(1, 1), -- Wedding event with Gourmet Catering
(1, 2), -- Wedding event at Grand Hall
(2, 2), -- Corporate Conference at Grand Hall
(2, 3); -- Corporate Conference with Live Band Music
