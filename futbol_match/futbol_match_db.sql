-- Crear base de datos
CREATE DATABASE futbol_match_db;
GO

-- Tabla equipos
CREATE TABLE equipos (
  id INT IDENTITY(1,1) PRIMARY KEY,
  nombre NVARCHAR(50) NOT NULL UNIQUE,
  password CHAR(64) NOT NULL,
  edad_min INT NOT NULL,
  edad_max INT NOT NULL,
  victorias INT DEFAULT 0,
  derrotas INT DEFAULT 0,
  distrito NVARCHAR(100),
  rango NVARCHAR(50),
  jugadores NVARCHAR(MAX)
);
GO

-- Insertar equipos con contraseñas (debes aplicar hash SHA-256 desde backend)
INSERT INTO equipos (nombre, password, edad_min, edad_max, victorias, derrotas, distrito, rango, jugadores) VALUES
('Team1', '1234', 17, 20, 2, 0, 'Comas', '17-20', '7 jugadores'),
('Team2', '1234', 17, 22, 1, 1, 'Comas', '17-22', '7 jugadores'),
('Team3', '1234', 17, 25, 1, 2, 'Los Olivos', '17-25', '7 jugadores'),
('Team4', '1234', 17, 20, 0, 2, 'Los Olivos', '17-20', '7 jugadores');
GO

-- Tabla invitaciones
CREATE TABLE invitaciones (
  id INT IDENTITY(1,1) PRIMARY KEY,
  equipo_envia NVARCHAR(50) NOT NULL,
  equipo_recibe NVARCHAR(50) NOT NULL,
  fecha_envio DATETIME DEFAULT GETDATE(),
  estado NVARCHAR(20) DEFAULT 'pendiente'
);
GO

-- Tabla notificaciones
CREATE TABLE notificaciones (
  id INT IDENTITY(1,1) PRIMARY KEY,
  equipo_destino NVARCHAR(100),
  mensaje NVARCHAR(MAX),
  leido BIT DEFAULT 0
);
GO
SELECT * FROM equipos;

