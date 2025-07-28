-- ============================================
-- BASE DE DATOS: Hospital de Sampaka
-- ============================================

DROP DATABASE IF EXISTS hospital_sampaka;
CREATE DATABASE hospital_sampaka;
USE hospital_sampaka;

-- ========================
-- TABLA: personal
-- ========================
CREATE TABLE personal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    fecha_nacimiento DATE,
    direccion VARCHAR(255),
    correo VARCHAR(100),
    telefono VARCHAR(20),
    especialidad VARCHAR(100),
    codigo VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- TABLA: roles
-- ========================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- TABLA: usuarios
-- ========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    id_personal INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_rol INT,
    ultimo_inicio_sesion TIMESTAMP,
    FOREIGN KEY (id_personal) REFERENCES personal(id),
    FOREIGN KEY (id_rol) REFERENCES roles(id)
);

-- ========================
-- TABLA: tipo_de_pruebas
-- ========================
CREATE TABLE tipo_de_pruebas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    precio DECIMAL(10,2),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: pacientes
-- ========================
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    fecha_nacimiento DATE,
    dip VARCHAR(50),
    sexo VARCHAR(10),
    direccion VARCHAR(255),
    email VARCHAR(100),
    telefono VARCHAR(20),
    profesion VARCHAR(100),
    tutor VARCHAR(100),
    telefono_tutor VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: consultas
-- ========================
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    motivo_consulta TEXT,
    temperatura DECIMAL(4,1),
    frecuencia_cardiaca INT,
    frecuencia_respiratoria INT,
    tension_arterial VARCHAR(20),
    pulso INT,
    saturacion_oxigeno DECIMAL(4,1),
    peso DECIMAL(5,2),
    id_paciente INT,
    codigo_paciente VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    pagado BOOLEAN,
    historia_enfermedad_actual TEXT,
    exploracion_fisica TEXT,
    precio DECIMAL(10,2),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: detalles_consulta
-- ========================
CREATE TABLE detalles_consulta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    operacion BOOLEAN,
    orina_bien BOOLEAN,
    horas_duerme INT,
    antecedentes_patologicos TEXT,
    alergico_a TEXT,
    grupo_sanguineo VARCHAR(5),
    id_paciente INT,
    id_usuario INT,
    id_consulta INT,
    historia_enfermedad_actual TEXT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_consulta) REFERENCES consultas(id)
);

-- ========================
-- TABLA: citas
-- ========================
CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    comentario TEXT,
    fecha_cita DATE,
    hora TIME,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_usuario_con_quien_cita INT,
    pagado BOOLEAN,
    precio DECIMAL(10,2),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_usuario_con_quien_cita) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: analiticas
-- ========================
CREATE TABLE analiticas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resultado TEXT,
    estado VARCHAR(50),
    id_tipo_prueba INT,
    id_consulta INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_paciente INT,
    codigo_paciente VARCHAR(50),
    pagado BOOLEAN,
    valores_referencia TEXT,
    id_cita INT,
    FOREIGN KEY (id_tipo_prueba) REFERENCES tipo_de_pruebas(id),
    FOREIGN KEY (id_consulta) REFERENCES consultas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_cita) REFERENCES citas(id)
);

-- ========================
-- TABLA: receta
-- ========================
CREATE TABLE receta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    id_consulta INT,
    id_paciente INT,
    codigo_paciente VARCHAR(50),
    comentario TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_cita INT,
    FOREIGN KEY (id_consulta) REFERENCES consultas(id),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_cita) REFERENCES citas(id)
);

-- ========================
-- TABLA: pagos_analiticas
-- ========================
CREATE TABLE pagos_analiticas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cantidad DECIMAL(10,2),
    id_analitica INT,
    id_tipo_prueba INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_analitica) REFERENCES analiticas(id),
    FOREIGN KEY (id_tipo_prueba) REFERENCES tipo_de_pruebas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: salas_de_ingreso
-- ========================
CREATE TABLE salas_de_ingreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: ingresos
-- ========================
CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_sala INT,
    fecha_ingreso DATE,
    fecha_alta DATE,
    token VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    numero_cama INT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_sala) REFERENCES salas_de_ingreso(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- ========================
-- TABLA: log
-- ========================
CREATE TABLE log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    actividad TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
