<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Hospital Regional de Sampaka</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0f7fa, #ffffff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-wrapper {
      display: flex;
      width: 100%;
      max-width: 100vw;
      min-height: 100vh;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    }

    .login-image {
      flex: 1;
      background: url('img/portal.jpg') center center no-repeat;
      background-size: cover;
      position: relative;
      overflow: hidden;
    }

    .carousel-caption {
      background: rgba(0, 0, 0, 0.5);
      padding: 1.5rem;
      border-radius: 10px;
      animation: fadeInUp 1s ease-in-out;

    }

    .carousel-caption h5 {
      font-size: 1.4rem;
      font-weight: 600;
      color: #fff;
    }

    .login-form {
      flex: 1;
      padding: 3rem 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #ffffffee;
    }

    .card {
      width: 100%;
      max-width: 420px;
      border: none;
      border-radius: 1rem;
      background: #ffffffcc;
      backdrop-filter: blur(8px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.6s ease-in-out;
    }

    .hospital-logo {
      width: 70px;
      margin-bottom: 1rem;
    }

    .card-title {
      color: #00695c;
      font-weight: 700;
    }

    .btn-login {
      background-color: #00796b;
      color: #fff;
      font-weight: 600;
      transition: all 0.3s ease-in-out;
    }

    .btn-login:hover {
      background-color: #004d40;
      transform: scale(1.02);
    }

    .form-control:focus {
      border-color: #26a69a;
      box-shadow: 0 0 0 0.25rem rgba(38, 166, 154, 0.25);
    }

    .input-group-text {
      background-color: #f1f1f1;
    }

    .toggle-password {
      cursor: pointer;
      transition: color 0.2s;
    }

    .toggle-password:hover {
      color: #00796b;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
      }

      .login-image {
        height: 200px;
      }

      .carousel-caption {
        font-size: 1rem;
        padding: 1rem;
      }

      .login-form {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-wrapper">
    <!-- Imagen con carrusel superpuesto -->
    <div class="login-image d-flex align-items-center justify-content-center text-white text-center">
      <div id="motivationalCarousel" class="carousel slide w-100 h-100 position-absolute" data-bs-ride="carousel">
        <div class="carousel-inner h-100 d-flex align-items-center justify-content-start">
          <div class="carousel-item active">
            <div class="carousel-caption">
              <h5>"La salud es la mayor posesión. Cuídala con sabiduría."</h5>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-caption">
              <h5>"Cada día es una nueva oportunidad para sanar."</h5>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-caption">
              <h5>"Cuidar vidas es nuestra vocación. Bienvenido."</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Formulario de Login -->
    <div class="login-form">
      <div class=" p-4">
        <div class="text-center">
          <img src="img/logo.jpeg" alt="Logo Hospital" class="hospital-logo rounded-circle shadow-sm">
          <h4 class="card-title">Hospital Regional de Sampaka</h4>
          <p class="text-muted">Acceso al sistema</p>
        </div>

        <form id="loginForm"  novalidate>
          <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" id="username" name="usuario" placeholder="Ingrese su usuario"
                required>
            </div>
            <div id="userError" class="form-text text-danger"></div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control" id="password" name="contrasena"
                placeholder="Ingrese su contraseña" required>
              <span class="input-group-text toggle-password" onclick="togglePassword()">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </span>
            </div>
            <div id="passError" class="form-text text-danger"></div>
          </div>

          <div class="d-grid mt-3">
            <button type="submit" class="btn btn-login">
              <i class="bi bi-box-arrow-in-right"></i> Ingresar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>




  <!-- MODAL PARA REGISTRAR EL PRIMER USUARIO SI NO EXISTE -->
<!-- Modal: Confirmar creación de usuario administrador -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Inicializar sistema</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p>No hay usuarios registrados en el sistema.</p>
        <p>¿Deseas crear el usuario administrador <strong>"salvador"</strong>?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnCrearUsuario">Crear administrador</button>
      </div>
    </div>
  </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<!-- Script de Login -->
<script defer>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    toggleIcon.classList.toggle('bi-eye');
    toggleIcon.classList.toggle('bi-eye-slash');
  }

  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('loginForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const userError = document.getElementById('userError');
    const passError = document.getElementById('passError');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Limpiar errores
      userError.textContent = '';
      passError.textContent = '';

      let valid = true;

      if (username.value.trim() === '') {
        userError.textContent = 'Por favor, ingresa tu nombre de usuario.';
        valid = false;
      }

      if (password.value.trim() === '') {
        passError.textContent = 'Por favor, ingresa tu contraseña.';
        valid = false;
      }

      if (!valid) return;

      try {
        const formData = new FormData(form);
        const resp = await fetch("api/login.php", {
          method: "POST",
          body: formData
        });

        const data = await resp.json();

        if (data.success) {
          window.location.href = `${data.ruta}/index.php`;
        } else {
          passError.textContent = data.message || 'Error al iniciar sesión.';
        }
      } catch (err) {
        console.error(err);
        passError.textContent = 'Error de red. Inténtalo más tarde.';
      }
    });
  });
</script>




<!-- SCRIPT PARA INSERTAR EL PRIMER USUARIO 'administrador -->
<script>
document.addEventListener('DOMContentLoaded', async () => {
  try {
    const res = await fetch('puntoAcceso.php?modo=verificar');
    const data = await res.json();

    if (!data.existe) {
      const modal = new bootstrap.Modal(document.getElementById('crearUsuarioModal'));
      modal.show();

      document.getElementById('btnCrearUsuario').addEventListener('click', async () => {
        const crear = await fetch('puntoAcceso.php?modo=crear', { method: 'POST' });
        const crearData = await crear.json();

        alert(crearData.message);
        if (crearData.success) {
          modal.hide();
        }
      });
    }
  } catch (error) {
    console.error('Error al inicializar:', error);
  }
});
</script>

</body>

</html>