-- ============================================
-- BASE DE DATOS: Hospital de Sampaka
-- ============================================

-- Tabla: personal
CREATE TABLE personal (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    fecha_nacimiento DATE,
    direccion VARCHAR(255),
    correo VARCHAR(100), -- Puede ser nulo
    telefono VARCHAR(20),
    especialidad VARCHAR(100),
    codigo VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: roles
CREATE TABLE roles (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT
    -- FOREIGN KEY se añadirá luego para evitar ciclos
);

-- Tabla: usuarios
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    id_personal INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_rol INT,
    ultimo_inicio_sesion TIMESTAMP,
    FOREIGN KEY (id_personal) REFERENCES personal(id),
    FOREIGN KEY (id_rol) REFERENCES roles(id)
);

-- Relación ciclo: roles → usuarios (ahora puede añadirse)
ALTER TABLE roles
ADD CONSTRAINT fk_roles_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

-- Tabla: tipo_de_pruebas
CREATE TABLE tipo_de_pruebas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    precio DECIMAL(10,2),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla: pacientes
CREATE TABLE pacientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    fecha_nacimiento DATE,
    dip VARCHAR(50), -- Puede ser nulo
    sexo VARCHAR(10),
    direccion VARCHAR(255),
    email VARCHAR(100),
    telefono VARCHAR(20),
    profesion VARCHAR(100),
    tutor VARCHAR(100), -- Puede ser nulo
    telefono_tutor VARCHAR(20), -- Puede ser nulo
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla: consultas
CREATE TABLE consultas (
    id SERIAL PRIMARY KEY,
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

-- Tabla: detalles_consulta
CREATE TABLE detalles_consulta (
    id SERIAL PRIMARY KEY,
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

-- Tabla: citas
CREATE TABLE citas (
    id SERIAL PRIMARY KEY,
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

-- Tabla: analiticas
CREATE TABLE analiticas (
    id SERIAL PRIMARY KEY,
    resultado TEXT,
    estado VARCHAR(50),
    id_tipo_prueba INT,
    id_consulta INT, -- puede ser nulo
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_paciente INT,
    codigo_paciente VARCHAR(50),
    pagado BOOLEAN,
    valores_referencia TEXT, -- puede ser nulo
    id_cita INT,
    FOREIGN KEY (id_tipo_prueba) REFERENCES tipo_de_pruebas(id),
    FOREIGN KEY (id_consulta) REFERENCES consultas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_cita) REFERENCES citas(id)
);

-- Tabla: receta
CREATE TABLE receta (
    id SERIAL PRIMARY KEY,
    descripcion TEXT,
    id_consulta INT, -- puede ser nulo
    id_paciente INT,
    codigo_paciente VARCHAR(50),
    comentario TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_cita INT, -- puede ser nulo
    FOREIGN KEY (id_consulta) REFERENCES consultas(id),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_cita) REFERENCES citas(id)
);

-- Tabla: pagos_analiticas
CREATE TABLE pagos_analiticas (
    id SERIAL PRIMARY KEY,
    cantidad DECIMAL(10,2),
    id_analitica INT,
    id_tipo_prueba INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_analitica) REFERENCES analiticas(id),
    FOREIGN KEY (id_tipo_prueba) REFERENCES tipo_de_pruebas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla: salas_de_ingreso
CREATE TABLE salas_de_ingreso (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla: ingresos
CREATE TABLE ingresos (
    id SERIAL PRIMARY KEY,
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

-- Tabla: log
CREATE TABLE log (
    id SERIAL PRIMARY KEY,
    id_usuario INT,
    actividad TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
