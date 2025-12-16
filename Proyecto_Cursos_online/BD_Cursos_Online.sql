-- ============================================================
--  BASE DE DATOS: bd_cursos_online
-- ============================================================

CREATE DATABASE IF NOT EXISTS bd_cursos_online;
USE bd_cursos_online;

-- ============================================================
--  TABLA: roles
-- ============================================================
CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
);

-- ============================================================
--  TABLA: usuarios
-- ============================================================
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  clave VARCHAR(255) NOT NULL,
  id_rol INT DEFAULT 2,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- ============================================================
--  TABLA: categorias
-- ============================================================
CREATE TABLE categorias (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  estado VARCHAR(20) DEFAULT 'activo'
);

-- ============================================================
--  TABLA: cursos
-- ============================================================
CREATE TABLE cursos (
  id_curso INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  descripcion TEXT,
  id_profesor INT,
  id_categoria INT,
  fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  precio DECIMAL(10,2) DEFAULT 0.00,
  estado VARCHAR(20) DEFAULT 'activo',
  FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
  FOREIGN KEY (id_profesor) REFERENCES usuarios(id_usuario)
);

-- ============================================================
--  TABLA: modulos
-- ============================================================
CREATE TABLE modulos (
  id_modulo INT AUTO_INCREMENT PRIMARY KEY,
  id_curso INT NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  descripcion TEXT,
  FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

-- ============================================================
--  TABLA: lecciones
-- ============================================================
CREATE TABLE lecciones (
  id_leccion INT AUTO_INCREMENT PRIMARY KEY,
  id_modulo INT NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  contenido TEXT,
  video_url VARCHAR(255),
  FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo)
);

-- ============================================================
--  TABLA: progreso
-- ============================================================
CREATE TABLE progreso (
  id_progreso INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_leccion INT NOT NULL,
  completado TINYINT(1) DEFAULT 0,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_leccion) REFERENCES lecciones(id_leccion)
);

-- ============================================================
--  TABLA: comentarios
-- ============================================================
CREATE TABLE comentarios (
  id_comentario INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_curso INT NOT NULL,
  comentario TEXT,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

-- ============================================================
--  INSERCIÓN DE DATOS INICIALES
-- ============================================================

INSERT INTO roles (nombre) VALUES
('admin'),
('estudiante'),
('profesor');

-- Contraseña: admin123 (reemplaza el hash por uno generado con bcrypt)
INSERT INTO usuarios (nombre, correo, clave, id_rol) VALUES
('Administrador', 'admin@example.com', '$2b$10$DUMMYHASHREEMPLAZAR', 1);
