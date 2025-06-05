CREATE DATABASE IF NOT EXISTS ecocards;


USE ecocards;


CREATE TABLE IF NOT EXISTS cadastro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20)
)

CREATE TABLE IF NOT EXISTS assinatura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    plano ENUM('basico', 'premium', 'deluxe') NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    status ENUM('ativo', 'cancelado', 'suspenso') DEFAULT 'ativo',
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id) ON DELETE CASCADE
);
