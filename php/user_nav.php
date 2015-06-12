<?php

if (!isset($_SESSION['s_username'])) {
    //CASO USUARIO INVITADO
    //3 botones "REGISTRATE","LOGUEATE","CARRITO"
    if (isset($_SESSION['carro[]'])){
        $cuenta= '<span class="label label-primary">'.count($_SESSION['carro[]']).'</span>';
    }else {
        $cuenta= '<span class="label label-primary">0</span>';
    }
    echo '<div class="btn-toolbar" style="float: right;">';
    echo '<table >';
    echo '<tr>';
    echo '<td>';
    echo '<button class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal" type="submit" >Logueate</button>';
    echo '</td>';
    echo '<td>';
    echo '<button class="btn btn-primary btn-small" data-toggle="modal" data-target="#ModalRegister" type="submit" >Registrate</button>';
    echo '</td>';
    echo '<td>';
    echo '<button class="btn btn-primary btn-small glyphicon glyphicon-shopping-cart"  style="position: inherit;" type="submit" onclick = "javascript:window.location=\'carrito.php\'">Carrito'.$cuenta.'</button>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
} else {
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $query = 'SELECT COUNT(*) FROM cesta WHERE id_user='.$_SESSION['s_id'].'';
    $result = mysql_query($query, $conexion);
    if (mysql_result($result, 0) == 0) {
        $cuenta= '<span class="label label-primary">0</span>';
    } else {
        $cuenta= '<span class="label label-primary">' . mysql_result($result, 0) . '</span>';
    }
    mysql_close($conexion);
    $conexion1 = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion1) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $query2='SELECT COUNT(*) FROM notification WHERE leida=0';
    $result2 = mysql_query($query2, $conexion1);
    if (mysql_result($result2, 0) == 0) {
        $cuentanotif= '<span class="label label-primary">0</span>';
    } else {
        $cuentanotif= '<span class="label label-primary">' . mysql_result($result2, 0) . '</span>';
    }
    mysql_close($conexion1);
    //CASO USUARIO LOGUEADO
    //3 "MENSAJE DE BIENVENIDA","CARRITO","CERRAR SESION"
    //RECUPERAR NOMBRE USUARIO DE LA SESSION 
    echo '<div class="btn-toolbar" style="float: right;">';
    echo '<table >';
    echo '<tr>';
    echo '<td>';
    echo 'Bienvenido ';
    echo $_SESSION['s_username'];
    echo '     ';
    echo '</td>';
    if($_SESSION['admin']==true){
        echo '<td>';
        echo '<button type="submit" class="btn btn-primary btn-small glyphicon glyphicon-bell"  style="position: inherit;" onclick = "javascript:window.location=\'notificaciones.php\'" >Notificacion'.$cuentanotif.'</button>';
        echo '</td>';
    }
    echo '<td>';
    echo '<button type="submit" class="btn btn-primary btn-small glyphicon glyphicon-shopping-cart"  style="position: inherit;" onclick = "javascript:window.location=\'carrito.php\'" >Carrito'.$cuenta.'</button>';
    echo '</td>';
    echo '<td>';
    echo '<button type="submit" class="btn btn-primary btn-small" onclick = "javascript:window.location=\'cuenta.php\'">Mi Cuenta</button>';
    echo '</td>';
    echo '<td>';
    echo '<form method="post" style="margin-bottom: 0px;">';
    echo '<button class="btn btn-primary btn-small" type="submit" name="cerrar" id="cerrar" value="cerrar" onclick = "javascript:window.location=\'php/close_session.php\'">Cerrar sesión</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}
?>