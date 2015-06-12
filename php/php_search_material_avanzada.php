<?php

//comprobamos que ha generado la consulta: la pagina cargada o una busqueda
if (isset($_REQUEST['buscar'])) {
    //SI ES UNA BUSQUEDA COMPROBAMOS QUE ITEMS HAN SIDO RELLENADOS
    if (!isset($_REQUEST['consulta']) && !isset($_REQUEST['precio1']) && !isset($_REQUEST['precio2']) && empty($_REQUEST['consulta']) && empty($_REQUEST['precio1']) && empty($_REQUEST['precio2'])) {
        //SI ESTOS 3 NO HAN SIDO RELLENADOS MENSAJE DE ERROR (2 OPCIONES WINDOW ALERT O MENSAJE BONITO)
        echo "<script type=\"text/javascript\">alert(\"DEBE RELLENAR AL MENOS UNO DE LOS CAMPOS DE LA BUSQUEDA .\");</script>";
    } else {
        $select = "SELECT DISTINCT title,description,precio,id_material,filenamephoto ";
        $from = "FROM material m,categoria c WHERE ";
        $where = "";
        $numero = 0;
        $categoria = $_REQUEST['categoria'];
        //PREPARAR LA CONSULTA
        if (isset($_REQUEST['consulta'])) {
            $consulta = $_REQUEST['consulta'];
            if ($consulta <> '') {
                if (strlen($consulta) < 3) {
                    echo "<script type=\"text/javascript\">alert(\"LA LONGITUD MINIMA DE LA BUSQUEDA ES DE 3 LETRAS .\");</script>";
                }
                $trozos = explode(" ", $consulta);
                $numero = count($trozos);
            }
            if ($numero == 1) {
                //CASO 1 PALABRA USAMOS LIKE EN EL WHERE
                $select = "SELECT DISTINCT title,description,precio,id_material,filenamephoto ";
                $where = "((title LIKE '%$consulta%' OR description LIKE '%$consulta%')) ";
            } else {
                //CASO +1 PALABRA USAMOS MATCH AGAINST AQUI MODIFICAMOS LA SELECT Y EL WHERE
                $select = "SELECT title,description,precio,id_material,filenamephoto, MATCH (title,description) AGAINST ('$consulta') AS puntuacion ";
                $where = "MATCH ( title, description ) AGAINST( '$consulta' ) ORDER BY puntuacion DESC";
            }
        }
        //PREPARAR PRECIO MINIMO
        if (isset($_REQUEST['precio1'])) {
            $precio1 = $_REQUEST['precio1'];
            if ($precio1 <> '') {
                $precio1 = str_replace(",", ".", $precio1);
            } else {
                $precio1 = "0.0";
            }
        }
        //PREPARAR PRECIO MAXIMO
        if (isset($_REQUEST['precio2'])) {
            $precio2 = $_REQUEST['precio2'];
            if ($precio2 <> '') {
                $precio2 = str_replace(",", ".", $precio2);
            } else {
                $sql = "SELECT MAX(precio) FROM material";
                $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
                mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
                mysql_query("SET NAMES 'utf8'");
                $resultado = mysql_query($sql, $conexion) or die("Error en: $query: " . mysql_error());
                $dato = mysql_fetch_array($resultado);
                if (mysql_num_rows($resultado) <> 0) {
                    $precio2 = $dato[0];
                }
                mysql_close($conexion);
            }
        }

        if ($precio1 > $precio2) {
            //echo" <div class=\"alert alert-danger\"><strong>ERROR: </strong>El campo precio Desde no puede ser mayor que el campo Hasta</div>";
            echo "<script type=\"text/javascript\">alert(\"EL CAMPO PRECIO DESDE NO PUEDE SER MAYOR QUE EL CAMPO HASTA .\");</script>";
        }
        // PREPARACION DE LA CATEGORIA
        if ($categoria <> 'Cualquiera') {
            $consultacategoria = "AND c.nombre = '$categoria' AND m.id_categoria=c.id_categoria";
        } else {
            $consultacategoria = '';
        }
        //CASO DE QUE NO HAY PALABRAS A BUSCAR
        if ($numero == 0) {
            $query = "SELECT DISTINCT title,description,precio,id_material,filenamephoto FROM material m,categoria c  WHERE precio BETWEEN " . $precio1 . " AND " . $precio2 . " AND state='aprobado' " . $consultacategoria . " AND vendido=0 ORDER BY fecha_subida";
        } elseif ($numero == 1) {
            $query = $select . $from . " precio BETWEEN " . $precio1 . " AND " . $precio2 . " AND state='aprobado' " . $consultacategoria . " AND ((title LIKE '%$consulta%' OR description LIKE '%$consulta%')) AND vendido=0";
        } else {
            $query = $select . $from . " precio BETWEEN " . $precio1 . " AND " . $precio2 . " AND state='aprobado' " . $consultacategoria . " AND MATCH ( title, description ) AGAINST( '$consulta' )AND vendido=0 ORDER BY puntuacion DESC";
        }
    }
} else {
    //EN EL CASO DE QUE SEA LA CARGA DE LA PAGINA CARGA LOS ULTIMOS MATERIALES SUBIDOS
    $query = "SELECT title,description,precio,id_material,filenamephoto FROM material  WHERE state='aprobado' AND vendido=0 ORDER BY fecha_subida";
}
$conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
mysql_query("SET NAMES 'utf8'");
//EJECUTAMOS LA CONSULTA
$resultado = mysql_query($query, $conexion) or die("Error en: $query: " . mysql_error());
//OBTENEMOS EL NUMERO DE FILAS OBTENIDAS
$cuentafilas = mysql_num_rows($resultado);
$carrito = array();
if (isset($_SESSION['s_username'])) {
    $consultacarro = "SELECT id_material from cesta where id_user=" . $_SESSION['s_id'] . "";
    $rescarro = mysql_query($consultacarro, $conexion) or die("Error en: $query: " . mysql_error());
    $cuentafilascarro = mysql_num_rows($resultado);
    if ($cuentafilascarro > 0) {
        while ($resc = mysql_fetch_array($rescarro)) {
            array_push($carrito, $resc[0]);
        }
    }
}
if ($cuentafilas > 0) {
    //SI HEMOS OBTENIDO RESULTADOS DIBUJAMOS LA TABLA
    echo '<table class="table col-md-12">';
    echo '<tbody>';
    while ($dato = mysql_fetch_array($resultado)) {
        //POR CADA RESULTADO MODAL
        echo '<div class="modal fade" id="myModalAgregarRegLogin' . $dato[3] . '" tabindex="-1" role="dialog" aria-labelledby="myCompraLabel" aria-hidden="true">';
        echo '  <div class="modal-dialog">';
        echo '      <div class="modal-content">';
        echo '          <div class="modal-header">';
        echo '              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        echo '              <h4 class="modal-title">Registrate o haz login para continuar</h4>';
        echo '          </div>';
        echo '          <div class="modal-body">';
        echo '              <div id="parteLogin"> ';
        echo '                  <form id="loginFormC" method="post" class="form-horizontal">';
        echo '                      <div class="form-group">';
        echo '                          <label>Username</label>';
        echo '                          <input type="text" class="form-control" id="usernamea" name="usernamea" required>';
        echo '                      </div>';
        echo '                      <div class="form-group">';
        echo '                          <label>Password</label>';
        echo '                          <input type="password" class="form-control" id="passworda" name="passworda" required>';
        echo '                      </div>';
        echo '                      <div class="modal-footer">';
        echo '                          <div class="col-sm-5 col-sm-offset-3">';
        echo '                              <button type="submit" id="loginagregar" name="loginagregar" class="btn btn-warning btn-lg" style="width: 100%;" value="' . $dato[3] . '" style="width: 100%;">Login</button>';
        echo '                          </div>';
        echo '                      </div>';
        echo '                  </form>';
        echo '              </div>';
        echo '              <div id="parteRegistrar">';
        echo '                  <form method="post"  enctype="multipart/form-data">';
        echo '                      <div class="form-group">';
        echo '                          <label>Username</label>';
        echo '                          <input class="form-control" id="usernamear" name="usernamear" type="text" required>';
        echo '                      </div>';
        echo '                      <div class="form-group">';
        echo '                          <label >Email</label>';
        echo '                          <input class="form-control" id="emailar" name="emailar" type="email" required>';
        echo '                      </div>';
        echo '                      <div class="form-group">';
        echo '                          <label>Contrase&ntilde;a</label>';
        echo '                          <input class="form-control" id="passwdar" name="passwdar" type="password" required>';
        echo '                      </div>';
        echo '                      <div class="form-group">';
        echo '                          <label>Confirmar Contrase&ntilde;a</label>';
        echo '                          <input class="form-control" id="confirmpasswdar" name="confirmpasswdar" type="password" required>';
        echo '                      </div>';
        echo '                      <div class="modal-footer">';
        echo '                          <button type="submit" id="registraragregar" name="registraragregar" value="' . $dato[3] . '" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Registrar</button>';
        echo '                      </div>';
        echo '                  </form>';
        echo '              </div>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        //POR CADA RESULTADO CREAMOS UNA FILA DE LA TABLA CON:
        echo '<tr>';
        echo '  <td class="col-sm-8 col-md-4">';
        echo '      <div class="media" style="margin-top: 20px;">';
        echo '          <a class="thumbnail pull-left"> <img class="media-object" src="./mat_photo/' . $dato[4] . '" style="width: 72px; height: 90px;"> </a>';
        echo '          <div class="media-body" style="margin-top: 30px;">';
        echo '              <h4 class="media-heading">T&iacute;tulo: <h4 style="color:#000000">' . $dato[0] . '</h4>';
        echo '          </div>';
        echo '      </div>';
        echo '  </td>';
        echo '  <td class="col-sm-8 col-md-6">';
        echo '      <h5 style="margin-top: 50px;">Descripción: <h5 style="color:#000000">' . $dato[1] . '</h5>';
        echo '  </td>';
        echo '  <td class="col-sm-8 col-md-6">';
        echo '      <h5 style="margin-top: 50px;">Precio: <h5 style="color:#000000">' . $dato[2] . '&euro;</h5>';
        echo '  </td>';
        if (isset($_SESSION['s_username'])) {
            if (in_array($dato[3], $carrito)) {
                echo '<td class="col-sm-8 col-md-6">';
                echo '  <form method="post">';
                echo '      <button type="submit" id="agregar" name="agregar"  class="btn btn-success disabled" style="margin-top: 40px;" value="' . $dato[3] . '"><span class="glyphicon glyphicon-shopping-cart"></span>Añadir al carro</button>';
                echo '      <BR>';
                echo '  </form>';
                echo '</td>';
            } else {
                echo '<td class="col-sm-8 col-md-6">';
                echo '  <form method="post">';
                echo '      <button type="submit" id="agregar" name="agregar"  class="btn btn-success" style="margin-top: 40px;" value="' . $dato[3] . '"><span class="glyphicon glyphicon-shopping-cart"></span>Añadir al carro</button>';
                echo '      <BR>';
                echo '  </form>';
                echo '</td>';
            }
        } else {
            echo '<td class="col-sm-8 col-md-6">';
            echo '  <button type="button" id="agregarnoreg" name="agregarnoreg"  class="btn btn-success" data-toggle="modal" data-target="#myModalAgregarRegLogin' . $dato[3] . '" style="margin-top: 40px;" value="' . $dato[3] . '"><span class="glyphicon glyphicon-shopping-cart"></span>Añadir al carro</button>';
            echo '  <BR>';
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "<script type=\"text/javascript\">alert(\"NO SE HAN ENCONTRADO COINCIDENCIAS PARA LA BUSQUEDA .\");</script>";
}
?>