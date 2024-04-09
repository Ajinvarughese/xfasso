-- Database creation
DROP DATABASE IF EXISTS xfasso;
CREATE DATABASE xfasso;



-- USER TABLE 

CREATE TABLE xfasso.users
(
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(75),
    email VARCHAR(255),
    password VARCHAR(275),
    gender VARCHAR(8),
    address LONGTEXT,
    reg_time DATETIME NOT NULL DEFAULT current_timestamp()
);

-- CART_USER TABLE


-- ONE TIME PASSWORD (OTP) TABLE

SELECT * FROM xfasso.users


   