<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Quadras - MAP 4 PLAY</title>
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
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <style>
         .filtros-zona {
            margin: 30px 0;
            text-align: center;
         }
         .filtros-zona button {
            margin: 5px;
            padding: 10px 20px;
            background: #f6815e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
         }
         .filtros-zona button:hover {
            background: #e56f4e;
         }
         .filtros-zona button.active {
            background: #333;
         }
         .quadra-info {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            margin: 10px 0;
         }
         .badge {
            display: inline-block;
            padding: 4px 8px;
            margin: 3px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
         }
         .badge-success { background: #4CAF50; color: white; }
         .badge-warning { background: #ff9800; color: white; }
         .badge-info { background: #2196F3; color: white; }
         .paginacao {
            text-align: center;
            margin: 30px 0;
         }
         .paginacao button {
            margin: 0 5px;
            padding: 8px 15px;
            background: #f6815e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
         }
         .paginacao button:disabled {
            background: #ccc;
            cursor: not-allowed;
         }

           /* Remover fundo preto e fazer imagem preencher */
.owl-carousel .item .image_box {
    width: 100%;
    height: 280px;
    overflow: hidden;
    border-radius: 10px;
    background: transparent !important; /* Remove fundo preto */
    padding: 0 !important;
    margin: 0 !important;
}

.owl-carousel .item .image_box img {
    width: 100% !important;
    height: 280px !important; /* Mesma altura do container */
    object-fit: cover !important;
    object-position: center !important;
    border-radius: 10px !important;
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Garantir que não há espaços extras */
.owl-carousel .item img {
    max-width: 100% !important;
    max-height: 280px !important;
}


      </style>
   </head>
   <body>
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="index.html"><img src="images/logo/logo_capa.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item">
                        <a class="nav-link" href="index.html">Início</a>
                     </li>
                     <li class="nav-item active">
                        <a class="nav-link" href="services.php">Quadras</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="duvidas.html">Dúvidas</a>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
      </div>

      <div class="service_section layout_padding">
         <div class="container">
            <h1 class="service_taital">Quadras Esportivas em São Paulo</h1>
            
            <div class="filtros-zona">
               <button onclick="filtrarPorZona('todas')" class="active" id="btn-todas">Todas as Zonas</button>
               <button onclick="filtrarPorZona('Zona Leste')" id="btn-leste">Zona Leste</button>
               <button onclick="filtrarPorZona('Zona Oeste')" id="btn-oeste">Zona Oeste</button>
               <button onclick="filtrarPorZona('Zona Norte')" id="btn-norte">Zona Norte</button>
               <button onclick="filtrarPorZona('Zona Sul')" id="btn-sul">Zona Sul</button>
               <button onclick="filtrarPorZona('Centro')" id="btn-centro">Centro</button>
            </div>

                     

            <div style="text-align: center; margin: 20px 0;">
            <div style="display: inline-flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
      
            <!-- Botão Buscar Quadras Próximas (existente) -->
            <div>
               <button onclick="buscarPorLocalizacao()" style="background: #2196F3; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            📍 Buscar Quadras Próximas
            </button>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">
            Encontre quadras perto de você!
            </p>
         </div>

         <!-- NOVO Botão Cadastrar Quadra -->
         <div>
         <button onclick="cadastrarQuadra()" style="background: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            ➕ Cadastrar uma Quadra
         </button>
         <p style="font-size: 12px; color: #666; margin-top: 5px;">
            Adicione uma nova quadra ao mapa!
         </p>
         </div>

      </div>
   </div>



                     


            <div class="service_section_2 layout_padding">
               <div class="owl-carousel owl-theme" id="quadras-carousel">
                  <div class="item" style="text-align: center; padding: 50px;">
                     <p>Carregando quadras...</p>
                  </div>
               </div>
            </div>

            <!-- Paginação -->
            <div class="paginacao">
               <button onclick="mudarPagina(paginaAtual - 1)" id="btn-anterior">← Anterior</button>
               <span id="info-pagina" style="margin: 0 15px;">Página 1</span>
               <button onclick="mudarPagina(paginaAtual + 1)" id="btn-proximo">Próxima →</button>
            </div>
         </div>
      </div>

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
            <p class="copyright_text">MAP 4 PLAY © 2025 Todos os direitos reservados. </p>
         </div>
      </div>

      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/owl.carousel.js"></script>
      
      <script>
      let todasQuadras = [];
      let zonaAtual = 'todas';
      let paginaAtual = 1;

      let ultimaLatitude = null;
      let ultimaLongitude = null;

      const limitePorPagina = 6;

      function carregarQuadras(zona = 'todas', pagina = 1) {
         let url = `api_quadras_pg.php?pagina=${pagina}&limite=${limitePorPagina}`;
         
         if (zona !== 'todas') {
            url += `&zona=${encodeURIComponent(zona)}`;
         }

         fetch(url)
            .then(response => response.json())
            .then(data => {
               if (data.erro) {
                  console.error('Erro:', data.mensagem);
                  return;
               }

               todasQuadras = data.quadras;
               exibirQuadras(data.quadras);
               atualizarPaginacao(data);
            })
            .catch(error => {
               console.error('Erro ao carregar as quadras:', error);
            });
      }

      function exibirQuadras(quadras) {
         const carousel = document.querySelector('#quadras-carousel');
         
         if (typeof $('.owl-carousel').data('owl.carousel') !== 'undefined') {
            $('.owl-carousel').trigger('destroy.owl.carousel');
         }
         
         carousel.innerHTML = '';

         if (quadras.length === 0) {
            carousel.innerHTML = '<div class="item" style="text-align: center; padding: 50px;"><p>Nenhuma quadra encontrada para esta zona.</p></div>';
            return;
         }

         quadras.forEach(quadra => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'item';
            
            let badges = '';
            if (quadra.acessivel) {
               badges += '<span class="badge badge-success">Acessível</span>';
            }
            if (quadra.tem_iluminacao) {
               badges += '<span class="badge badge-warning">Iluminação</span>';
            }
            if (quadra.tem_vestiario) {
               badges += '<span class="badge badge-info">Vestiário</span>';
            }

            itemDiv.innerHTML = `
               <div class="image_box">
                  <img src="${quadra.link_foto || 'images/quadra-default.jpg'}" alt="${quadra.nome_quadra}" ///////<!-- style="width: 100%; height: 250px; object-fit: cover;" /> -->
               </div>
               <h3 class="sound_text">${quadra.nome_quadra}</h3>
               <div class="quadra-info">
                  <p><strong>📍 ${quadra.zona}</strong> - ${quadra.bairro || 'São Paulo'}</p>
                  <p><strong>🏃 ${quadra.tipo_esporte}</strong></p>
                  <p>${quadra.descricao || 'Quadra esportiva disponível para uso público.'}</p>
                  <div style="margin-top: 10px;">
                     ${badges}
                  </div>
                  ${quadra.distancia_metros ? `<p style="margin-top: 10px;"><strong>📏 ${(quadra.distancia_metros / 1000).toFixed(2)} km de distância</strong></p>` : ''}
               </div>
               <div class="buy_bt"><a href="#" onclick="verDetalhes(${quadra.id}); return false;">Ver Detalhes</a></div>
            `;
            
            carousel.appendChild(itemDiv);
         });

         $('.owl-carousel').owlCarousel({
            loop: quadras.length > 3,
            margin: 35,
            nav: true,
            center: false,
            responsive: {
               0: { items: 1, margin: 0 },
               575: { items: 1, margin: 0 },
               768: { items: 2, margin: 20 },
               1000: { items: 3 }
            }
         });
      }

      function filtrarPorZona(zona) {
         zonaAtual = zona;
         paginaAtual = 1;
         
         document.querySelectorAll('.filtros-zona button').forEach(btn => {
            btn.classList.remove('active');
         });
         
         if (zona === 'todas') {
            document.getElementById('btn-todas').classList.add('active');
         } else {
            document.getElementById(`btn-${zona.split(' ')[1].toLowerCase()}`).classList.add('active');
         }

         carregarQuadras(zona, paginaAtual);
      }

      function mudarPagina(novaPagina) {
         if (novaPagina < 1) return;
         paginaAtual = novaPagina;
         carregarQuadras(zonaAtual, paginaAtual);
      }

      function atualizarPaginacao(data) {
         document.getElementById('info-pagina').textContent = `Página ${paginaAtual}`;
         
         const btnAnterior = document.getElementById('btn-anterior');
         const btnProximo = document.getElementById('btn-proximo');
         
         btnAnterior.disabled = paginaAtual <= 1;
         btnProximo.disabled = data.quadras.length < limitePorPagina;
      }


      function cadastrarQuadra() {
    // Redireciona para a página de cadastro
    window.location.href = 'adicionar_quadra.html';
}

      function verDetalhes(id) {
    window.location.href = `detalhes_quadra.php?id=${id}`;
}

      document.addEventListener('DOMContentLoaded', () => {
         carregarQuadras();
      });




///////Função buscar quadras proximas //////////////////////////////////////////////////////////////////////////////

function buscarPorLocalizacao() {
    if (navigator.geolocation) {
        // Mostrar loading
        const carousel = document.querySelector('#quadras-carousel');
        carousel.innerHTML = '<div class="item" style="text-align: center; padding: 50px;"><p>📍 Buscando quadras próximas...</p></div>';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const raio = 5000; // 5km
                
                // Armazenar coordenadas para paginação (variáveis globais)
                ultimaLatitude = lat;
                ultimaLongitude = lng;
                
                // Resetar para página 1 
                paginaAtual = 1;
                zonaAtual = 'proximidade';
                
                // Fazer a requisição para API com coordenadas
                const url = `api_quadras_pg.php?lat=${lat}&lng=${lng}&raio=${raio}&pagina=${paginaAtual}&limite=${limitePorPagina}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            console.error('Erro:', data.mensagem);
                            alert('Erro ao buscar quadras próximas: ' + data.mensagem);
                            carregarQuadras(zonaAtual, paginaAtual);
                            return;
                        }

                        todasQuadras = data.quadras;
                        exibirQuadras(data.quadras);
                        
                        // Atualizar paginação para modo proximidade
                        document.getElementById('info-pagina').textContent = `Página ${paginaAtual} (📍 Próximas)`;
                        
                        const btnAnterior = document.getElementById('btn-anterior');
                        const btnProximo = document.getElementById('btn-proximo');
                        
                        btnAnterior.disabled = paginaAtual <= 1;
                        btnProximo.disabled = data.quadras.length < limitePorPagina;
                        
                        // Configurar eventos de paginação com coordenadas persistentes
                        btnAnterior.onclick = function() { 
                            if (paginaAtual > 1) {
                                paginaAtual--;
                                carregarQuadrasProximasPersistente(paginaAtual);
                            }
                        };
                        
                        btnProximo.onclick = function() { 
                            if (data.quadras.length >= limitePorPagina) {
                                paginaAtual++;
                                carregarQuadrasProximasPersistente(paginaAtual);
                            }
                        };
                    })
                    .catch(error => {
                        console.error('Erro ao carregar quadras próximas:', error);
                        alert('Erro ao conectar com o servidor.');
                        carregarQuadras(zonaAtual, paginaAtual);
                    });
            },
            function(error) {
                let mensagemErro = 'Não foi possível obter sua localização. ';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        mensagemErro += 'Permissão de localização negada.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        mensagemErro += 'Localização indisponível.';
                        break;
                    case error.TIMEOUT:
                        mensagemErro += 'Tempo de busca expirado.';
                        break;
                    default:
                        mensagemErro += 'Erro desconhecido.';
                        break;
                }
                
                alert(mensagemErro);
                carregarQuadras(zonaAtual, paginaAtual);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    } else {
        alert('Geolocalização não é suportada pelo seu navegador.');
        carregarQuadras(zonaAtual, paginaAtual);
    }
}

// Função auxiliar para carregar quadras próximas com coordenadas persistentes
function carregarQuadrasProximasPersistente(pagina) {
    if (!ultimaLatitude || !ultimaLongitude) {
        alert('Localização não disponível para paginação.');
        return;
    }
    
    const raio = 5000;
    const url = `api_quadras_pg.php?lat=${ultimaLatitude}&lng=${ultimaLongitude}&raio=${raio}&pagina=${pagina}&limite=${limitePorPagina}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                console.error('Erro:', data.mensagem);
                return;
            }

            todasQuadras = data.quadras;
            exibirQuadras(data.quadras);
            
            document.getElementById('info-pagina').textContent = `Página ${pagina} (📍 Próximas)`;
            
            const btnAnterior = document.getElementById('btn-anterior');
            const btnProximo = document.getElementById('btn-proximo');
            
            btnAnterior.disabled = pagina <= 1;
            btnProximo.disabled = data.quadras.length < limitePorPagina;
        })
        .catch(error => {
            console.error('Erro ao carregar quadras próximas:', error);
        });
}
      


//////Fim da Função buscar quadras proximas ////////////////////////////////////////////////////////




      </script>
   </body>
</html>