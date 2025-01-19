CREATE DATABASE salao;
-- Criação da tabela de usuários (caso esteja implementada para controle de login)

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

-- Criação da tabela de categorias
CREATE TABLE categorias (
    cat_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) AFTER nome
);

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    observacao TEXT,
    duracao INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(cat_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)

-- Tabela de agendamentos
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- ID do agendamento
    user_id INT NOT NULL,                     -- Usuário que criou o agendamento
    servico_id INT NOT NULL,                  -- Serviço agendado
    categoria_id INT NOT NULL,                -- Categoria do serviço
    data_hora DATETIME NOT NULL,              -- Data e hora do agendamento
    duracao INT NOT NULL,                     -- Duração do serviço (em minutos)
    status ENUM('PENDENTE', 'CONFIRMADO', 'CANCELADO') DEFAULT 'PENDENTE', -- Status do agendamento
    observacoes TEXT,                         -- Observações adicionais sobre o agendamento
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação do agendamento
    data_modificacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Última modificação
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE,   -- Relaciona com o usuário comum
    FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE, -- Relaciona com o serviço
    FOREIGN KEY (categoria_id) REFERENCES categorias(cat_id) ON DELETE CASCADE -- Relaciona com a categoria
);

CREATE TABLE depoimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                   -- Chave estrangeira para usuários
    comentario TEXT NOT NULL,               -- Texto do depoimento
    aprovacao INT NOT NULL,                 -- 1 = Aprovado, 0 = Pendente
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação
    data_aprovacao TIMESTAMP NULL DEFAULT NULL,  -- Data da aprovação (nula até aprovação)
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

--ususarios---
INSERT INTO usuarios (
    nome, sobrenome, username, celular, whatsapp, endereco, estado, cidade, cpf, data_nascimento, password_hash, nivel_acesso
) VALUES 
    ('João', 'Silva', 'joao.silva@email.com', '11999998888', '11999998888', 'Rua das Flores, 123', 'SP', 'São Paulo', '123.456.789-00', '1990-01-01', 'senha_hash_aqui', 0),
    ('Analia', 'Souza', 'nai@email.com', '21988887777', '21988887777', 'Av. Central, 456', 'RJ', 'Rio de Janeiro', '987.654.321-00', '1992-05-10', 'senha_hash_aqui', 1),
    ('Carlos', 'Santos', 'carlos.santos@email.com', '31977776666', '31977776666', 'Praça das Árvores, 789', 'MG', 'Belo Horizonte', '456.123.789-00', '1985-07-20', 'senha_hash_aqui', 0);

INSERT INTO depoimentos (
    user_id, comentario, aprovacao
) VALUES
    (1, 'Excelente serviço, super recomendo! A equipe é muito atenciosa e eficiente.', 1),
    (1, 'O atendimento poderia ser um pouco mais rápido, mas no geral gostei bastante do trabalho realizado.', 1),
    (2, 'Atendimento maravilhoso e os resultados são impressionantes. Parabéns a toda equipe!', 1),
    (2, 'Fiquei satisfeita com o serviço prestado, porém o preço estava um pouco alto.', 0),
    (3, 'O serviço atendeu todas as minhas expectativas. A qualidade foi acima do esperado!', 1),
    (3, 'Infelizmente tive um problema com o prazo de entrega, mas o suporte me ajudou rapidamente.', 0),
    (1, 'Adorei o resultado final! Super indico para quem precisa de soluções rápidas e eficazes.', 1),
    (1, 'O produto entregou o que prometeu, mas poderia ter sido mais personalizável. No geral, bom serviço.', 0),
    (2, 'Incrível! Me ajudaram em todos os detalhes e o resultado foi além das expectativas.', 1),
    (2, 'Achei que a comunicação poderia ser mais clara, mas no final consegui o que precisava.', 0),
    (3, 'Serviço de excelente qualidade, me surpreendeu! Com certeza voltarei a utilizar.', 1),
    (3, 'O tempo de resposta foi um pouco demorado, mas a solução apresentada foi boa.', 0),
    (1, 'Simplesmente perfeito. O atendimento foi nota 10 e o serviço atendeu a todas as minhas necessidades.', 1),
    (1, 'A equipe foi muito educada, mas o serviço demorou mais do que eu esperava.', 0),
    (2, 'A experiência foi ótima, mas ainda há alguns detalhes a serem ajustados.', 0),
    (2, 'Recomendo o serviço, eles são rápidos e eficientes. Fiquei muito satisfeita com o atendimento!', 1),
    (3, 'Apesar de alguns contratempos, o suporte foi impecável. Aprovado!', 0),
    (3, 'O serviço foi rápido e eficiente, exatamente como eu precisava. Muito bom!', 1),
    (1, 'Uma excelente experiência de compra. O serviço foi de alta qualidade e o preço justo.', 1),
    (2, 'Embora o serviço tenha demorado um pouco, valeu muito a pena. Recomendaria sem dúvidas.', 0);
