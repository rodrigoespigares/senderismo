DROP DATABASE IF EXISTS senderismo;
CREATE DATABASE senderismo;
USE senderismo;

SET NAMES utf8mb4;
-- Creamos las tablas
-- Crear la tabla rutas
DROP TABLE IF EXISTS rutas;
CREATE TABLE rutas (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT(11) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descripcion BLOB,
    desnivel INT(6) UNSIGNED,
    distancia DOUBLE,
    notas BLOB,
    dificultad VARCHAR(20)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Crear la tabla rutas_comentarios
DROP TABLE IF EXISTS rutas_comentarios;
CREATE TABLE rutas_comentarios (
    id SMALLINT(6) NOT NULL AUTO_INCREMENT,
    id_ruta INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    nombre VARCHAR(50),
    texto BLOB,
    fecha DATE,
    PRIMARY KEY (id, id_ruta)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
id INT(11) NOT NULL AUTO_INCREMENT ,
usuario VARCHAR(50) UNIQUE,
contrasena VARCHAR(255),
nombre VARCHAR(50),
apellidos VARCHAR(100),
email VARCHAR(100) UNIQUE,
fecha_nacimiento DATE,
movil VARCHAR(15),
rol VARCHAR(5),
ultimo_Commit VARCHAR(50) DEFAULT NULL,
PRIMARY KEY (id,email,usuario)
) ENGINE = INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Creamos las claves foráneas con ON DELETE CASCADE
ALTER TABLE rutas_comentarios
ADD CONSTRAINT fk_rutas_comentarios_rutas
FOREIGN KEY (id_ruta)
REFERENCES rutas(id)
ON DELETE CASCADE;

ALTER TABLE rutas_comentarios
ADD CONSTRAINT fk_rutas_comentarios_usuario
FOREIGN KEY (id_usuario)
REFERENCES usuarios(id)
ON DELETE CASCADE;

-- Creamos la clave foránea
ALTER TABLE rutas_comentarios
ADD CONSTRAINT fk_rutas_comentarios_usuario_nombre
FOREIGN KEY (nombre)
REFERENCES usuarios(usuario)
ON DELETE CASCADE;

ALTER TABLE rutas
ADD CONSTRAINT fk_rutas_usuario
FOREIGN KEY (id_usuario)
REFERENCES usuarios(id)
ON DELETE CASCADE;