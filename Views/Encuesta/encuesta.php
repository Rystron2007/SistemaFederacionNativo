<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['tag_page'] ?></title>
    <?php require_once "includes/head.php";?>
</head>
<body>
<div class="contenedor_body">
    <!--Llamado al archivo header que contiene la cabecera del Sistema,
    junto con el Nav para todas las páginas-->
    <div>
        <!--Div para separar el Header y Nav-->
    <?php require_once "includes/header.php"?>
    </div>
    
    <div class="contenido_Inicio">
        <!--Div para separar el Main y Contenido de la página-->
        <!--Div para separar el Main y Contenido de la página-->
        <h1><?php echo $data['page_title']; ?></h1>



    </div>
    
    </div>
    <!--LLamado del Footer de la Pagina Web-->
    <?php require_once "includes/footer.php"?>
    <!--Llamado al archivo de Scripts e incorporarlo en las páginas-->
    <?php require_once "includes/scripts.php"?>
</body>
</html>