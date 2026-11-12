CREATE DATABASE IF NOT EXISTS vehiclesdb DEFAULT CHARACTER SET utf8mb4;
USE vehiclesdb;

DROP TABLE IF EXISTS veiculos;
DROP TABLE IF EXISTS categorias;

-- 1. Categorias (Terrestre, Aéreo, Marítimo)
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categorias (id, categoria) VALUES
(1, 'Terrestre'),
(2, 'Aéreo'),
(3, 'Marítimo');

-- 2. Tabela de Veículos
CREATE TABLE veiculos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  marca VARCHAR(100) NOT NULL,
  pais_origem VARCHAR(100) NOT NULL,
  ano_fundacao INT NOT NULL,
  categoria_id INT NOT NULL,
  CONSTRAINT fk_veiculo_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Veículos Terrestres (Carros e Motos)
INSERT INTO veiculos (marca, pais_origem, ano_fundacao, categoria_id) VALUES
('Mercedes-Benz', 'Alemanha', 1886, 1),
('Peugeot', 'França', 1896, 1),
('Renault', 'França', 1899, 1),
('Fiat', 'Itália', 1899, 1),
('Ford', 'EUA', 1903, 1),
('Rolls-Royce', 'Reino Unido', 1904, 1),
('Audi', 'Alemanha', 1909, 1),
('Alfa Romeo', 'Itália', 1910, 1),
('Aston Martin', 'Reino Unido', 1913, 1),
('BMW', 'Alemanha', 1916, 1),
('Toyota', 'Japão', 1937, 1),
('Volkswagen', 'Alemanha', 1937, 1),
('Ferrari', 'Itália', 1939, 1),
('Porsche', 'Alemanha', 1948, 1),
('Lamborghini', 'Itália', 1963, 1),
('Tesla', 'EUA', 2003, 1),
('BYD', 'China', 2003, 1),
('Royal Enfield', 'Reino Unido / Índia', 1901, 1),
('Triumph', 'Reino Unido', 1902, 1),
('Harley-Davidson', 'EUA', 1903, 1),
('Husqvarna', 'Suécia', 1903, 1),
('Indian Motorcycle', 'EUA', 1901, 1),
('BMW Motorrad', 'Alemanha', 1923, 1),
('Ducati', 'Itália', 1926, 1),
('Vespa (Piaggio)', 'Itália', 1946, 1),
('Honda', 'Japão', 1948, 1),
('Suzuki', 'Japão', 1952, 1),
('Yamaha', 'Japão', 1955, 1),
('KTM', 'Áustria', 1953, 1),
('Kawasaki', 'Japão', 1962, 1);

-- Veículos Aéreos (Aviões)
INSERT INTO veiculos (marca, pais_origem, ano_fundacao, categoria_id) VALUES
('Boeing', 'EUA', 1916, 2),
('Lockheed Martin', 'EUA', 1912, 2),
('Cessna', 'EUA', 1927, 2),
('Piper Aircraft', 'EUA', 1927, 2),
('Bombardier', 'Canadá', 1942, 2),
('Gulfstream', 'EUA', 1958, 2),
('Airbus', 'Europa (Consórcio)', 1970, 2),
('Embraer', 'Brasil', 1969, 2);

-- Veículos Marítimos (Barcos e Iates)
INSERT INTO veiculos (marca, pais_origem, ano_fundacao, categoria_id) VALUES
('Benetti', 'Itália', 1873, 3),
('Chris-Craft', 'EUA', 1874, 3),
('Brunswick (Mercury/Bayliner)', 'EUA', 1845, 3),
('Riva', 'Itália', 1842, 3),
('Lürssen', 'Alemanha', 1875, 3),
('Beneteau', 'França', 1884, 3),
('Azimut Yacht', 'Itália', 1969, 3),
('Sunseeker', 'Reino Unido', 1969, 3),
('Princess Yachts', 'Reino Unido', 1965, 3),
('Ferretti Yachts', 'Itália', 1968, 3);

USE vehiclesdb;

CREATE TABLE IF NOT EXISTS utilizadores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO utilizadores (nome, email, password_hash) VALUES
('Administrador ECGM', 'admin@ecgm.pt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');