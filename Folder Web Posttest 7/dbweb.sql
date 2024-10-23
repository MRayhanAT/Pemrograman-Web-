show databases;

create database pilot;
use pilot;

CREATE TABLE pilots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    pesawat VARCHAR(50)
);

delete from images where id > 0;

select * from images;

ALTER TABLE images DROP COLUMN description;

SET SQL_SAFE_UPDATES = 0;







INSERT INTO pilots (name, pesawat, jam_terbang) 
VALUES ('John sith', 'Boeing 747', 740);



CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    description TEXT
);


CREATE TABLE login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    umur INT NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_login VARCHAR(255) NOT NULL
);

select * from login;

ALTER TABLE login
CHANGE COLUMN password password_login VARCHAR(255) NOT NULL;