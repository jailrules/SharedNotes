<?php

if (isset($_SESSION['s_username'])) {
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT COUNT(*) FROM cesta,material WHERE cesta.id_user=\"" . $_SESSION['s_id'] . "\" AND cesta.id_material=material.id_material AND material.vendido=1";
    $result = mysql_query($query, $conexion) or die(mysql_error());
    $vendido = 0;
    if (mysql_result($result, 0) > 0) {
        $vendido = 1;
    }
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT material.title,material.precio,material.id_material,material.filenamephoto,material.vendido FROM cesta,material WHERE cesta.id_user=\"" . $_SESSION['s_id'] . "\" AND cesta.id_material=material.id_material";
    $result = mysql_query($query, $conexion);
    if (mysql_num_rows($result) > 0) {
        //CARRITO LLENO
        echo '<div class="panel-body" >';
        echo '<div id="carro">';
        if ($vendido == 1) {
            echo" <div class=\"alert alert-danger\"><b>ERROR: </b>En tu cesta de la compra tienes productos que ya han sido vendidos eliminalos para poder realizar tu compra!</div>";
        }
        echo '<table class="table col-md-12">';
        echo '<tbody>';
        $total = 0.0;
        while ($rs = mysql_fetch_array($result)) {
            if ($rs[4] == 0) {
                $total+=$rs[1];
            }
            echo '<tr>';
            echo '<td class="col-sm-8 col-md-4">';
            echo '<div class="media">';
            echo '<a class="thumbnail pull-left">'
            . '<img class="media-object" src="./mat_photo/' . $rs[3] . '" style="width: 72px; height: 90px;">';
            echo '</a>';
            echo '<div class="media-body" style="margin-top: 15px;">';
            echo '<h4 class="media-heading">';
            echo '<a>' . $rs[0] . '</a>';
            echo '</h4>';
            echo '<h5 class="media-heading"> por ';
            echo '<a>Universidad Politecnica de Valencia</a>';
            echo '</h5>';
            echo '<span>Estado:</span>';
            if ($rs[4] == 1) {
                echo '<span class="text-danger"><b>Vendido</b></span>';
            } else {
                echo '<span class="text-success"><b>En Stock</b></span>';
            }
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '<td class="col-sm-2 col-md-4 text-center" >';
            echo '<h4 style="margin-top: 35px;">' . $rs[1] . ' €</h4>';
            echo '</td>';
            echo '<td class="col-sm-1 col-md-2">';
            echo '<form method="post">';
            echo '<button type="submit" id="eliminar" name="eliminar" style="margin-top: 30px;" value="' . $rs[2] . '" class="btn btn-danger" onclick = "javascript:window.location=\'php/eliminar.php\'">Quitar<span class="glyphicon glyphicon-remove"></span></button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '<div class="panel-footer">';
        echo '<span class="col-sm-1 col-md-4 text-center"><button class="btn btn-primary btn-lg" id="tienda" onclick ="location=\'material.php\'">SEGUIR COMPRANDO</button></span>';
        if ($vendido == 1) {
            echo '<span class="col-sm-1 col-md-4 text-center"><button id="finalizar" name="finalizar" type="submit" class="btn btn-danger btn-lg disabled" data-toggle="modal" data-target="#myCompra">FINALIZAR LA COMPRA</button></span>';
        } else {
            echo '<span class="col-sm-1 col-md-4 text-center"><button id="finalizar" name="finalizar" type="submit" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myCompra">FINALIZAR LA COMPRA</button></span>';
        }

        echo '<label id="totales" name="totales" class="text-right"><h3><b>Total: ' . $total . ' €<b></h3></label>';
        echo '</div>';
    } else {
        //CARRITO VACIO
        echo '<div class="panel-body" >';
        echo '<span class="col-sm-1 col-md-4 text-center"><strong>No has comprado nada hasta ahora, empieza ya!</strong></span>';
        echo '<span class="col-sm-1 col-md-4 text-center"><button class="btn btn-primary btn-lg" id="tienda" onclick ="location=\'material.php\'">VISITA LA TIENDA</button></span>';
        echo '</div>';
    }
} else {
    if (isset($_SESSION['carro[]'])) {
        $vendido = false;
        if (count($_SESSION['carro[]']) > 0) {
            $carro = $_SESSION['carro[]'];
            $count = count($_SESSION['carro[]']);
            echo '<div class="panel-body" >';
            echo '<div id="carro">';
            foreach ($carro as $id) {
                $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
                mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
                mysql_query("SET NAMES 'utf8'");
                $query = "SELECT vendido FROM material WHERE id_material=" . $id . "";
                $result = mysql_query($query, $conexion);
                while ($rs = mysql_fetch_array($result)) {
                    if (mysql_result($result, 0) > 0) {
                        $vendido = true;
                    }
                }
            }
            if ($vendido) {
                echo" <div class=\"alert alert-danger\"><b>ERROR: </b>En tu cesta de la compra tienes productos que ya han sido vendidos eliminalos para poder realizar tu compra!</div>";
            }
            echo '<table class="table col-md-12">';
            echo '<tbody>';
            $total = 0.0;
            foreach ($carro as $id) {
                $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
                mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
                mysql_query("SET NAMES 'utf8'");
                $query = "SELECT title,precio,id_material,filenamephoto,vendido FROM material WHERE id_material=" . $id . "";
                $result = mysql_query($query, $conexion);
                while ($rs = mysql_fetch_array($result)) {
                    if ($rs[4] == 0) {
                        $total+=$rs[1];
                    }
                    echo '<tr>';
                    echo '<td class="col-sm-8 col-md-4">';
                    echo '<div class="media">';
                    echo '<a class="thumbnail pull-left" href="#"> <img class="media-object" src="./mat_photo/' . $rs[3] . '" style="width: 72px; height: 90px;"> </a>';
                    echo '<div class="media-body" style="margin-top: 15px;">';
                    echo '<h4 class="media-heading"><a href="#">' . $rs[0] . '</a></h4>';
                    echo '<h5 class="media-heading"> por <a href="#">Universidad Politecnica de Valencia</a></h5>';
                    if ($rs[4] == 1) {
                        echo '<span class="text-danger"><b>Vendido</b></span>';
                    } else {
                        echo '<span class="text-success"><b>En Stock</b></span>';
                    }
                    echo '</div>';
                    echo '</div></td>';
                    echo '<td class="col-sm-2 col-md-4 text-center" ><h4 style="margin-top: 35px;"><strong>' . $rs[1] . ' €</h4></strong></td>';
                    echo '<td class="col-sm-1 col-md-2">';
                    echo '<form method="post">';
                    echo '<button type="submit" id="eliminar" name="eliminar" style="margin-top: 30px;" value="' . $rs[2] . '" class="btn btn-danger" onclick = "javascript:window.location=\'php/eliminar.php\'">Quitar<span class="glyphicon glyphicon-remove" ></span></button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                mysql_close($conexion);
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '<div class="panel-footer">';
            echo '<span class="col-sm-1 col-md-4 text-center"><button class="btn btn-primary btn-lg" id="tienda" onclick ="location=\'material.php\'">SEGUIR COMPRANDO</button></span>';
            if ($vendido) {
                echo '<span class="col-sm-1 col-md-4 text-center"><button id="finalizar" name="finalizar" type="submit" class="btn btn-danger btn-lg disabled" data-toggle="modal" data-target="#ModalRegister">FINALIZAR LA COMPRA</button></span>';
            } else {
                echo '<span class="col-sm-1 col-md-4 text-center"><button id="finalizar" name="finalizar" type="submit" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#ModalRegister">FINALIZAR LA COMPRA</button></span>';
            }
            echo '<label id="totales" name="totales" class="text-right"><h3><b>Total: ' . $total . ' €<b></h3></label>';
            echo '</div>';
        } else {
            echo '<div class="panel-body" >';
            echo '<span class="col-sm-1 col-md-4 text-center"><b>No has comprado nada hasta ahora, empieza ya!</b></span>';
            echo '<span class="col-sm-1 col-md-4 text-center"><button class="btn btn-primary btn-lg" id="tienda" onclick ="location=\'material.php\'">VISITA LA TIENDA</button></span>';
            echo '</div>';
        }
    } else {
        echo '<div class="panel-body" >';
        echo '<span class="col-sm-1 col-md-4 text-center"><strong>No has comprado nada hasta ahora, empieza ya!</strong></span>';
        echo '<span class="col-sm-1 col-md-4 text-center"><button class="btn btn-primary btn-lg" id="tienda" onclick ="location=\'material.php\'">VISITA LA TIENDA</button></span>';
        echo '</div>';
    }
}
?>




