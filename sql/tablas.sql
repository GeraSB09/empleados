-- Desactivar la verificación de claves foráneas temporalmente
SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


CREATE TABLE estados (
  pk_estado int(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  estado int(1) NOT NULL DEFAULT 1,
  hora time NOT NULL,
  fecha_creacion date NOT NULL,
  fecha_modificacion date NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE municipios (
  pk_municipio int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  nombre_estado int(4) NOT NULL,
  estado int(1) NOT NULL DEFAULT 1,
  hora time NOT NULL,
  fecha_creacion date NOT NULL,
  fecha_modificacion date NULL,
  KEY index_estado (nombre_estado) USING BTREE,
  CONSTRAINT fk_estado FOREIGN KEY (estado) REFERENCES estados (pk_estado) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32059 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE municipios 
CHANGE nombre_estado numero_estado int(4) NOT NULL;


CREATE TABLE colonias (
  pk_colonia int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  ciudad varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  municipio int(6) DEFAULT NULL,
  asentamiento varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  codigo_postal varchar(5) DEFAULT NULL,
  estado int(1) NOT NULL DEFAULT 1,
  hora time NOT NULL,
  fecha_creacion date NOT NULL,
  fecha_modificacion date NULL,
  KEY index_municipio (municipio) USING BTREE,
  CONSTRAINT fk_municipio FOREIGN KEY (municipio) REFERENCES municipios (pk_municipio) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1607710190 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE departamento(
    pk_departamento int PRIMARY KEY AUTO_INCREMENT,
    nombre_departamento varchar(50) NOT NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL
);


CREATE TABLE puesto(
    pk_puesto int PRIMARY KEY AUTO_INCREMENT,
    nombre_puesto varchar(50) NOT NULL,
    salario decimal(10,2) NOT NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL,
    fk_departamento int NOT NULL,
    FOREIGN KEY (fk_departamento) REFERENCES departamento(pk_departamento)
);

CREATE TABLE carrera(
    pk_carrera int PRIMARY KEY AUTO_INCREMENT,
    nombre_carrera varchar(50) NOT NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL
);


CREATE TABLE empleados(
    pk_empleado int PRIMARY KEY AUTO_INCREMENT,
    numero_empleado int NOT NULL,
    nombres varchar(50) NOT NULL,
    primer_apellido varchar(50) NOT NULL,
    segundo_apellido varchar(50) NULL,
    edad int NOT NULL,
    sexo char(1) NOT NULL COMMENT 'm para mujer, h para hombre',
    fecha_nacimiento date NOT NULL,
    fotografia varchar(155) NULL,
    telefono varchar(10) NULL,
    rfc varchar(20) NULL,
    curp varchar(20) NULL,
    nss varchar(20) NULL,
    email varchar(50) NULL,
    turno varchar(20) NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL,
    fk_puesto int NOT NULL,
    fk_carrera int NOT NULL,
    FOREIGN KEY (fk_puesto) REFERENCES puesto(pk_puesto),
    FOREIGN KEY (fk_carrera) REFERENCES carrera(pk_carrera)
);


CREATE TABLE domicilio(
    pk_domicilio int PRIMARY KEY AUTO_INCREMENT,
    calle varchar(50) NOT NULL,
    numero int NOT NULL,
    entre_calle varchar(50) NULL,
    referencia varchar(50) NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL,
    fk_colonia int NOT NULL,
    fk_empleado int NOT NULL,
    FOREIGN KEY (fk_colonia) REFERENCES colonias(pk_colonia),
    FOREIGN KEY (fk_empleado) REFERENCES empleados(pk_empleado)
);


CREATE TABLE es_jefe_de(
    pk_es_jefe_de int PRIMARY KEY AUTO_INCREMENT,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL,
    fk_departamento int NOT NULL,
    fk_empleado int NOT NULL,
    FOREIGN KEY (fk_departamento) REFERENCES departamento(pk_departamento),
    FOREIGN KEY (fk_empleado) REFERENCES empleados(pk_empleado)
);


CREATE TABLE antiguedad(
    pk_antiguedad int PRIMARY KEY AUTO_INCREMENT,
    anios int NOT NULL,
    meses int NOT NULL,
    dias int NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date NOT NULL,
    estado int(1) NOT NULL DEFAULT 1,
    hora time NOT NULL,
    fecha_creacion date NOT NULL,
    fecha_modificacion date NULL,
    fk_empleado int NOT NULL,
    fk_puesto int NOT NULL,
    FOREIGN KEY (fk_empleado) REFERENCES empleados(pk_empleado),
    FOREIGN KEY (fk_puesto) REFERENCES puesto(pk_puesto)
);

-- Reactivar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;



INSERT INTO empleados (numero_empleado, nombres, primer_apellido, segundo_apellido, edad, sexo, fecha_nacimiento, fotografia, telefono, rfc, curp, nss, email, turno, estado, hora, fecha_creacion, fecha_modificacion, fk_puesto, fk_carrera) VALUES 
(1, 'Juan', 'Pérez', 'Gómez', 25, 'h', '1995-03-15', 'foto1.jpg', '1234567890', 'PEGJ950315RF5', 'PEGJ950315HDFRNN09', '48159512458', 'juan.perez@example.com', 'mañana', 1, '09:00:00', '2024-01-01', NULL, 1, 1),
(2, 'María', 'López', 'Hernández', 30, 'm', '1990-07-20', 'foto2.jpg', '9876543210', 'LOHM900720MN8', 'LOHM900720MDFRNS01', '52159034567', 'maria.lopez@example.com', 'tarde', 1, '10:00:00', '2024-01-01', NULL, 2, 2),
(3, 'Carlos', 'García', 'Martínez', 28, 'h', '1992-11-05', 'foto3.jpg', '5551234567', 'GAMC921105P45', 'GAMC921105HDFRRR03', '12159256789', 'carlos.garcia@example.com', 'noche', 1, '18:00:00', '2024-01-01', NULL, 3, 3),
(4, 'Ana', 'Díaz', 'Sánchez', 22, 'm', '1998-05-12', 'foto4.jpg', '1112223333', 'DISA980512KL6', 'DISA980512MDFRNN07', '36159878901', 'ana.diaz@example.com', 'mañana', 1, '09:00:00', '2024-01-01', NULL, 4, 4),
(5, 'Luis', 'Gómez', 'Hernández', 35, 'h', '1985-09-18', 'foto5.jpg', '7778889999', 'GOHL850918TP2', 'GOHL850918HDFRRS05', '25158534567', 'luis.gomez@example.com', 'tarde', 1, '11:00:00', '2024-01-01', NULL, 5, 5),
(6, 'Laura', 'Hernández', 'Gómez', 29, 'm', '1991-04-25', 'foto6.jpg', '2223334444', 'HEGL910425MN9', 'HEGL910425MDFRRA04', '14159123456', 'laura.hernandez@example.com', 'noche', 1, '19:00:00', '2024-01-01', NULL, 6, 6),
(7, 'Miguel', 'Sánchez', 'Díaz', 27, 'h', '1993-06-30', 'foto7.jpg', '3334445555', 'SADM930630RS4', 'SADM930630HDFRNG02', '58159367890', 'miguel.sanchez@example.com', 'mañana', 1, '08:00:00', '2024-01-01', NULL, 7, 7),
(8, 'Elena', 'Gómez', 'Hernández', 32, 'm', '1988-12-10', 'foto8.jpg', '4445556666', 'GOHE881210NP5', 'GOHE881210MDFRRL08', '69158845678', 'elena.gomez@example.com', 'tarde', 1, '12:00:00', '2024-01-01', NULL, 8, 8),
(9, 'Fernando', 'López', 'Gómez', 31, 'h', '1989-08-05', 'foto9.jpg', '5556667777', 'LOGF890805HT7', 'LOGF890805HDFRMR06', '47158923456', 'fernando.lopez@example.com', 'noche', 1, '20:00:00', '2024-01-01', NULL, 9, 9),
(10, 'Isabel', 'Gómez', 'Hernández', 26, 'm', '1994-02-14', 'foto10.jpg', '6667778888', 'GOHI940214MP1', 'GOHI940214MDFRRS03', '36159445678', 'isabel.gomez@example.com', 'mañana', 1, '07:00:00', '2024-01-01', NULL, 10, 10),
(11, 'Ricardo', 'Gómez', 'Hernández', 26, 'h', '1994-02-14', 'foto10.jpg', '6667778888', 'GOHR940214LC5', 'GOHR940214HDFRRC01', '36159445679', 'ricardo.gomez@example.com', 'mañana', 1, '07:00:00', '2024-01-01', NULL, 10, 10);
