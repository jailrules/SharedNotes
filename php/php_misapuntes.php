<?php

if (isset($_SESSION['s_username'])) {
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT id_apunte,title,description,valoracion,votos,state, filename FROM apunte WHERE author = " . $_SESSION['s_id'] . "";
    $resultado = mysql_query($query, $conexion) or die("Error en: $query: " . mysql_error());
    $cuentafilas = mysql_num_rows($resultado);
    //SI HEMOS OBTENIDO RESULTADOS DIBUJAMOS LA TABLA
    echo '<h3>Mis Apuntes</h3>';
    echo '<table class="table table-condensed" data-click-to-select="true" data-select-item-name="radioName">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th data-field= "title" >Titulo</th>';
    echo '<th data-field= "description" >Descripcion</th>';
    echo '<th data-field= "valoracion" >Valoracion</th>';
    echo '<th data-field= "votos" >Votos</th>';
    echo '<th data-field= "state" >Estado</th>';
    echo '<th data-field= "state" ></th>';
    echo '</tr>';

    if ($cuentafilas > 0) {

        $count = 0;
        while ($dato = mysql_fetch_array($resultado)) {


            echo'<!-- Modal Eliminar Apunte-->';
            echo' <div class="modal fade" id="myModalEliminarApunte'.$dato[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            echo'   <div class="modal-dialog">';
            echo'        <div class="modal-content">';
            echo'            <div class="modal-header">';
            echo'                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            echo'                 <h4 class="modal-title">Confirmar</h4>';
            echo'            </div>';
            echo'        <div class="modal-body">';
            echo'            <!-- The form is placed inside the body of modal -->';
            echo'            <form id="eliminarApunteForm" method="post" class="form-horizontal">';
            echo'                <h4 class="modal-title">¿Desea eliminar el apunte?</h4>';
            echo'                <button type="submit" style="margin-right: 5px;" class="btn btn-danger" style="width: 100%;" id="confElimApunte" name="confElimApunte" value="'.$dato[0].'">Confirmar</button>';
            echo'            </form>';
            echo'        </div>';
            echo'        </div>';
            echo'   </div>';
            echo'</div>';
            
            
            
            
            
            echo'    <!-- Modal Modificar Apuntes -->';
            echo'     <div class="modal fade" id="myModalModificarApuntes' . $dato[0] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            echo'        <div class="modal-dialog">';
            echo'            <div class="modal-content">';
            echo'                <div class="modal-header">';
            echo'                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            echo'                    <h4 class="modal-title">Modificar Apuntes</h4>';
            echo'                </div>';
            echo'                <div class="modal-body" >';
            echo'                    <form method="post" id="modificarApunteForm" name="modificarApunteForm" enctype="multipart/form-data">';
            echo'                        <div class="row">';
            echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Título</label>';
            echo'                            <input type="text" id="inputTitulo" name="inputTitulo" class="col-xs-6 text-center col-xs-offset-1" value="' . $dato[1] . '">';
            echo'                        </div>';
            echo'                        <br>';
            echo'                        <div class="row">';
            echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Descripción</label>';
            echo'                            <input type="text" id="inputDescripcion" name="inputDescripcion" class="col-xs-6 text-center col-xs-offset-1" value="' . $dato[2] . '">';
            echo'                        </div>';
            echo'                        <br>';
            echo'                        <div class="row">';
            echo'                            <label class="col-xs-2 col-xs-offset-1 text-right" value="" >Fichero:</label>';
            echo'                            <p class="text-center">'.$dato[6].'</input>';
            echo'                        </div>';
            echo'                        <div class="row">';
            echo'                               <label class="col-xs-2 col-xs-offset-1 text-right">Modificar fichero:</label> <input id="inputArchivo" name="inputArchivo" type="file" class="btn col-xs-8 col-xs-offset-1" value="' . $dato[6] . '"> ';
            echo'                        </div>';
            echo'                        <br>';
            echo'                        <div class="row">';
            echo'                            <button type="submit" name="modificar_apuntes" id="modificar_apuntes" class="btn btn-warning btn-lg" style="width: 100%;" value="' . $dato[0] . '">Modificar</button>';
            echo'                        </div>';
            echo'                    </form>';
            echo'                </div>';
            echo'            </div>';
            echo'        </div>';
            echo'    </div>';

            //POR CADA RESULTADO CREAMOS UNA FILA DE LA TABLA CON:
            if ($dato[5] == "aprobado") {
                echo '<tr>';
                echo '<td>';
                echo $dato[1];
                echo '</td>';
                echo '<td>';
                echo $dato[2];
                echo '</td>';
                echo '<td>';
                echo $dato[3];
                echo '</td>';
                echo '<td>';
                echo $dato[4];
                echo '</td>';
                echo '<td>';
                echo $dato[5];
                echo '</td>';
                echo '<td>';
                echo '<form method="get" target="_self" action="/php/descargar.php?archivo">';
                echo'<button type="submit" id="descargarmodificar" name="archivo" class="btn btn-primary btn-xs glyphicon glyphicon-download-alt" value="' . $dato[6] . '"></button>';
                echo '</form>';
                echo'</td>';
                echo '<td>';
                echo '<form method="post">';
                echo '<button type="submit" class="btn btn-primary btn-xs glyphicon glyphicon-pencil disabled" ></button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form method="post">';
                echo '<button type="submit" style="margin-right: 5px;" class="btn btn-danger btn-xs glyphicon glyphicon-trash disabled" ></button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            } else {
                echo '<tr>';
                echo '<td>';
                echo $dato[1];
                echo '</td>';
                echo '<td>';
                echo $dato[2];
                echo '</td>';
                echo '<td>';
                echo $dato[3];
                echo '</td>';
                echo '<td>';
                echo $dato[4];
                echo '</td>';
                echo '<td>';
                echo $dato[5];
                echo '</td>';
                echo '<td>';
                echo '<form method="get" target="_self" action="/php/descargar.php?archivo">';
                echo'<button type="submit" id="descargarmodificar" name="archivo" class="btn btn-primary btn-xs glyphicon glyphicon-download-alt" value="' . $dato[6] . '"></button>';
                echo '</form>';
                echo'</td>';
                echo '<td>';
                echo '<button type="button" class="btn btn-primary btn-xs glyphicon glyphicon-pencil" id="modificar_apunte" name="modificar_apunte" data-toggle="modal" data-target="#myModalModificarApuntes' . $dato[0] . '" value="' . $dato[0] . '" ></button>';
                echo '</td>';
                echo '<td>';
                echo '<button id="selApunte" name="selApunte" type="button" class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="modal" data-target="#myModalEliminarApunte'. $dato[0] .'" value="' . $dato[0] . '"></button>';
                echo '</td>';
                echo '</tr>';
            }
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '<button id="botonSubirApuntes" name="botonSubirApuntes" type="button" data-toggle="modal" data-target="#myModalSubeApuntes" style="margin-right: 50px;" class="btn btn-primary col-xs-offset-9" >Subir apunte<span class="glyphicon glyphicon-circle-arrow-up" style="margin-left:5px"></span></button>';
} else {
    echo '<h1>NO TIENES PERMISO PARA ENTRAR AQUI</h1>';
}
?>