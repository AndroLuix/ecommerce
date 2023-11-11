
CREATE SCHEMA ecommerce;
USE ecommerce;

/*------------------------
    USER: 
    1. DATA USER
    2. SELLER OPTION
    3. TOKEN 
    4. ACTIVITY LOG
 ------------------------*/


CREATE TABLE user
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    birthdate DATE NULL,
    email VARCHAR(30) UNIQUE NOT NULL,
    tel INT NULL,
    password VARCHAR NOT NULL,
    role ENUM('customer','seller') DEFAULT 'customer' NOT NULL -- user role
);

CREATE TABLE seller(
    user_id INT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);
CREATE TABLE user_tokens
(
    id               INT AUTO_INCREMENT PRIMARY KEY,
    token            VARCHAR(255) NOT NULL,
    expiry           DATETIME NOT NULL,
    user_id          INT      NOT NULL,
    CONSTRAINT fk_user_id
        FOREIGN KEY (user_id)
            REFERENCES user (id) ON DELETE CASCADE
);
CREATE TABLE activity_log
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    activity_description VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
);


/*------------------------------
        PRODUCTS AND CATEGORY
        1. PRODUCT DATA
        2 CATEGORY
        3. PRODUCT REVIEW
 ------------------------------*/

CREATE TABLE product
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL, -- reference : seller table
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    -- brand VARCHAR (50) NOT NULL, -- i take it from the seller table
    category_id INT, -- REFERENCE CATEGORY
    image_filename VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES category(id)
        ON DELETE SET NULL,
   -- if you delete a category, it's set null
   FOREIGN KEY (seller_id) references seller(user_id) ON DELETE CASCADE

);

CREATE TABLE category
(
    id INT AUTO_INCREMENT PRIMARY KEY ,
    name_category VARCHAR(20) NULL
);
CREATE TABLE product_review(
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_product INT NOT NULL,
  id_user INT NOT NULL,
  rating INT NOT NULL,
  review_text VARCHAR(255) NULL,
  FOREIGN KEY (id_product) REFERENCES product(id),
  FOREIGN KEY (id_user) REFERENCES user(id)
);



/*------------------------
    ORDERS AND SHOPPPING
    1. ORDER DATA
    2. DETAILS ORDER
    3. SHIPPING ADRESS
    4. TRANSITION DATA
 ------------------------*/

CREATE TABLE order
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE order_details(
    id INT AUTO_INCREMENT PRIMARY KEY ,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES order(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) references product(id) ON DELETE CASCADE,

);


CREATE TABLE shipping_adress
(
    id INT AUTO_INCREMENT PRIMARY KEY ,
    user_id INT NOT NULL,
    adress_line1 VARCHAR(100),
    adress_line2 VARCHAR(100),
    state VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL, -- The length of the zip code is different for each state
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);
CREATE TABLE transition
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_id INT NOT NULL,
    transaction_data DATETIME NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    amount DECIMAL (10,2) NOT NULL,
    FOREIGN KEY (user_id) references user(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES order(id) ON DELETE CASCADE
);


/*---------------------------------
        COUPON
        1. COUPIN DATA
        2. COUPON FOR CATEGORY
 ---------------------------------*/

CREATE TABLE coupon(
   id int AUTO_INCREMENT PRIMARY KEY ,
   code VARCHAR(15) UNIQUE NOT NULL,
   discount_amount DECIMAL(5,2) NOT NULL
);

CREATE TABLE coupon_category(
    coupon_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (coupon_id, category_id),
    FOREIGN KEY (category_id) REFERENCES coupon(id) ON DELETE CASCADE ,
    FOREIGN KEY (coupon_id) REFERENCES  category(id) ON DELETE CASCADE
);

 /*------------------------------

        PROCEDURE AND TRIGGER 
   
  -------------------------------*/


 /*------------------------------

        EXCEPTION 
   
  -------------------------------*/

DELIMITER //

CREATE PROCEDURE insert_user(IN name VARCHAR(30), IN lastname VARCHAR(30), IN email VARCHAR(30), IN password VARCHAR(255))
BEGIN
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Gestione dell'errore
            ROLLBACK;
            SELECT 'Error entering user';
        END;

    START TRANSACTION;

    -- Inserisci l'utente e la password
    INSERT INTO user(name, lastname, email, password) VALUES (name, lastname, email, SHA2(password, 256));

    COMMIT;
    SELECT 'Entering user success';
END //
 /*------------------------------

   UPDATE/DELETE NAME CATEGORY

  -------------------------------*/
CREATE TRIGGER after_update_category
    AFTER UPDATE
    ON category FOR EACH ROW
BEGIN
    UPDATE product
    SET name_category = NEW.name_category
    WHERE category_id = NEW.id;
END;
//
CREATE TRIGGER before_insert_product
    BEFORE INSERT
    ON product FOR EACH ROW
BEGIN
    SET NEW.name_category = (SELECT name_category FROM category WHERE id = NEW.category_id);
END;
//

CREATE TRIGGER before_update_product
    BEFORE UPDATE
    ON product FOR EACH ROW
BEGIN
    SET NEW.name_category = (SELECT name_category FROM category WHERE id = NEW.category_id);
END;
//

DELIMITER ;