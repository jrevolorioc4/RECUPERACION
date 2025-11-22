-- CREA LA BASE DE DATOS
CREATE DATABASE IF NOT EXISTS recuperacion
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE recuperacion;

-- TABLA ROLES
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO roles (nombre) VALUES
('recepcionista'),
('supervisor'),
('administrador');

-- TABLA USUARIOS (CON HASH SHA-256, NO TEXTO PLANO)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash CHAR(64) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
) ENGINE=InnoDB;

-- USUARIO ADMIN (username: admin  | contraseña: admin123)
INSERT INTO usuarios (username, password_hash, rol_id)
VALUES ('admin', SHA2('admin123', 256), 3);

-- TABLA MEMBRESIAS
CREATE TABLE membresias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre_cliente VARCHAR(100) NOT NULL,
    tipo ENUM('mensual','trimestral','anual') NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    estado ENUM('activa','vencida','suspendida','cancelada') NOT NULL DEFAULT 'activa',
    monto_pagado DECIMAL(10,2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- TABLA AUDITORÍA
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    membresia_id INT,
    usuario_id INT,
    accion VARCHAR(50),
    detalle TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (membresia_id) REFERENCES membresias(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

USE recuperacion;
INSERT INTO usuarios (username, password_hash, rol_id)
VALUES 
('super',  SHA2('super123',256), (SELECT id FROM roles WHERE nombre = 'supervisor')),
('recep',  SHA2('recep123',256), (SELECT id FROM roles WHERE nombre = 'recepcionista'));


SELECT *
FROM auditoria
