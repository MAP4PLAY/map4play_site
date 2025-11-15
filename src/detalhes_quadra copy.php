<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes da Quadra - MAP 4 PLAY</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <style>
        .quadra-detalhes {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .quadra-imagem {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .badge {
            margin-right: 5px;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
        }
        .badge-success { background: #4CAF50; color: white; }
        .badge-warning { background: #ff9800; color: white; }
        .badge-info { background: #2196F3; color: white; }
        .info-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #f6815e;
        }
        .acoes-botoes {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .btn-editar {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-voltar {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-voltar:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
        .btn-compartilhar {
            background: #17a2b8;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
        }
        .quadra-titulo {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #f6815e;
            padding-bottom: 10px;
        }
        .info-item {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-item strong {
            color: #333;
        }
        .loading-spinner {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html"><img src="images/LOGO_BUSSOLA.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">Sobre</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="services.php">Quadras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="client.html">Avaliações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="duvidas.html">Dúvidas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contato</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <div class="user_icon"><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></div>
                        <div class="user_icon"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></div>
                    </form>
                </div>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="service_section layout_padding">
        <div class="container">
            <div class="quadra-detalhes">
                <a href="services.php" class="btn-voltar">
                    <i class="fa fa-arrow-left"></i> Voltar para Lista de Quadras
                </a>
                
                <div id="conteudo-detalhes">
                    <div class="loading-spinner">
                        <i class="fa fa-spinner fa-spin"></i> Carregando detalhes da quadra...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer_section margin_top90">
        <div class="location_bg">
            <div class="container">
                <div class="location_main">
                    <ul>
                        <li>
                            <a href="#"><img src="images/mail-icon.png">
                            <span class="padding_15">map4play@gmail.com</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">MAP 4 PLAY © 2025 Todos os direitos reservados.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
        // Pegar o ID da quadra da URL
        const urlParams = new URLSearchParams(window.location.search);
        const quadraId = urlParams.get('id');

        function carregarDetalhesQuadra(id) {
            fetch(`api_detalhes_quadra.php?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na rede');
                    }
                    return response.json();
                })
                .then(quadra => {
                    if (quadra.erro) {
                        document.getElementById('conteudo-detalhes').innerHTML = `
                            <div class="alert alert-danger text-center">
                                <h4>❌ Quadra não encontrada</h4>
                                <p>${quadra.mensagem || 'A quadra solicitada não existe ou foi removida.'}</p>
                                <a href="services.php" class="btn btn-primary">Voltar para Quadras</a>
                            </div>
                        `;
                        return;
                    }

                    // Construir badges
                    let badges = '';
                    if (quadra.acessivel) {
                        badges += '<span class="badge badge-success">♿ Acessível</span>';
                    }
                    if (quadra.tem_iluminacao) {
                        badges += '<span class="badge badge-warning">💡 Iluminação Noturna</span>';
                    }
                    if (quadra.tem_vestiario) {
                        badges += '<span class="badge badge-info">🚿 Vestiário</span>';
                    }

                    // Formatar data se existir
                    let dataFormatada = '';
                    if (quadra.data_cadastro) {
                        const data = new Date(quadra.data_cadastro);
                        dataFormatada = data.toLocaleDateString('pt-BR');
                    }

                    document.getElementById('conteudo-detalhes').innerHTML = `
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <img src="${quadra.link_foto || 'images/quadra-default.jpg'}" 
                                     alt="${quadra.nome_quadra}" 
                                     class="quadra-imagem"
                                     onerror="this.src='images/quadra-default.jpg'">
                                
                                ${badges ? `<div class="mb-4">${badges}</div>` : ''}
                            </div>
                            
                            <div class="col-lg-6 col-md-12">
                                <h1 class="quadra-titulo">${quadra.nome_quadra}</h1>
                                
                                <div class="info-card">
                                    <h4><i class="fa fa-info-circle"></i> Informações da Quadra</h4>
                                    <div class="info-item">
                                        <strong>📍 Endereço:</strong> ${quadra.endereco || 'Endereço não informado'}
                                    </div>
                                    <div class="info-item">
                                        <strong>🏘️ Bairro:</strong> ${quadra.bairro || 'Bairro não informado'}
                                    </div>
                                    <div class="info-item">
                                        <strong>🗺️ Zona:</strong> ${quadra.zona || 'Zona não informada'}
                                    </div>
                                    <div class="info-item">
                                        <strong>🎯 Tipo de Esporte:</strong> ${quadra.tipo_esporte || 'Não especificado'}
                                    </div>
                                    ${quadra.latitude && quadra.longitude ? `
                                    <div class="info-item">
                                        <strong>🌐 Coordenadas:</strong> ${quadra.latitude}, ${quadra.longitude}
                                    </div>
                                    ` : ''}
                                    ${dataFormatada ? `
                                    <div class="info-item">
                                        <strong>📅 Cadastrado em:</strong> ${dataFormatada}
                                    </div>
                                    ` : ''}
                                </div>

                                ${quadra.descricao ? `
                                <div class="info-card">
                                    <h4><i class="fa fa-file-text"></i> Descrição</h4>
                                    <p style="font-size: 16px; line-height: 1.6;">${quadra.descricao}</p>
                                </div>
                                ` : ''}

                                <div class="acoes-botoes">
                                    <button onclick="editarQuadra(${quadra.id})" class="btn-editar">
                                        <i class="fa fa-edit"></i> Editar Quadra
                                    </button>
                                    <button onclick="compartilharQuadra()" class="btn-compartilhar">
                                        <i class="fa fa-share-alt"></i> Compartilhar
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('conteudo-detalhes').innerHTML = `
                        <div class="alert alert-danger text-center">
                            <h4>❌ Erro ao Carregar</h4>
                            <p>Ocorreu um erro ao carregar os detalhes da quadra. Por favor, tente novamente.</p>
                            <button onclick="carregarDetalhesQuadra(${quadraId})" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Tentar Novamente
                            </button>
                        </div>
                    `;
                });
        }

        function editarQuadra(id) {
            // Por enquanto, mostra alerta - você pode implementar a página de edição depois
            alert(`Funcionalidade de edição para a quadra ID: ${id}\n\nVocê pode criar editar_quadra.php depois.`);
            // window.location.href = `editar_quadra.php?id=${id}`;
        }

        function compartilharQuadra() {
            if (navigator.share) {
                // Web Share API (dispositivos móveis)
                navigator.share({
                    title: document.title,
                    text: 'Confira esta quadra no MAP 4 PLAY!',
                    url: window.location.href
                })
                .then(() => console.log('Compartilhado com sucesso'))
                .catch(error => console.log('Erro ao compartilhar:', error));
            } else {
                // Fallback para desktop - copiar link
                navigator.clipboard.writeText(window.location.href)
                    .then(() => {
                        alert('✅ Link copiado para a área de transferência!');
                    })
                    .catch(err => {
                        // Fallback mais simples
                        const tempInput = document.createElement('input');
                        tempInput.value = window.location.href;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);
                        alert('✅ Link copiado para a área de transferência!');
                    });
            }
        }

        // Carregar detalhes quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            if (quadraId) {
                carregarDetalhesQuadra(quadraId);
            } else {
                document.getElementById('conteudo-detalhes').innerHTML = `
                    <div class="alert alert-warning text-center">
                        <h4>⚠️ ID não especificado</h4>
                        <p>Nenhuma quadra foi selecionada. Volte para a lista e clique em "Ver Detalhes".</p>
                        <a href="services.php" class="btn btn-primary">Voltar para Quadras</a>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>