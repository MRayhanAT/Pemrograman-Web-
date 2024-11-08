CREATE TABLE mobil (
    id_mobil INT PRIMARY KEY auto_increment,
    foto_mobil VARCHAR(255),
    nama_mobil VARCHAR(100),
    rata_rata_rating DECIMAL(3, 2),
    deskripsi varchar(255)
);

CREATE TABLE komentar_mobil (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_mobil INT,
    id_akun int,
    rating DECIMAL(2, 1),
    komentar varchar(255),
    FOREIGN KEY (id_mobil) REFERENCES mobil(id_mobil),
    FOREIGN KEY (id_akun) REFERENCES akun(id_akun)
);


CREATE TABLE `akun` (
   `id_akun` int NOT NULL AUTO_INCREMENT,
   `nama_akun` varchar(100) DEFAULT NULL,
   `email` varchar(255) DEFAULT NULL,
   `password` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`id_akun`)
 );
 
CREATE TABLE `admin_mobil` (
   `id_admin` int NOT NULL AUTO_INCREMENT,
   `nama_admin` varchar(100) DEFAULT NULL,
   `email` varchar(255) DEFAULT NULL,
   `password` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`id_admin`)
 );
