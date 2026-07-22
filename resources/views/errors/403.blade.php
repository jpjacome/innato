<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso denegado</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; display: flex; align-items: center; justify-content: center; min-height: 100vh; color: #333; }
        .container { text-align: center; padding: 2rem; }
        h1 { font-size: 6rem; font-weight: 700; color: #f59e0b; line-height: 1; }
        h2 { font-size: 1.5rem; margin: 1rem 0; color: #555; }
        p { color: #777; margin-bottom: 2rem; }
        a { display: inline-block; padding: 0.75rem 2rem; background: #4F46E5; color: #fff; text-decoration: none; border-radius: 0.5rem; transition: background 0.2s; }
        a:hover { background: #4338CA; }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <h2>Acceso denegado</h2>
        <p>No tienes permiso para acceder a esta página.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</body>
</html>
