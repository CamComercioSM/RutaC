<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ruta de Crecimiento - Mantenimiento</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Aseguramos que html y body ocupen el 100% del alto */
    html, body {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
      overflow: hidden;
    }

    /* Fondo animado con gradiente */
    .background-animation {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      background: linear-gradient(-45deg, #0c1892, #1a1a1a, #0c1892, #1a1a1a);
      background-size: 400% 400%;
      animation: gradientBG 10s ease infinite;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Div para el fondo animado con Particles.js */
    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 2;
      top: 0;
      left: 0;
    }

    /* Contenedor del contenido que se muestra sobre el fondo animado */
    .content {
      position: relative;
      z-index: 3;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    /* Tarjeta de mantenimiento con fondo semitransparente */
    .card-maintenance {
      background: rgba(0, 0, 0, 0.75);
      border: none;
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    .card-maintenance img {
      width: 180px;
      margin-bottom: 20px;
    }

    .card-maintenance h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: #ffffff;
    }

    .card-maintenance p {
      font-size: 1.2rem;
      color: #ddd;
    }

    .card-maintenance a {
      color: #00bfff;
      text-decoration: none;
    }

    .card-maintenance a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Fondo animado con gradiente -->
  <div class="background-animation"></div>

  <!-- Fondo animado con partículas -->
  <div id="particles-js"></div>

  <!-- Contenido de mantenimiento -->
  <div class="content">
    <div class="card-maintenance">
      <!-- Logo de la Cámara de Comercio de Santa Marta -->
      <img src="https://cdnsicam.net/img/rutac/rutac_blanco.png" alt="Ruta de Crecimiento - Cámara de Comercio de Santa Marta" />
      <h1>Sitio en Mantenimiento</h1>
      <p>
        En Ruta de Crecimiento, un programa de crecimiento empresarial gestionado por la Cámara de Comercio de Santa Marta para el Magdalena, estamos actualizando nuestros servicios para brindarte una mejor experiencia.
      </p>
      <p>
        Por favor, vuelve a intentarlo más tarde. ¡Gracias por tu paciencia!
      </p>
      <p>
        Para más información, visita <a href="https://www.ccsm.org.co" target="_blank">www.ccsm.org.co</a>
      </p>
    </div>
  </div>

  <!-- Particles.js Library -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    /* Configuración de Particles.js */
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 80,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#ffffff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          }
        },
        "opacity": {
          "value": 0.5,
          "random": false
        },
        "size": {
          "value": 3,
          "random": true
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 2,
          "direction": "none",
          "random": false,
          "straight": false,
          "out_mode": "out"
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "repulse"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          }
        },
        "modes": {
          "repulse": {
            "distance": 100,
            "duration": 0.4
          },
          "push": {
            "particles_nb": 4
          }
        }
      },
      "retina_detect": true
    });
  </script>

  <!-- Bootstrap JS (opcional, si necesitas funcionalidades JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>