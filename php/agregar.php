<?php

if (isset($_REQUEST['agregar'])) {
    if (isset($_SESSION['s_username'])) {    //SI HA INICIADO SESION
        $material = $_REQUEST['agregar'];
        $id = $_SESSION['s_id'];
        $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'");
        $query = "select id_material,id_user FROM cesta WHERE id_material=" . $material . " AND id_user= \"" . $id . "\"";
        $result = mysql_query($query, $conexion);
        //COMPROBAMOS QUE NO EXISTA YA ESE MATERIAL EN EL CARRITO DEL USUARIO
        if (mysql_num_rows($result) > 0) {
            //MOSTRAR MENSAJE DE ERROR SI EXISTE EL MATERIAL EN EL CARRITO
            //REENVIO A PAGINA MATERIALES
            header("Location: ../material.php");
            //echo '<script type="text/javascript>alert(\'mostrar mi ventana popup\');</script>"';
            exit();
        } else {
            //SE AÑADE A LA CESTA DEL USUARIO       
            mysql_query("SET NAMES 'utf8'");
            $sql = "INSERT INTO cesta (id_material, id_user)VALUES ($material,$id)";
            echo 'fallo';
            $result1 = mysql_query($sql, $conexion) or die(mysql_error());
            mysql_close($conexion);
            header("Location: ../material.php");
            exit();
        }
    } else {
        if (!isset($_SESSION['carro[]'])) {
            //Si se trata de la primera vez crea el array de elementos y añade el material
            $material = $_REQUEST['agregar'];
            $carro = array();
            array_push($carro, $material);
            $_SESSION['carro[]'] = $carro;
            header("Location: ../material.php");
            exit();
        } else {
            $material = $_REQUEST['agregar'];
            //Si ya estaba creado añadimos si no esta en el array
            $carro = $_SESSION['carro[]'];
            if (in_array($material, $carro)) {
                //CASO DE QUE EXISTA NO HACEMOS NADA
                header("Location: ../material.php");
                exit();
            } else {
                //CASO DE QUE NO EXISTA LO AÑADIMOS
                array_push($carro, $material);
                $_SESSION['carro[]'] = $carro;
                header("Location: ../material.php");
                exit();
            }
        }
    }
}
if (isset($_REQUEST['loginagregar'])) {
    $id_mat = $_REQUEST['loginagregar'];
    if (isset($_REQUEST['usernamea']) && !empty($_REQUEST['usernamea']) && isset($_REQUEST['passworda']) && !empty($_REQUEST['passworda'])) {
        $username = $_REQUEST['usernamea'];
        $password = $_REQUEST['passworda'];
        $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'");
        $query = "SELECT username, id_user, user_type FROM user WHERE username = \"" . $username . "\" AND password = \"" . $password . "\"";
        $result = mysql_query($query);
        if (mysql_num_rows($result) == 0) {
            echo'<script>window.alert("El nombre de usuario o contraseña que has introducido son incorrectos!")</script>';
            //header("Location: ../index.php");
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
            $id = $_SESSION['s_id'];
            mysql_query("SET NAMES 'utf8'");
            $query2 = "select id_material,id_user FROM cesta WHERE id_material=" . $id_mat . " AND id_user= \"" . $id . "\"";
            $result = mysql_query($query2, $conexion);
            //COMPROBAMOS QUE NO EXISTA YA ESE MATERIAL EN EL CARRITO DEL USUARIO
            if (mysql_num_rows($result) > 0) {
                //MOSTRAR MENSAJE DE ERROR SI EXISTE EL MATERIAL EN EL CARRITO
                echo'<script>window.alert("Bienvenido de nuevo '.$_SESSION[s_username].', el producto seleccionado ya esta en tu carrito!")</script>';
                //REENVIO A PAGINA MATERIALES
                header("Location: ../material.php");
                //echo '<script type="text/javascript>alert(\'mostrar mi ventana popup\');</script>"';
                exit();
            } else {
                //SE AÑADE A LA CESTA DEL USUARIO       
                mysql_query("SET NAMES 'utf8'");
                $sql = "INSERT INTO cesta (id_material, id_user)VALUES ($id_mat,$id)";
                $result1 = mysql_query($sql, $conexion) or die(mysql_error());
                mysql_close($conexion);
                echo'<script>window.alert("Bienvenido de nuevo '.$_SESSION[s_username].', el producto ha sido añadido a tu carrito!")</script>';
                header("Location: ../material.php");
                exit();
            }
            header("Location: ../material.php");
            mysql_close($conexion);
        }
    }
    header("Location: ../material.php");
}
if (isset($_REQUEST['registraragregar'])) {
    $id_mat = $_REQUEST['registraragregar'];
    $username = $_REQUEST['usernamear'];
    $email = $_REQUEST['emailar'];
    $passwd = $_REQUEST['passwdar'];
    $confirmpasswd = $_REQUEST['confirmpasswdar'];
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
            echo'<script>window.alert("¡¡¡Usuario Ya Registrado, contacte con un administrador!!!")</script>';
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
                    $id = $_SESSION['s_id'];
                    //AÑADIR AL CARRO EL PRODUCTO
                    $sql2 = "INSERT INTO cesta (Id_user,Id_material) VALUES ($id,$id_mat)";
                    $result1 = mysql_query($sql2, $conexion) or die(mysql_error());
                }
                echo'<script>window.alert("¡Usuario Registrado Correctamente!")</script>';
            } else {
                echo'<script>window.alert("¡Ha ocurrido un fallo!")</script>';
            }
            mysql_close($conexion);

            echo "<script language='javascript'>window.location='index.php'</script>";
        }
    }
    header("Location: ../material.php");
}
?>
