CREATE DATABASE restaurante;
USE restaurante;

CREATE TABLE banner (
id INT PRIMARY KEY AUTO_INCREMENT,
titulo VARCHAR(255) NOT NULL,
descripcion VARCHAR(255) NOT NULL,
link VARCHAR(255) NOT NULL
);

CREATE TABLE colaboradores (
id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL,
descripcion VARCHAR(255) NOT NULL,
facebook VARCHAR(255) NOT NULL,
instagram VARCHAR(255) NOT NULL,
youtube VARCHAR(255) NOT NULL,
foto VARCHAR(255) NOT NULL
);

CREATE TABLE mensaje (
id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL,
correo VARCHAR(255) NOT NULL,
mensaje VARCHAR(255) NOT NULL
);

CREATE TABLE plato (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    precio VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL
);

CREATE TABLE ingrediente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE plato_ingrediente (
    plato_id INT NOT NULL,
    ingrediente_id INT NOT NULL,
    PRIMARY KEY (plato_id, ingrediente_id),
    FOREIGN KEY (plato_id) REFERENCES plato(id) ON DELETE CASCADE,
    FOREIGN KEY (ingrediente_id) REFERENCES ingrediente(id) ON DELETE CASCADE
);


CREATE TABLE testimonios (
id INT PRIMARY KEY AUTO_INCREMENT,
opinion VARCHAR(255) NOT NULL,
nombre VARCHAR(255) NOT NULL
);

CREATE TABLE usuario (
id INT PRIMARY KEY AUTO_INCREMENT,
nombreUsuario VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
correo VARCHAR(255) NOT NULL
);

/*USUARIO*/
INSERT INTO usuario (nombreUsuario, password, correo) 
VALUES ('Laura123', '1234', 'laura@gmail.com');


/*INGREDIENTES*/

INSERT INTO ingrediente (nombre) VALUES ('Pollo');
INSERT INTO ingrediente (nombre) VALUES ('Carne de res');
INSERT INTO ingrediente (nombre) VALUES ('Pasta');
INSERT INTO ingrediente (nombre) VALUES ('Salsa de tomate');
INSERT INTO ingrediente (nombre) VALUES ('Lechuga');
INSERT INTO ingrediente (nombre) VALUES ('Tomate');
INSERT INTO ingrediente (nombre) VALUES ('Cebolla');
INSERT INTO ingrediente (nombre) VALUES ('Queso');
INSERT INTO ingrediente (nombre) VALUES ('Aceitunas');
INSERT INTO ingrediente (nombre) VALUES ('Champiñones');
INSERT INTO ingrediente (nombre) VALUES ('Pimiento rojo');
INSERT INTO ingrediente (nombre) VALUES ('Pimiento verde');
INSERT INTO ingrediente (nombre) VALUES ('Aguacate');
INSERT INTO ingrediente (nombre) VALUES ('Maíz');
INSERT INTO ingrediente (nombre) VALUES ('Arroz');
INSERT INTO ingrediente (nombre) VALUES ('Frijoles');
INSERT INTO ingrediente (nombre) VALUES ('Pescado');
INSERT INTO ingrediente (nombre) VALUES ('Mariscos');
INSERT INTO ingrediente (nombre) VALUES ('Mazorca');
INSERT INTO ingrediente (nombre) VALUES ('Papa criolla');
INSERT INTO ingrediente (nombre) VALUES ('Papa pastusa');
INSERT INTO ingrediente (nombre) VALUES ('Papa francesa');
INSERT INTO ingrediente (nombre) VALUES ('Yuca');
INSERT INTO ingrediente (nombre) VALUES ('Plátano maduro');
INSERT INTO ingrediente (nombre) VALUES ('Plátano verde');
INSERT INTO ingrediente (nombre) VALUES ('Raices chinas');
INSERT INTO ingrediente (nombre) VALUES ('Guascas');
INSERT INTO ingrediente (nombre) VALUES ('Raices chinas');
INSERT INTO ingrediente (nombre) VALUES ('Chicharron');

