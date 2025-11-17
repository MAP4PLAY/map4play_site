# MAP4PLAY

Projeto acadêmico desenvolvido para a **UNIVESP**, como parte de um trabalho do Projeto Integrador II do Grupo 013.

---

##  Equipe - Grupo 013 (UNIVESP)

- Camila Amaral de Paula Melo
- André Bomfim da Silva
- Helder Luiz Bachiega
- Veronica Pinheiro Adame
- Luciene Porto dos Santos

---

##  Motivação e Objetivo

A cidade de São Paulo carece de estrutura desportiva para a sua população. E as estruturas existentes ainda são pouco divulgadas e por consequência pouco utilizadas. Essa foi a motivação por trás do presente trabalho.

O objetivo do sistema é criar uma **plataforma web** para mapeamento quadras esportivas, permitindo um melhor usufruto dos munícipes destas estruturas. 

---
# 📂 Estrutura do Projeto MAP4PLAY

```
MAP4PLAY/
│
├── 📄 docker-compose.yml          # Orquestração de containers (Nginx, PHP, PostgreSQL)
├── 📄 render.yaml                 # Configuração para deploy no Render
├── 📄 render.Dockerfile           # Dockerfile específico para produção
├── 📄 README.md                   # Documentação do projeto
├── 📄 guia_commits.md            # Histórico de commits
│
├── 📁 nginx/
│   └── nginx.conf                 # Configuração do servidor Nginx
│
├── 📁 php/
│   └── Dockerfile                 # Imagem PHP 8.2 com extensões PostgreSQL e PostGIS
│
├── 📁 postgres/
│   └── init.sql                   # Script de inicialização do banco (tabelas e índices)
│
└── 📁 src/                        # CÓDIGO-FONTE PRINCIPAL
    │
    ├── PÁGINAS HTML
    │   ├── index.html             # Página inicial (zonas de SP, sobre)
    │   ├── services.php           # Listagem de quadras com filtros
    │   ├── adicionar_quadra.html  # Formulário de cadastro de quadras
    │   ├── detalhes_quadra.php    # Detalhes completos de uma quadra
    │   ├── duvidas.html           # FAQ - Perguntas frequentes
    │   ├── admin_quadras.php      # Painel administrativo (deletar quadras)
    │   └── contact.html           # Formulário de contato (não fornecido)
    │
    ├── APIs E BACKEND (PHP)
    │   ├── config.php             # Configurações do banco (variáveis de ambiente)
    │   ├── conexao_pg.php         # Conexão com PostgreSQL (pg_connect)
    │   ├── api_quadras_pg.php     # API REST: Buscar quadras (filtros, paginação)
    │   ├── api_detalhes_quadra.php # API REST: Detalhes de uma quadra específica
    │   ├── salvar_quadra.php      # Processar cadastro de nova quadra
    │   ├── processa_contato_pg.php # Processar formulário de contato
    │   ├── test_connection.php    # Teste de conexão com banco
    │   └── setup_database.php     # Script de setup/verificação do banco
    │
    ├── RECURSOS ESTÁTICOS
    │   ├── css/                   # Estilos (Bootstrap, custom)
    │   ├── js/                    # Scripts (jQuery, Owl Carousel, custom)
    │   └── images/ (ou imagens/)  # Imagens do projeto
    │       └── logo/              # Logos do projeto
    │
    └── CONFIGURAÇÕES
        └── .vscode/               # Configurações do VS Code
            ├── launch.json
            └── settings.json
```

---

##  Banco de Dados PostgreSQL + PostGIS

### Tabelas Principais:

####  **quadras**
```sql
- id (SERIAL PRIMARY KEY)
- nome_quadra, descricao, endereco, bairro, zona, cep
- tipo_esporte
- acessivel, tem_rampa, tem_banheiro_adaptado, tem_iluminacao
- tem_vestiario, tem_arquibancada, cobertura
- piso_tatil, elevador, estacionamento_reservado, area_descanso
- corrimao_duplo, sinalizacao_braille, sinalizacao_visual
- material_libras, mapa_tatil, banheiro_trocador
- professores_capacitados, aulas_esporte_adaptado
- equipamentos_adaptados, cadeira_rodas_disponivel
- transporte_publico_acessivel, calcadas_acessiveis, entrada_acessivel
- link_foto
- localizacao (GEOGRAPHY POINT - PostGIS)
- created_at
```

####  **contatos**
```sql
- id (SERIAL PRIMARY KEY)
- nome, celular, email, mensagem
- data_contato
```

---

##  Fluxo de Funcionalidades

### 1️⃣ **Visualização de Quadras**
```
index.html → Carousel com quadras destacadas por zona
    ↓
services.php → Lista completa com filtros
    ↓
api_quadras_pg.php → Busca no banco PostgreSQL
    ↓
detalhes_quadra.php → Exibe informações detalhadas
    ↓
api_detalhes_quadra.php → Retorna dados completos (JSON)
```

### 2️⃣ **Cadastro de Quadras**
```
adicionar_quadra.html → Formulário com mapa interativo (Leaflet)
    ↓
salvar_quadra.php → Valida e insere no banco
    ↓
PostgreSQL (tabela quadras) → Armazena coordenadas com PostGIS
```

### 3️⃣ **Busca por Proximidade**
```
services.php → Botão "Buscar Quadras Próximas"
    ↓
Geolocalização do navegador
    ↓
api_quadras_pg.php?lat=X&lng=Y&raio=5000
    ↓
PostGIS: ST_DWithin() → Retorna quadras no raio de 5km
```

### 4️⃣ **Administração**
```
admin_quadras.php → Lista todas as quadras
    ↓
Botão "Deletar" → Remove quadra do banco
```

---

## Tecnologias Utilizadas

### **Frontend:**
- HTML5, CSS3, JavaScript
- Bootstrap 4
- jQuery
- Owl Carousel (carrossel de imagens)
- Leaflet (mapas interativos)
- Font Awesome (ícones)

### **Backend:**
- PHP 8.2 (FPM)
- PostgreSQL 16
- PostGIS 3.4 (extensão espacial)

### **Infraestrutura:**
- Docker Compose (desenvolvimento local)
- Nginx (servidor web)
- Render (produção - deploy automático)

---

## Funcionalidades Principais

✅ **Mapeamento de Quadras Esportivas** (todas as zonas de SP)  
✅ **Filtros Avançados** (zona, tipo de esporte, acessibilidade)  
✅ **Busca por Proximidade** (geolocalização + PostGIS)  
✅ **Cadastro Colaborativo** (qualquer usuário pode adicionar quadras)  
✅ **Detalhes Completos** (27 características de acessibilidade)  
✅ **Paginação Otimizada** (6 quadras por página)  
✅ **Painel Administrativo** (gerenciar quadras)  
✅ **Responsivo** (mobile-friendly)

---

## Como Executar

### **Local (Docker):**
```bash
docker-compose up -d
# Acesse: http://localhost
```

### **Produção (Render):**
```bash
git push origin main
# Deploy automático via render.yaml
```

---

## Licença

Projeto acadêmico de uso exclusivo educacional (UNIVESP - Projeto Integrador II)

Licença

Este projeto é de uso exclusivamente ACADÊMICO e não é permitido para fins comerciais. 