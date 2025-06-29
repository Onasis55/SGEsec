<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Error 401 - No autorizado</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 480px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(8px);
        }
        h1 {
            font-size: 6rem;
            margin: 0;
            font-weight: 700;
            letter-spacing: 8px;
        }
        h2 {
            font-weight: 400;
            margin: 20px 0 30px;
            font-size: 1.5rem;
        }
        p {
            font-size: 1rem;
            margin-bottom: 30px;
            color: #e0e0e0;
        }
        a.button {
            display: inline-block;
            padding: 12px 30px;
            font-weight: 700;
            font-size: 1rem;
            color: #764ba2;
            background: #fff;
            border-radius: 30px;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
        }
        a.button:hover {
            background: #5a3790;
            color: #fff;
            box-shadow: 0 6px 20px rgba(90, 55, 144, 0.7);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>401</h1>
    <h2>No autorizado</h2>
    <p>No tienes permiso para acceder a esta página. Por favor, inicia sesión o contacta al administrador.</p>
    <a href="/dashboard" class="button">Iniciar sesión</a>
</div>
</body>
</html>
