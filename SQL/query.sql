-- Database creation
DROP DATABASE IF EXISTS xfasso;
CREATE DATABASE xfasso;

-- USERS TABLE 
CREATE TABLE xfasso.users
(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(255) PRIMARY KEY NOT NULL,
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
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    product_id INT PRIMARY KEY NOT NULL,
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
    otp VARCHAR(255),
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

-- CART_USER TABLE
CREATE TABLE xfasso.cart_user
(
    SI_NO INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(255),
    cart_product INT,
    quantity INT,
    size VARCHAR(4),
    FOREIGN KEY (user_id) REFERENCES xfasso.users(user_id),
    FOREIGN KEY (cart_product) REFERENCES xfasso.products(product_id)
);

-- PRODUCT_IMAGES TABLE
CREATE TABLE xfasso.product_images
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    product_id INT UNIQUE,
    img_front LONGBLOB,
    img_back LONGBLOB,
    img_right LONGBLOB,
    img_left LONGBLOB,
    product_desc VARCHAR(755),
    FOREIGN KEY(product_id) REFERENCES xfasso.products(product_id)
);

-- ADMIN TABLE
CREATE TABLE xfasso.admin
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    admin_id VARCHAR(45) UNIQUE,
    password VARCHAR(275),
    work INT DEFAULT NULL,
    reg_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    log_data LONGTEXT,
    work_name VARCHAR(75)
);

-- Insert initial data into the admin table
INSERT INTO xfasso.admin(id, admin_id, password, work, work_name)
VALUES(
    1205,
    'jXwFHKBw4293',
    '$2y$10$gIKum5xk2ThTw9n2s9kIKuH/DwLzLD90bKr6Baumf0jmTfV20sn3u',
    4293,
    'comments'
);

INSERT INTO xfasso.admin(admin_id, password, work, work_name) 
VALUES 
(
    'OBw74GKw4294',
    '$2y$10$g0Ys5LmxwJTdnQ545vozkOm02kH2IuVBDIHy/.zZfhQ4dfkM6Pwpm',
    4294,
    'productAdd'
),
(
    'Ryzj66rw4295',
    '$2y$10$zodeXBjEsOr2DQSy8Rwgnu7r1YxZdCiQDLC9RkdlwFVj8bwJ0UBZ6',
    4295,
    'stock'
),
(
    'Vro6GwBw4296',
    '$2y$10$nujHzHWFrdx49fsG/8ae0.ViRQgtAqtW7HLpanNC2K.W2W2BQ.9U1i',
    4296,
    'blacklist'
),
(
    'P5PEbz1w4297',
    '$2y$10$Yx6MY8ddpDid7XxH8./lCOZi1.YnzyIZ4W3YyaueP25yUJzy1BAla',
    4297,
    'productEdit'
),
(
    'QdfT8G7x4298',
    '$2y$10$Pcq/Ihh9cCK/zqYZ0SFVBu14qa4os5y/StayeHYRc6mo5qunNIjeC',
    4298,
    'orderManage'
);

-- PAYMENTS TABLE
CREATE TABLE xfasso.payments
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    payment_id VARCHAR(255) UNIQUE,
    user_id VARCHAR(255),
    products LONGTEXT,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    status INT,
    FOREIGN KEY(user_id) REFERENCES xfasso.users(user_id)
);

-- ORDERS TABLE
CREATE TABLE xfasso.orders
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(255),
    order_id VARCHAR(255) UNIQUE NOT NULL,
    payment_id VARCHAR(255),
    order_json LONGTEXT,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    order_status TINYINT(1) NOT NULL DEFAULT 0,
    delivery VARCHAR(75),
    FOREIGN KEY(user_id) REFERENCES xfasso.users(user_id),
    FOREIGN KEY(payment_id) REFERENCES xfasso.payments(payment_id)
);

-- Show data from admin table
SELECT * FROM xfasso.admin;
