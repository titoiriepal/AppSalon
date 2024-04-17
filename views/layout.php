<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>

    <div class="contenedor-app">
        <div class="imagen">
            <img src="build/img/1.jpg" alt="Carrusel de fotos del Salón" class="activa">
        </div>

        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    
    <script src="/build/js/app.js"></script>            
</body>
</html>