CREATE DATABASE salao;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,        -- Primeiro nome
    sobrenome VARCHAR(50) NOT NULL,   -- Sobrenome
    username VARCHAR(50) NOT NULL UNIQUE, -- Armazena o e-mail
    celular VARCHAR(15),
    whatsapp VARCHAR(15),
    endereco VARCHAR(255),
    estado VARCHAR(50),
    cidade VARCHAR(50),
    cpf VARCHAR(14) UNIQUE,
    data_nascimento DATE,
    password_hash VARCHAR(255) NOT NULL,
    nivel_acesso TINYINT DEFAULT 0
);
