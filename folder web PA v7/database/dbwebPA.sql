use rankride;

CREATE TABLE mobil (
    id_mobil INT PRIMARY KEY auto_increment,
    foto_mobil VARCHAR(255),
    nama_mobil VARCHAR(100),
    rata_rata_rating DECIMAL(3, 2),
    deskripsi varchar(255)
);

drop table mobil;
drop table rating_mobil;

CREATE TABLE rating_mobil (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_mobil INT,
    rating DECIMAL(2, 1),
    FOREIGN KEY (id_mobil) REFERENCES mobil(id_mobil)
);