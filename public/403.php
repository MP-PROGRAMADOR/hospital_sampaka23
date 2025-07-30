<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>403 - Acceso Denegado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f6f8fb, #e9eff5);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      color: #333;
    }

    .box {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      text-align: center;
      max-width: 420px;
      width: 90%;
      animation: fadeIn 0.6s ease-in-out;
    }

    h1 {
      color: #e74c3c;
      font-size: 2.2em;
      margin-bottom: 15px;
    }

    p {
      font-size: 1.1em;
      margin-bottom: 25px;
      color: #555;
    }

    a {
      display: inline-block;
      padding: 12px 24px;
      background-color: #3498db;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    a:hover {
      background-color: #2980b9;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .box {
        padding: 30px 20px;
      }

      h1 {
        font-size: 1.8em;
      }

      p {
        font-size: 1em;
      }
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>403 - Acceso Denegado</h1>
    <p>No tienes permiso para acceder a esta carpeta.</p>
    <a href="index.php?pagina=404">Volver al inicio</a>
  </div>
</body>
</html>
