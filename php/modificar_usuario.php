<?php

if (isset($_REQUEST['actualizar'])) {
    $id = $_REQUEST['actualizar'];
    $username = $_REQUEST["username"];
    $email = $_REQUEST["email"];
    $numb = $_REQUEST["numb"];
    $name = $_REQUEST["name"];
    $apellidos = $_REQUEST["apellidos"];
    $direccion = $_REQUEST["direccion"];
    $permiso="U ";
    if($_REQUEST['option1']<>""){
        $permiso=$permiso."RM ";
    }
    if($_REQUEST['option2']<>""){
        $permiso=$permiso."RD ";
    }
    if($_REQUEST['option3']<>""){
        $permiso=$permiso."A";
    }
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    $sql = "UPDATE user SET username='$username',email='$email',contactnumber='$numb',user_type='$permiso', name='$name', lastname='$apellidos', address='$direccion' WHERE id_user=" . $id . "";
    $result2 = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_close($conexion);

    header("Location: ../usuarios.php");
    exit();
}
?>
