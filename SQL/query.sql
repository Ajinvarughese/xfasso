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
    otp INT,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

-- CART_USER TABLE

CREATE TABLE xfasso.cart_user
(
    SI_NO INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT,
    cart_product INT,
    quantity INT,
    size VARCHAR(4),
    FOREIGN KEY (user_id) REFERENCES xfasso.users(user_id),
    FOREIGN KEY (cart_product) REFERENCES xfasso.products(product_id)
);

-- PRODUCT_IMAGES TABLE

CREATE TABLE xfasso.product_images
(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    product_id INT PRIMARY KEY,
    img_front LONGBLOB,
    img_back LONGBLOB,
    img_right LONGBLOB,
    img_left LONGBLOB,
    product_desc VARCHAR(755),
    FOREIGN KEY(product_id) REFERENCES xfasso.products(product_id)
);


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


INSERT INTO xfasso.admin(id, admin_id, password, work, work_name)
VALUES(
    505,
    'jXwFHKBw4293',
    '$2y$10$4bRguT6htqysJpM7FxSBieja8mgmsKZKDZH6Qt22kRsBqcoapqoiS',
    4293,
    'comments'
);


INSERT INTO xfasso.admin(admin_id, password, work, work_name) 
VALUES 
(
    'OBw74GKw4294',
    '$2y$10$5FaievEUr40AKQ1a46Ny9.n8JgugTnRTP.MUiRjagaYhRY0dkIKS6',
    4294,
    'productAdd'
),
(
    'Ryzj66rw4295',
    '$2y$10$9lZJZyVC8vHd2969yYJ1f.n0wB3vLSLoFbcAnj2THa7O/RIzd2nqK',
    4295,
    'stock'
),
(
    'Vro6GwBw4296',
    '$2y$10$CdxltoxxhvgbgOwhXroM9eRClyKGNU1OpNBhiJdj7.Zg0avG9l3SK',
    4296,
    'blacklist'
),
(
    'P5PEbz1w4297',
    '$2y$10$eqhpRP3z/180h50cZ2Ud7ONppWK8LtHkRItCbpOHMNAvERtQE7yma',
    4297,
    'productEdit'
);


-- Show data from table
SELECT * FROM xfasso.admin;

