CREATE TABLE system_demos (
    id_demo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_demo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    version_sistema VARCHAR(50) NOT NULL,
    fecha_demo DATE NOT NULL
);
