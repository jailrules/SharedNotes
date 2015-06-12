<?php

$conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
//comprobamos que ha generado la consulta: la pagina cargada o una busqueda
if (isset($_REQUEST['buscar'])) {
    //SI ES UNA BUSQUEDA
    if (isset($_REQUEST['busqueda'])) {
        $consulta = $_REQUEST['busqueda'];
        // DEBO PREPARAR LOS TEXTOS QUE VOY A BUSCAR si la cadena existe
        if ($consulta <> '') {
            if (strlen($consulta) < 3) {
                echo "<script type=\"text/javascript\">alert(\"LA LONGITUD MINIMA DE LA BUSQUEDA ES DE 3 LETRAS .\");</script>";
            }
            //CUENTA EL NUMERO DE PALABRAS
            $trozos = explode(" ", $consulta);
            $numero = count($trozos);
            if ($numero == 1) {
                //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
                mysql_query("SET NAMES 'utf8'");
                $query = "SELECT DISTINCT title,username,description,filename FROM apunte,user WHERE "
                        . "(title LIKE '%$consulta%' OR description LIKE '%$consulta%') "
                        . "AND apunte.author = user.id_user AND state='aprobado' ORDER BY fecha_subida DESC LIMIT 50";
            } elseif ($numero > 1) {
                //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
                //busqueda de frases con mas de una palabra y un algoritmo especializado
                mysql_query("SET NAMES 'utf8'");
                $query = "SELECT title,username,description,filename, MATCH (title,description) AGAINST ('$consulta') AS puntuacion "
                        . "FROM apunte,user WHERE "
                        . "MATCH ( title, description ) AGAINST( '$consulta' ) AND "
                        . "apunte.author = user.id_user AND state='aprobado' ORDER BY puntuacion LIMIT 50";
            } else {
                echo "<a>MENSAJE DE ERROR</a>";
            }
        } else {
            echo "<script type=\"text/javascript\">alert(\"DEBE RELLENAR AL MENOS EL CAMPO DE LA BUSQUEDA .\");</script>";
        }
    }
} else {
    //EN EL CASO DE QUE SEA LA CARGA DE LA PAGINA CARGA LOS ULTIMOS APUNTES SUBIDOS
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT title,username,description,filename FROM apunte,user WHERE "
            . "apunte.author=user.id_user AND state='aprobado' ORDER BY valoracion DESC";
}

//EJECUTAMOS LA CONSULTA
$resultado = mysql_query($query, $conexion) or die("Error en: $query: " . mysql_error());
//OBTENEMOS EL NUMERO DE ROWS OBTENIDAS
$cuentafilas = mysql_num_rows($resultado);
if ($cuentafilas > 0) {
    //SI HEMOS OBTENIDO RESULTADOS DIBUJAMOS LA TABLA
    echo '<table class="table col-md-12">';
    echo '<tbody>';
    while ($dato = mysql_fetch_array($resultado)) {
        //POR CADA RESULTADO CREAMOS UNA FILA DE LA TABLA CON:
        echo '<tr>';
        echo '<td class="col-sm-8 col-md-5">';
        echo '<div class="media" style="margin-top: 20px;">';
        echo '<a class="thumbnail pull-left"> <img class="media-object" src="./src/mmmm.png" style="width: 72px; height: 72px;"> </a>';
        echo '<div class="media-body" style="margin-top: 15px;">';
        echo '<h4 class="media-heading">T&iacute;tulo: <br>' . $dato[0] . '</h4>';
        echo '<h5 class="media-heading">por: ' . $dato[1] . '</h5>';
        echo '</div>';
        echo '</div>';
        echo '</td>';

        echo '<td class="col-sm-8 col-md-5">';
        echo '<h5 style="margin-top: 35px;">Descripción: ' . $dato[2] . '</h5>';
        echo '</td>';

        echo '<td class="col-sm-8 col-md-6">';
        echo '<form method="get" target="_self" action="/php/descargar.php?archivo">';
        echo '<button type="submit" id="descargar" name="archivo" class="btn btn-danger" style="margin-top: 30px;" value="' . $dato[3] . '">Descargar</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "<script type=\"text/javascript\">alert(\"NO SE HAN ENCONTRADO COINCIDENCIAS PARA LA BUSQUEDA .\");</script>";
}

?>