<?php

if (isset($_SESSION['s_username'])) {
    if ($_SESSION['admin'] == true) {
        $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'");
        $query = "SELECT username, user_type, name, lastname, address, contactnumber, email, id_user FROM user";
        $result = mysql_query($query, $conexion);
        if ($result <> "") {
            echo ' <br/><br/>';
            echo '<div class="container">';
            echo '<div class="row">';
            echo '<div class="col-md-10">';
            echo '<h3>Listado Usuarios</h3>';
            echo '<div class="table table-striped">';
            echo '<table id="mytable" class="table table-bordred table-striped">';
            echo '<thead>';
            echo '<th>Usuario</th>';
            echo '<th>Rol</th>';
            echo '<th>Nombre</th>';
            echo '<th>Apellidos</th>';
            echo '<th>Direccion</th>';
            echo '<th>Telefono</th>';
            echo '<th>Email</th>';
            echo '</thead>';
            echo '<tbody>';
            while ($rs = mysql_fetch_array($result)) {
                //MODAL DE USUARIO
                $usertype = $rs[1];
                echo'        <!-- MODAL MODIFICAR USUARIO-->';
                echo'<div class="modal fade" id="myModifyUser' . $rs[7] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >';
                echo'    <div class="modal-dialog">';
                echo'        <div class="modal-content">';
                echo'            <div class="modal-header">';
                echo'                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                echo'                <h4 class="modal-title">Editar Usuario</h4>';
                echo'            </div>';
                echo'            <div class="modal-body">';
                echo'                <!-- The form is placed inside the body of modal -->';
                echo'                <form id="loginForm" method="post" class="form-horizontal">';
                echo'                    <div class="form-group">';
                echo'                        <label>Nombre del Usuario</label>';
                echo'                        <input class="form-control" id="name" name="name" type="text" value="' . $rs[2] . '" required>';
                echo'                    </div> ';
                echo'                    <div class="form-group">';
                echo'                        <label>Apellidos del Usuario</label>';
                echo'                        <input class="form-control" id="apellidos" name="apellidos" type="text" value="' . $rs[3] . '" required>';
                echo'                    </div>';
                echo'                    <div class="form-group">';
                echo'                        <label>Direccion</label>';
                echo'                        <input class="form-control" id="direccion" name="direccion" type="text" value="' . $rs[4] . '" required>';
                echo'                    </div>';
                echo'                    <div class="form-group">';
                echo'                        <label>Nick</label>';
                echo'                        <input class="form-control" id="username" name="username" type="text" value="' . $rs[0] . '" required>';
                echo'                    </div>';
                echo'                    <div class="form-group">';
                echo'                        <label>Email</label>';
                echo'                        <input class="form-control" id="email" name="email" type="email" value="' . $rs[6] . '" required>';
                echo'                    </div>';
                echo'                    <div class="form-group">';
                echo'                        <label>Numero de Contacto</label>';
                echo'                        <input class="form-control" id="numb" name="numb" type="text" value="' . $rs[5] . '" required>';
                echo'                    </div>';
                echo'                    <div class="form-group">';
                echo'                        <label class="control-label">Permisos</label><br>';
                if (!strpos($usertype, 'RM')) {
                    echo'                        <input type = "Checkbox" name ="option1" value= "RM">Revisor de Materiales';
                } else {
                    echo'                        <input type = "Checkbox" name ="option1" value= "RM" checked>Revisor de Materiales';
                }
                if (!strpos($usertype, 'RD')) {
                    echo'                        <input type = "Checkbox" name ="option2" value= "RD">Revisor de Apuntes';
                } else {
                    echo'                        <input type = "Checkbox" name ="option2" value= "RD" checked>Revisor de Apuntes';
                }
                if (!strpos($usertype, 'A')) {
                    echo'                        <input type = "Checkbox" name ="option3" value= "A">Administrador';
                } else {
                    echo'                        <input type = "Checkbox" name ="option3" value= "A" checked>Administrador';
                }
                echo'                    </div>';
                echo'            </div>';
                echo'            <div class="modal-footer ">';
                echo'                <button type="submit" id="actualizar" name="actualizar" value="' . $rs[7] . '" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Actualizar</button>';
                echo'            </div>';
                echo'            </form>';
                echo'        </div>';
                echo'    </div>';
                echo'</div>';
                echo'<!-- FIN MODIFICAR USUARIO-->';
                //LINEA DE TABLA
                echo '<tr>';
                echo '<td>' . $rs[0] . '</td>';
                $rol = $rs[1];
                $roles=explode(" ", $rol);
                $cuentarol=count($roles);
                if (strpos($rol, 'A') !== false) {
                    echo '<td>';
                    for($i=0;$i<=$cuentarol-1;$i++){
                        if($i==$cuentarol-1){
                            if($roles[$i]=="U"){
                                echo 'Usuario.';
                            }
                            if($roles[$i]=="RM"){
                                echo 'Revisor Material.';
                            }
                            if($roles[$i]=="RD"){
                                echo 'Revisor Apuntes.';
                            }
                            if($roles[$i]=="A"){
                                echo 'Administrador.';
                            }
                        }else{
                            if($roles[$i]=="U"){
                                echo 'Usuario,';
                            }
                            if($roles[$i]=="RM"){
                                echo 'Revisor Material,';
                            }
                            if($roles[$i]=="RD"){
                                echo 'Revisor Apuntes,';
                            }
                            if($roles[$i]=="A"){
                                echo 'Administrador,';
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $rs[2] . '</td>';
                    echo '<td>' . $rs[3] . '</td>';
                    echo '<td>' . $rs[4] . '</td>';
                    echo '<td>' . $rs[5] . '</td>';
                    echo '<td>' . $rs[6] . '</td>';
                    echo '<td>';
                    echo '<button class = "btn btn-primary btn-xs glyphicon glyphicon-pencil disabled" type = "submit" id = "idUser" name = "idUser" value = "' . $rs[7] . '" onclick = "javascript:window.location=\'php/get_user.php\'"></button>';
                    echo '</td>';
                    echo '</tr>';
                } else {
                    echo '<td>';
                    for($i=0;$i<=$cuentarol-1;$i++){
                        if($i==$cuentarol-1){
                            if($roles[$i]=="U"){
                                echo 'Usuario.';
                            }
                            if($roles[$i]=="RM"){
                                echo 'Revisor Material.';
                            }
                            if($roles[$i]=="RD"){
                                echo 'Revisor Apuntes.';
                            }
                            if($roles[$i]=="A"){
                                echo 'Administrador.';
                            }
                        }else{
                            if($roles[$i]=="U"){
                                echo 'Usuario,';
                            }
                            if($roles[$i]=="RM"){
                                echo 'Revisor Material,';
                            }
                            if($roles[$i]=="RD"){
                                echo 'Revisor Apuntes,';
                            }
                            if($roles[$i]=="A"){
                                echo 'Administrador,';
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $rs[2] . '</td>';
                    echo '<td>' . $rs[3] . '</td>';
                    echo '<td>' . $rs[4] . '</td>';
                    echo '<td>' . $rs[5] . '</td>';
                    echo '<td>' . $rs[6] . '</td>';
                    echo '<td><button class = "btn btn-primary btn-xs glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myModifyUser' . $rs[7] . '"type = "submit" id = "idUser" name = "idUser" value = "' . $rs[7] . '" </button></td>';
                    echo '</tr>';
                }
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div> ';
        } else {
            echo" <div class=\"alert alert-danger\">NO EXISTEN USUARIOS DE HECHO NO SE COMO HAS LLEGADO AQUI</div>";
        }
    } else {
        echo" <div class=\"alert alert-danger\">NO TIENES PERMISOS PARA VISUALIZAR ESTA PAGINA</div>";
    }
} else {
    echo" <div class=\"alert alert-danger\">NO TIENES PERMISOS PARA VISUALIZAR ESTA PAGINA</div>";
}
?>


