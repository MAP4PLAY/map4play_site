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
    tipo_esporte VARCHAR(100) NOT NULL,
    
    -- Características principais
    acessivel BOOLEAN DEFAULT FALSE,
    tem_rampa BOOLEAN DEFAULT FALSE,
    tem_banheiro_adaptado BOOLEAN DEFAULT FALSE,
    tem_iluminacao BOOLEAN DEFAULT FALSE,
    tem_vestiario BOOLEAN DEFAULT FALSE,
    tem_arquibancada BOOLEAN DEFAULT FALSE,
    cobertura BOOLEAN DEFAULT FALSE,
    
    -- Novas características de acessibilidade
    piso_tatil BOOLEAN DEFAULT FALSE,
    elevador BOOLEAN DEFAULT FALSE,
    estacionamento_reservado BOOLEAN DEFAULT FALSE,
    area_descanso BOOLEAN DEFAULT FALSE,
    corrimao_duplo BOOLEAN DEFAULT FALSE,
    sinalizacao_braille BOOLEAN DEFAULT FALSE,
    sinalizacao_visual BOOLEAN DEFAULT FALSE,
    material_libras BOOLEAN DEFAULT FALSE,
    mapa_tatil BOOLEAN DEFAULT FALSE,
    banheiro_trocador BOOLEAN DEFAULT FALSE,
    professores_capacitados BOOLEAN DEFAULT FALSE,
    aulas_esporte_adaptado BOOLEAN DEFAULT FALSE,
    equipamentos_adaptados BOOLEAN DEFAULT FALSE,
    cadeira_rodas_disponivel BOOLEAN DEFAULT FALSE,
    transporte_publico_acessivel BOOLEAN DEFAULT FALSE,
    calcadas_acessiveis BOOLEAN DEFAULT FALSE,
    entrada_acessivel BOOLEAN DEFAULT FALSE,
    
    link_foto TEXT,
    localizacao GEOGRAPHY(POINT, 4326),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_quadras_localizacao ON quadras USING GIST(localizacao);
CREATE INDEX idx_quadras_zona ON quadras(zona);
CREATE INDEX idx_quadras_tipo_esporte ON quadras(tipo_esporte);