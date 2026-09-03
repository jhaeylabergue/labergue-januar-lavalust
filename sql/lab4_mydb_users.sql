CREATE DATABASE IF NOT EXISTS mydb;
USE mydb;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    username VARCHAR(100) NOT NULL
);

INSERT INTO users (firstname, lastname, email, username)
VALUES
('Jhaey', 'Fernandez', 'jhaey@email.com', 'jhaeyfernandez'),
('Maria', 'Santos', 'maria@email.com', 'mariasantos'),
('Pedro', 'Garcia', 'pedro@email.com', 'pedrogarcia'),
('Ana', 'Reyes', 'ana@email.com', 'anareyes'),
('Jose', 'Mendoza', 'jose@email.com', 'josemendoza');

SELECT * FROM users;
