<?php

if (isset($_REQUEST['modificar_apuntes'])) {

    $id = $_REQUEST['modificar_apuntes'];
    $title = $_REQUEST['inputTitulo'];
    $description = $_REQUEST['inputDescripcion'];

    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");

    //Update sin cambiar fichero
    if ($_FILES['inputArchivo']['name'] == '') {
        if ($title != '' && $description != '') {
            $sql = "UPDATE apunte Set title ='$title', description='$description' where id_apunte='$id'";
        } else {
            echo'<script>window.alert("Todos los campos són obligatorios")</script>';
        }
    } else {//update cambiando fichero
        //Variables nuevo fichero
        $nombre = $_FILES['inputArchivo']['name'];
        $nombre_tmp = $_FILES['inputArchivo']['tmp_name'];
        $tipo = $_FILES['inputArchivo']['type'];
        $tamano = $_FILES['inputArchivo']['size'];

        $ext_permitidas = array('pdf');
        $partes_nombre = explode('.', $nombre);
        $extension = end($partes_nombre);
        $ext_correcta = in_array($extension, $ext_permitidas);

        $limite = 5000 * 1024;

        //Control del fichero
        if ($ext_correcta && $tamano <= $limite) {

            if ($_FILES['archivo']['error'] > 0) {
                echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
                echo'<script>window.alert("Fichero corrupto")</script>';
                echo "<script language='javascript'>window.location='misapuntes.php'</script>";
            } else {

                if ($title == '' || $description == '') {
                    echo'<script>window.alert("Todos los campos són obligatorios")</script>';
                } else {
                    if (file_exists('apuntes/' . $nombre)) {
                        echo'<script>window.alert("Debe cambiar el nombre del fichero")</script>';
                        echo "<script language='javascript'>window.location='misapuntes.php'</script>";
                    } else {
                        //Eliminando el archivo antiguo
                        $sql = "SELECT filename FROM apunte WHERE id_apunte = '$id'";
                        $result = mysql_query($sql, $conexion) or die("Error en: $sql: " . mysql_error());
                        if ($rs = mysql_fetch_array($result)) {
                            $dato = $rs[0];
                            unlink("apuntes/" . $dato);
                        }

                        //Subiendo al servidor el nuevo archivo                            
                        move_uploaded_file($nombre_tmp, 'apuntes/' . $nombre);
                        //Actualizando en la BBDD
                        $sql = "UPDATE apunte Set title ='$title', description='$description', filename='$nombre' where id_apunte='$id'";
                    }
                }
            }
        } else {
            echo'<script>window.alert("Archivo inválido: Extensión incorrecta o su tamaño es demasiado grande")</script>';
            echo "<script language='javascript'>window.location='misapuntes.php'</script>";
        }
    }

    $result1 = mysql_query($sql, $conexion) or die(mysql_error());
    echo'<script>window.alert("Apunte modificado correctamente")</script>';
    echo "<script language='javascript'>window.location='misapuntes.php'</script>";
    mysql_close($conexion);
    exit();
}
?>

