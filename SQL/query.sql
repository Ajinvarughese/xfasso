-- Database creation
DROP DATABASE IF EXISTS xfasso;
CREATE DATABASE xfasso;

-- USERS TABLE 
CREATE TABLE xfasso.users
(
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(75),
    email VARCHAR(255),
    password VARCHAR(275),
    gender VARCHAR(8),
    address LONGTEXT,
    reg_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

-- PRODUCTS TABLE
CREATE TABLE xfasso.products
(
    product_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(75),
    product_price INT,
    product_image LONGBLOB,
    product_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    product_gender VARCHAR(10) NOT NULL DEFAULT 'men',
    rating LONGTEXT,
    avg_star FLOAT,
    stock_status TINYINT(1) NOT NULL DEFAULT 0
);

-- ONE TIME PASSWORD (OTP) TABLE

CREATE TABLE xfasso.otp
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(255),
    otp INT,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

-- CART_USER TABLE

CREATE TABLE xfasso.cart_user
(
    SI_NO INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT,
    cart_product INT,
    FOREIGN KEY (user_id) REFERENCES xfasso.users(user_id),
    FOREIGN KEY (cart_product) REFERENCES xfasso.products(product_id)
);

-- Show data from table
SELECT * FROM xfasso.products;

