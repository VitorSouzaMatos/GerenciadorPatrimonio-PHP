-- database.sql
CREATE DATABASE IF NOT EXISTS db_patrimonio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_patrimonio;

-- Tabela de usuários
CREATE TABLE tb_usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    role ENUM('admin', 'operador') DEFAULT 'operador',
    ativo TINYINT(1) DEFAULT 1,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Inserir usuário admin padrão (senha: admin123)
INSERT INTO tb_usuarios (nome, email, senha, role) VALUES 
('Administrador', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Operador Teste', 'operador@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'operador');

-- Tabela de categorias
CREATE TABLE tb_categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de andares
CREATE TABLE tb_andares (
    id_andar INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ordem INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ordem (ordem)
) ENGINE=InnoDB;

-- Tabela de salas
CREATE TABLE tb_salas (
    id_sala INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    id_andar INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_andar) REFERENCES tb_andares(id_andar) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela de objetos
CREATE TABLE tb_objetos (
    id_objeto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    id_categoria INT NOT NULL,
    id_sala INT NOT NULL,
    placa VARCHAR(50) UNIQUE,
    data_aquisicao DATE,
    valor DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('ativo', 'inativo', 'manutencao', 'descartado') DEFAULT 'ativo',
    observacoes TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES tb_categorias(id_categoria),
    FOREIGN KEY (id_sala) REFERENCES tb_salas(id_sala)
) ENGINE=InnoDB;

-- Tabela de ocorrências
CREATE TABLE tb_ocorrencias (
    id_ocorrencia INT AUTO_INCREMENT PRIMARY KEY,
    id_objeto INT NOT NULL,
    tipo ENUM('manutencao', 'dano', 'perda', 'encontrado') NOT NULL,
    descricao TEXT NOT NULL,
    data_ocorrencia DATE NOT NULL,
    id_usuario INT NOT NULL,
    status ENUM('aberta', 'em_andamento', 'resolvida') DEFAULT 'aberta',
    data_resolucao DATE NULL,
    observacao_resolucao TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_objeto) REFERENCES tb_objetos(id_objeto),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario)
) ENGINE=InnoDB;

-- Índices para melhorar performance
CREATE INDEX idx_objetos_categoria ON tb_objetos(id_categoria);
CREATE INDEX idx_objetos_sala ON tb_objetos(id_sala);
CREATE INDEX idx_objetos_status ON tb_objetos(status);
CREATE INDEX idx_ocorrencias_objeto ON tb_ocorrencias(id_objeto);
CREATE INDEX idx_ocorrencias_status ON tb_ocorrencias(status);
CREATE INDEX idx_ocorrencias_data ON tb_ocorrencias(data_ocorrencia);