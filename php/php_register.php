<?php

if (isset($_REQUEST['registrar'])) {
    //COMPROBAMOS QUE TODOS LOS DATOS HAYAN SIDO INTRODUCIDOS CORRECTAMENTE
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $passwd = $_REQUEST['passwd'];
    $confirmpasswd = $_REQUEST['confirmpasswd'];
    $error = 'Tienes que rellenar el/los campos: ';
    //EN ESTE ARRAY IREMOS AÑADIENDO LA LISTA DE ERRORES QUE SE MOSTRARA SI ALGUNO SE CUMPLE
    $errorlist = array();
    if ($username == '') {
        array_push($errorlist, ' Nombre de usuario');
    }
    if ($email == '') {
        array_push($errorlist, ' Email');
    }
    if ($passwd == '') {
        array_push($errorlist, ' Contraseña');
    }
    if ($confirmpasswd == '') {
        array_push($errorlist, ' Confirmacion de contraseña');
    }
    if ($confirmpasswd <> '' && $passwd <> '') {
        if (strlen($passwd) < 8) {
            array_push($errorlist, ' La contraseña debe tener al menos 8 caracteres!');
        }
        if ($confirmpasswd != $passwd) {
            array_push($errorlist, ' La contraseña y la confirmacion de la contraseña deben coincidir!');
        }
    }
    if (count($errorlist) > 0) {
        $i = 0;
        foreach ($errorlist as $value) {
            if ($i == count($errorlist) - 1) {
                $error = $error . $value . '.';
            } else {
                $error = $error . $value . ',';
            }
            $i++;
        }
        echo'<script>window.alert("' . $error . '")</script>';
    } else {
        //EN CASO DE QUE TODO SE HAYA INTRODUCIDO CORRECTAMENTE COMPROBAMOS SI EL USUARIO YA EXISTE
        $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'");
        $consulta = "SELECT username FROM user WHERE email=\"" . $email . "\";";
        $resultado = mysql_query($consulta, $conexion);
        //SI DEVUELVE ALGUNA LINEA EXISTE UN USUARIO YA CON ESE EMAIL
        if (mysql_num_rows($resultado) > 0) {
            echo'<script>window.alert("¡¡¡Usuario Ya Registrado!!!")</script>';
            //SI NO , PROCEDEMOS AL REGISTRO DEL USUARIO NUEVO Y SU LOGUEO EN EL SISTEMA    
        } else {
            $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
            mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
            mysql_query("SET NAMES 'utf8'");

            $sql = "INSERT INTO user (id_user,name,lastname,address,contactnumber,email,password,username,user_type )VALUES (NULL,'xxxx','yyyy','zzzz','1234','$email', '$passwd','$username', 'U');";
            $result1 = mysql_query($sql, $conexion) or die(mysql_error());

            if ($result1 == 1) {
                //SI SE HA CREADO CORRECTAMENTE INICIAMOS SESSION Y SI TENIA CARRO SE LO ASIGNAMOS
                $query = "SELECT username, id_user, user_type FROM user WHERE email=\"" . $email . "\";";
                $result = mysql_query($query);
                if (mysql_num_rows($result) == 0) {
                    header("Location: ../index.php");
                } else {
                    $dato = mysql_fetch_array($result);
                    $_SESSION['s_username'] = "" . $dato[0];
                    $_SESSION['s_id'] = "" . $dato[1];
                    $rol = $dato[2];
                    if (strpos($rol, 'A') !== false) {
                        $_SESSION['admin'] = true;
                    } else {
                        $_SESSION['admin'] = false;
                    }
                    //SI TIENE CARRO ASIGNADO
                    if(isset($_SESSION['carro[]'])){
                        echo'<script>window.alert("¡Transfiriendo carro!")</script>';
                        $carro=$_SESSION['carro[]'];
                        foreach ($carro as $value) {
                            echo'<script>window.alert($value)</script>';
                            $sql = "INSERT INTO cesta (id_user,id_material) VALUES (".$_SESSION['s_id'].",".$value.")";
                            $result = mysql_query($sql) or die(mysql_error());
                        }
                    }
                }
                echo'<script>window.alert("¡Usuario Registrado Correctamente!")</script>';
            } else {
                echo'<script>window.alert("¡Ha ocurrido un fallo!")</script>';
            }
            mysql_close($conexion);

            echo "<script language='javascript'>window.location='index.php'</script>";
        }
    }
}
?>