<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/rss.png" type="image/x-icon">
    <title>Lector de feeds</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <!--formulario para añadir la URL a leer-->
    <div class=align>
        <form method="POST" action="">
            <input type="text" name="feedurl" placeholder="Escribe el feeds">&nbsp;<input type="submit" value="Enviar" name="submit">
        </form>
    <?php
    //URL a leer por defecto
    $url = "http://feeds.weblogssl.com/xataka2";
    if(isset($_POST['submit'])){
        if($_POST['feedurl'] != ''){
            $url = $_POST['feedurl'];
        }
    }
    $invalidurl = false;
    //Comprobamos si la URL es correcta. 
    if(@simplexml_load_file($url)){
        $feeds = simplexml_load_file($url);
    }else{
        $invalidurl = true;
        echo '<h2>URL de feed RSS incorrecto.</h2>';
        echo '<h3>No te olvides de incluir el protocolo http(s)</h3>';
    }
    $i=0;
    //Comprobamos si la URL está vacía. Continúa si no está vacía. De lo contrario pasa al else.
    if(!empty($feeds)){
        //Descripción del canal
        $site = $feeds->channel->title;
        $sitelink = $feeds->channel->link;
        echo "<div class= align>";
            echo '<h1>'.$site.'</h1>';
        echo "</div>";
        //Por cada noticia:
        foreach ($feeds->channel->item as $item) {
            //Creamos variables con información de la noticia
            $title = $item->title;
            $link = $item->link;
            $description = $item->description;
            $postDate = $item->pubDate;
            $pubDate = date('D, d M Y',strtotime($postDate));
            if($i>=3) break; //3 es el número de noticias a mostrar
    
            //Mostramos información por pantalla de la noticia
    echo '<div>';
        //Título de la noticia
        echo "<div class=two-column>";
            echo "<div>";
                echo '<h2 class=row two-colum><a href="'.$link.'">'.$title.'</a></h2>';
                echo '<span class=row two-colum>'.$pubDate.'</span>';
            echo '</div>';
        echo "</div>";
                //Cuerpo de la noticia
                echo '<div class=row>';
                //echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "...";
                echo '<div class=imagen two-colum>'.$description.'</div>';
                echo '<a href="'.$link.'">Leer más</a>';
                echo '</div>';
                echo '</div>';
                $i++;
            echo "</div>";
        echo "</div>";

        }
    }else{
        //Error que se muestra si no hay nada que mostrar
        if(!$invalidurl){
            echo '<h2>No se encontró nada que mostrar</h2>';
        }
    }
    ?>
    </div>
</body>
</html>