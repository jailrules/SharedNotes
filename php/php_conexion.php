<?php

require './php/config.php';
if (!isset($_SESSION['s_username'])) {
    if (isset($_REQUEST['login'])) {
        //SI ES UNA PETICION DE LOGIN
        if (isset($_REQUEST['username']) && !empty($_REQUEST['username']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])) {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
            mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
            mysql_query("SET NAMES 'utf8'");
            $query = "SELECT username, id_user, user_type FROM user WHERE username = \"" . $username . "\" AND password = \"" . $password . "\"";
            $result = mysql_query($query);
            if (mysql_num_rows($result) == 0) {
                echo'<script>window.alert("El nombre de usuario o contraseña que has inctroducion son incorrectos!")</script>';
                //header("Location: ../index.php");
            } else {
                $dato = mysql_fetch_array($result);
                $_SESSION['s_username'] = "" . $dato[0];
                $_SESSION['s_id'] = "" . $dato[1];
                $rol=$dato[2];
                if(strpos($rol, 'A') !== false){
                    $_SESSION['admin']=true;
                }else{
                    $_SESSION['admin']=false;
                }
                header("Location: ../index.php");
                mysql_close($conexion);
            }
        }
        exit();
    }
}
?>