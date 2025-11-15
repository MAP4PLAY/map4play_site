-- RECRIAR COM SCRIPT 01
CREATE EXTENSION IF NOT EXISTS postgis;

CREATE TABLE quadras (
    id SERIAL PRIMARY KEY,
    nome_quadra VARCHAR(255) NOT NULL,
    descricao TEXT,
    endereco VARCHAR(500) NOT NULL,
    bairro VARCHAR(100),
    zona VARCHAR(50) NOT NULL,
    cep VARCHAR(10),
    tipo_esporte VARCHAR(50) NOT NULL,
    acessivel BOOLEAN DEFAULT FALSE,
    tem_rampa BOOLEAN DEFAULT FALSE,
    tem_banheiro_adaptado BOOLEAN DEFAULT FALSE,
    tem_iluminacao BOOLEAN DEFAULT FALSE,
    tem_vestiario BOOLEAN DEFAULT FALSE,
    tem_arquibancada BOOLEAN DEFAULT FALSE,
    cobertura BOOLEAN DEFAULT FALSE,
    link_foto TEXT,
    localizacao GEOGRAPHY(POINT, 4326),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_quadras_localizacao ON quadras USING GIST(localizacao);
CREATE INDEX idx_quadras_zona ON quadras(zona);
CREATE INDEX idx_quadras_tipo_esporte ON quadras(tipo_esporte);