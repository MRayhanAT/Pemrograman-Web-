show databases;

create database pilot;
use pilot;

CREATE TABLE pilots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    pesawat VARCHAR(50)
);

ALTER TABLE pilots ADD jam_terbang numeric(6);
select * from pilots;

SET SQL_SAFE_UPDATES = 0;


delete FROM pilots WHERE id >= 1000;

INSERT INTO pilots (name, pesawat, jam_terbang) 
VALUES ('John sith', 'Boeing 747', 740);

UPDATE pilots
SET id = 1004
WHERE id = 1;

SELECT * FROM pilots
ORDER BY jam_terbang DESC;

ALTER TABLE pilots AUTO_INCREMENT = 1000;