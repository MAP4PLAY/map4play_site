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
      </style>
   </head>
   <body>
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
                        <a class="nav-link" href="services_pg.php">Quadras</a>
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

            <div class="service_section_2 layout_padding">
               <div class="owl-carousel owl-theme" id="quadras-carousel">
                  <div class="item" style="text-align: center; padding: 50px;">
                     <p>Carregando quadras...</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="footer_section margin_top90">
         <div class="location_bg">
            <div class="container">
               <div class="location_main">
                  <ul>
                     <li>
                        <a href="#"><img src="images/map-icon.png">
                        <span class="padding_15">São Paulo, SP</span></a>
                     </li>
                     <li>
                        <a href="#"><img src="images/mail-icon.png">
                        <span class="padding_15">map4play@gmail.com</span></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="map_main">
            <div class="map-responsive">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d467692.3958359975!2d-46.92497403286758!3d-23.681434532524257!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce448183a461d1%3A0x9ba94b08ff335bae!2zU8OjbyBQYXVsbywgU1A!5e0!3m2!1spt-BR!2sbr!4v1743395308399!5m2!1spt-BR!2sbr" width="600" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
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

      function carregarQuadras(zona = 'todas') {
         let url = 'api_quadras_pg.php';
         
         if (zona !== 'todas') {
            url += '?zona=' + encodeURIComponent(zona);
         }

         fetch(url)
            .then(response => response.json())
            .then(data => {
               if (data.erro) {
                  console.error('Erro:', data.mensagem);
                  return;
               }

               todasQuadras = data;
               exibirQuadras(data);
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
                  <img src="${quadra.link_foto || 'images/quadra-default.jpg'}" alt="${quadra.nome_quadra}" style="width: 100%; height: 250px; object-fit: cover;" />
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
         
         document.querySelectorAll('.filtros-zona button').forEach(btn => {
            btn.classList.remove('active');
         });
         
         if (zona === 'todas') {
            document.getElementById('btn-todas').classList.add('active');
         } else {
            document.getElementById(`btn-${zona.split(' ')[1].toLowerCase()}`).classList.add('active');
         }

         carregarQuadras(zona);
      }

      function verDetalhes(id) {
         const quadra = todasQuadras.find(q => q.id == id);
         if (quadra) {
            alert(`Detalhes da quadra:\n\n` +
                  `Nome: ${quadra.nome_quadra}\n` +
                  `Endereço: ${quadra.endereco || 'Não informado'}\n` +
                  `Bairro: ${quadra.bairro || 'Não informado'}\n` +
                  `Zona: ${quadra.zona}\n` +
                  `Tipo: ${quadra.tipo_esporte}\n` +
                  `Acessível: ${quadra.acessivel ? 'Sim' : 'Não'}`);
         }
      }

      
      document.addEventListener('DOMContentLoaded', () => {
         carregarQuadras();
      });
      </script>
   </body>
</html>