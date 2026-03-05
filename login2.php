<!DOCTYPE html>
<!-- Meta tags for better compatibility and SEO -->
<meta name="description" content="Plataforma segura de autenticación">
<meta name="theme-color" content="#667eea">
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mi Página</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .login-header p {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .login-form {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f9f9f9;
            border-top: 1px solid #e0e0e0;
        }
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🔐 Bienvenido</h1>
            <p>Inicia sesión en tu cuenta</p>
        </div>
        <form class="login-form" action="verificacion.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="tu@email.com" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-login">Iniciar Sesión</button>
        </form>
        <div class="login-footer">
            <p>¿No tienes cuenta? <a href="#">Regístrate aquí</a></p>
            <p><a href="#">¿Olvidaste tu contraseña?</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
    // Añade animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.login-container');
        container.style.animation = 'slideIn 0.6s ease-out';
    });
</script>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-container {
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .form-control::placeholder {
        color: #999;
        opacity: 0.7;
    }

    .btn-login {
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .login-footer p {
        margin: 8px 0;
        font-size: 0.9rem;
        color: #666;
    }

    .form-group input:valid {
        border-color: #28a745;
    }
</style>