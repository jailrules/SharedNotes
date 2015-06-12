<?php





if (isset($_SESSION['s_username'])) {
    
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT title, state, description, fecha_subida, precio, id_material, oferta_state, filenamephoto FROM material WHERE id_user=" . $_SESSION['s_id'] . "";
    $result = mysql_query($query, $conexion);
    if ($result <> "") {
        echo ' <br/><br/>';
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-md-10">';
        echo '<h3>Mis Materiales</h3>';
        echo '<div class="table table-striped"> ';
        echo '<table id="mytable" class="table table-bordred table-striped">';
        echo '<thead> ';
        echo '<th>Título</th>';
        echo '<th>Estado</th>';
        echo '<th>Descripción</th>';
        echo '<th>Fecha Subida</th>';
        echo '<th>Precio</th>';
        echo '</thead>';
        echo '<tbody>';

        while ($rs = mysql_fetch_array($result)) {
            
            echo'<!-- Modal Eliminar Apunte-->';
            echo' <div class="modal fade" id="myModalEliminarMaterial'.$rs[5].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
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
            echo'                <button type="submit" style="margin-right: 5px;" class="btn btn-danger" style="width: 100%;" id="confirmareliminarMaterial" name="confirmareliminarMaterial" value="'.$rs[5].'">Confirmar</button>';
            echo'            </form>';
            echo'        </div>';
            echo'        </div>';
            echo'   </div>';
            echo'</div>';
            
            
            
            
        echo'    <!--Modal Modificar-->';
        echo'    <div class="modal fade" id="myModalModificarMaterial' . $rs[5] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
        echo'       <div class="modal-dialog">';
        echo'            <div class="modal-content">';
        echo'                <div class="modal-header">';
        echo'                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        echo'                   <h4 class="modal-title">Modificar Material</h4>';
        echo'               </div>';
        echo'               <div class="modal-body" >';
        echo'                    <form method="post"  enctype="multipart/form-data">';
        echo'                        <div class="form-group">';
        echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Nombre</label>';
        echo'                           <input type="text" id="textnombre" name="textnombre" class="col-xs-6 text-center col-xs-offset-1" value="'.$rs[0].'">';
        echo'                       </div>';
        echo'                       <br></br>';
        echo'                       <div class="form-group">';
        echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Descripción</label>';
        echo'                           <input type="text" id="textdescri" name="textdescri" class="col-xs-6 text-center col-xs-offset-1" value="'.$rs[2].'" >';
        echo'                       </div>';
        echo'                       <br></br>';
        echo'                       <div class="form-group">';
        echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Precio</label>';
        echo'                            <input type="number" min=0.05 step=.05 id="textprecio" name="textprecio" class="col-xs-6 text-center col-xs-offset-1" value="'.$rs[4].'" placeholder="Euros" >€';
        echo'                       </div>';
        echo'                       <div class="form-group">';
        echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Estado</label>';
                                           if($rs[6]=='Nuevo'){
        echo'                                   <select class="btn col-md-6 col-xs-6 col-xs-offset-1 btn-default" id="textestado" name="textestado" value="'.$rs[6].'"> <option value=""></option><option value="Nuevo" selected>Nuevo</option><option value="SemiUsado">SemiUsado</option><option value="Usado">Usado</option></select>';
                                            }elseif($rs[6]=='SemiUsado'){
        echo'                                   <select class="btn col-md-6 col-xs-6 col-xs-offset-1 btn-default" id="textestado" name="textestado" value="'.$rs[6].'"> <option value=""></option><option value="Nuevo">Nuevo</option><option value="SemiUsado" selected>SemiUsado</option><option value="Usado">Usado</option></select>';    
                                            }else{
        echo'                                   <select class="btn col-md-6 col-xs-6 col-xs-offset-1 btn-default" id="textestado" name="textestado" value="'.$rs[6].'"> <option value=""></option><option value="Nuevo">Nuevo</option><option value="SemiUsado">SemiUsado</option><option value="Usado" selected>Usado</option></select>';
                                            }
        echo'                       </div>';
        echo'                       <br> </br>';
        echo'                       <div class="form-group">';
        echo'                            <label class="col-xs-2 col-xs-offset-1 text-right">Fotografía</label> ';
        echo'                           <img src="mat_photo/'.$rs[7].'" style="width: 100%; heigth:auto;" class="img-rounded" />';
        echo'                           <label class="col-xs-2 col-xs-offset-1 text-right">Modificar Fotografía:</label>';
        echo'                           <input id="archivo" name="archivo" type="file" class="btn col-xs-8 col-xs-offset-1">';
        echo'                       </div>';
        echo'                       <br> </br>';
        echo'                       <div class="row">';
        echo'                            <button type="submit" name="modificarmaterial" id="modificarmaterial" class="btn btn-warning btn-lg" style="width: 100%;" value="' . $rs[5] . '">Modificar</button>';
        echo'                       </div>';
        echo'                        <br> </br>';                                                        
        echo'                   </form>';                        
        echo'                </div>';
        echo'            </div>';
        echo'    </div>';
        echo'</div> ';      
            
            
            
            
            if ($rs[1] == "aprobado") {
                echo '<tr>';
                echo '<td>' . $rs[0] . '</td>';
                echo '<td>' . $rs[1] . '</td>';
                echo '<td>' . $rs[2] . '</td>';
                echo '<td>' . $rs[3] . '</td>';
                echo '<td>' . $rs[4] . '€</td>';
                echo '<td><form><button class="btn btn-primary btn-xs glyphicon glyphicon-pencil disabled" data-title="Edit" data-toggle="modal" data-target="#edit" data-placement="top" rel="tooltip"></button></p></td>';
                echo '<td><button class="btn btn-danger btn-xs glyphicon glyphicon-trash disabled" type="submit" id="elimMaterial" name="elimMaterial" value="' . $rs[5] . '" onclick="javascript:window.location=\'php/eliminar_material.php\'"></button></td>';
                echo '</tr>';
            } else {
                echo '<tr>';
                echo '<td>' . $rs[0] . '</td>';
                echo '<td>' . $rs[1] . '</td>';
                echo '<td>' . $rs[2] . '</td>';
                echo '<td>' . $rs[3] . '</td>';
                echo '<td>' . $rs[4] . '€</td>';
                echo '<td><button id ="botonEditarMaterial" name="botonEditarMaterial" type="button" class="btn btn-primary btn-xs glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myModalModificarMaterial'.$rs[5].'" data-placement="top"></button></p></td>';
                //echo '<td><form method="post"><button aria-describedby="confirmation911544" id ="botonEliminarMaterial" name="botonEliminarMaterial" value="' . $rs[5] . '" type="submit" data-placement="bottom" class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="confirmation" data-btn-ok-label="Borrar" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="Cancelar" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger"></button></form></td>';
                //echo'<td><div class="popover confirmation fade top in" id="confirmation911544" style="display: block; top: -29px; left: 32.5px;"><div class="arrow"></div><h3 class="popover-title">Are you sure?</h3><div class="popover-content text-center"><div class="btn-group"><a class="btn btn-xs btn-primary" data-apply="confirmation"><i class="glyphicon glyphicon-ok"></i> Yes</a><a class="btn btn-xs btn-default" data-dismiss="confirmation"><i class="glyphicon glyphicon-remove"></i> No</a></div></div></div></td>';
                echo '<td><button id ="botonEliminarMaterial" name="botonEliminarMaterial" type="button" data-toggle="modal"  data-target="#myModalEliminarMaterial'.$rs[5].'" class="btn btn-danger btn-xs glyphicon glyphicon-trash" value="' . $rs[5] . '"></button></td>';
                echo '</tr>';
            }
        }
        echo '  </tbody>';
        echo '</table>';
        echo '<button id="botonNuevoMaterial" name="botonNuevoMaterial" type="button" data-toggle="modal" data-target="#myModalNuevoMaterial" data-placement="top" rel="tooltip" class="btn btn-primary col-xs-2 col-xs-offset-4" >Nuevo<span></span></button> ';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div> ';
    } else {
        exit(1);
    }
}
?>




