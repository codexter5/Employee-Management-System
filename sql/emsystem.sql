CREATE DATABASE IF NOT EXISTS emsystem;
USE emsystem;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (email, password)
VALUES ('admin@ems.com', '$2y$10$mZWkKGekpi8AqxkQY/d8h.jnXjtOZ7kNuaF.Sycu4AmDGnRyqUs4W');

CREATE TABLE employee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE,
    gender VARCHAR(10),
    faculty VARCHAR(100),
    salary VARCHAR(50),
    phone VARCHAR(20),
    address VARCHAR(200),
    status VARCHAR(20) DEFAULT 'Active',
    photo VARCHAR(255) DEFAULT NULL
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    att_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL,
    in_time TIME,
    out_time TIME
);

CREATE TABLE leaves_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    from_date DATE NOT NULL,
    to_date DATE NOT NULL,
    reason VARCHAR(250) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    admin_note VARCHAR(250)
);

INSERT INTO `employee` (`id`, `name`, `email`, `password`, `dob`, `gender`, `faculty`, `salary`, `phone`, `address`, `status`, `photo`) VALUES
(1,'Aarya Dhungana','aarya@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2002-05-25','Female','CSIT','28000','9800000001','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(2,'Aashraya Bhattarai','aashraya@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-10-12','Male','CSIT','22000','9800000002','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(3,'Adarsha Shrestha','adarsha@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-08-18','Male','CSIT','21000','9800000003','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(4,'Akash Khati','akash@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-11-20','Male','CSIT','20000','9800000004','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(5,'Akshyat Bhatt','akshyat@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-02-21','Male','CSIT','23000','9800000005','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(6,'Alex Maharjan','alex@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-02-07','Male','CSIT','26000','9800000006','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(7,'Aman Bhatta','aman@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-01-19','Male','CSIT','21000','9800000007','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(8,'Aman Tiwari','aman2@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-01-31','Male','CSIT','27000','9800000008','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(9,'Ankita Shrestha','ankita@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-08-06','Female','CSIT','25000','9800000009','Kathmandu','Inactive','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(10,'Barshika Shah','barshika@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-07-22','Female','CSIT','24000','9800000010','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(11,'Bishesh Shrestha','bishesh@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-02-27','Male','CSIT','22000','9800000011','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(12,'Biswash Shahi','biswash@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-03-17','Male','CSIT','21000','9800000012','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(13,'Chumalung Chamling','chumalung@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-10-22','Male','CSIT','26000','9800000013','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(14,'Deepika Khanal','deepika@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2003-09-11','Female','CSIT','28000','9800000014','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(15,'Dipsan Silwal','dipsan@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-10-11','Male','CSIT','24000','9800000015','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(16,'Grishma Shakya','grishma@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-06-05','Female','CSIT','25000','9800000016','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(17,'Jamuna Silwal','jamuna@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-05-10','Female','CSIT','23000','9800000017','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(18,'Keepa Maharjan','keepa@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-10-12','Female','CSIT','24000','9800000018','Kathmandu','Inactive','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(19,'Kiran Sah','kiran@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-04-15','Female','CSIT','22000','9800000019','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(20,'Milisha Sapkota','milisha@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-04-04','Female','CSIT','21000','9800000020','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(21,'Nikatta Shah','nikatta@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2006-03-21','Female','CSIT','30000','9800000021','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(22,'Nisha Dhungana','nisha@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-03-02','Female','CSIT','26000','9800000022','Kathmandu','Inactive','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(23,'Nitesh Khanal','nitesh@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-05-10','Male','CSIT','23000','9800000023','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(24,'Pragati Gurung','pragati@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-01-07','Female','CSIT','24000','9800000024','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(25,'Punyawati Bastakoti','punya@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2003-07-06','Female','CSIT','27000','9800000025','Kathmandu','Inactive','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(26,'Renusha Titaju','renusha@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-02-02','Female','CSIT','25000','9800000026','Kathmandu','Active','cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif'),
(27,'Ritsav Shrestha','ritsav@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-09-07','Male','CSIT','26000','9800000027','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(28,'Saksham Dhungana','saksham@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-07-21','Male','CSIT','24000','9800000028','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(29,'Saksham Pokhrel','saksham2@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-03-12','Male','CSIT','23000','9800000029','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(30,'Shuvam Thapa','shuvam@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-06-07','Male','CSIT','25000','9800000030','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(31,'Subin Timalsina','subin@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-06-23','Male','CSIT','26000','9800000031','Kathmandu','Inactive','smiling-business-cartoon-avatar-vector-58404732.avif'),
(32,'Subodh Timalsina','subodh@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2005-06-23','Male','CSIT','26000','9800000032','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif'),
(33,'Sujan Shrestha','sujan@gmail.com','$2y$10$etuoRzRpXxUOXbcbRZ2WL.PzolR7f8vyTpc3vnbHEA735DUAEii5O','2004-08-15','Male','CSIT','27000','9800000033','Kathmandu','Active','smiling-business-cartoon-avatar-vector-58404732.avif');
