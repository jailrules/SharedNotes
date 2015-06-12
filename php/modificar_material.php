<?php

if (isset($_REQUEST['modificarmaterial'])) {

    $id = $_REQUEST['modificarmaterial'];
    $title = $_REQUEST['textnombre'];
    $description = $_REQUEST['textdescri'];
    $precio = $_REQUEST['textprecio'];
    $estado = $_REQUEST['textestado'];

    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");

    //Update sin cambiar fichero
    if ($_FILES['archivo']['name'] == '') {
        
        if($title !='' &&$description != '' &&$precio!='' &&$estado!=''){
           $sql = "UPDATE material Set title ='$title', oferta_state='$estado', description='$description', precio='$precio' where id_material='$id'";
        }else{
            echo'<script>window.alert("Todos los campos són obligatorios")</script>';
            echo "<script language='javascript'>window.location='gestion_material.php'</script>";
        }
     
    } else {//update cambiando fichero
        //Variables nuevo fichero
        $nombre = $_FILES['archivo']['name'];
        $nombre_tmp = $_FILES['archivo']['tmp_name'];
        $tipo = $_FILES['archivo']['type'];
        $tamano = $_FILES['archivo']['size'];

        $ext_permitidas = array('jpg');
        $partes_nombre = explode('.', $nombre);
        $extension = end($partes_nombre);
        $ext_correcta = in_array($extension, $ext_permitidas);

        $limite = 200 * 1024;

        //Control del fichero
        if ($ext_correcta && $tamano <= $limite) {

            if ($_FILES['archivo']['error'] > 0) {
                echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
                echo'<script>window.alert("Fichero corrupto")</script>';
                echo "<script language='javascript'>window.location='gestion_material.php'</script>";
            } else {
                if ($estado == '') {
                    echo'<script>window.alert("Estado incorrecto")</script>';
                    echo "<script language='javascript'>window.location='gestion_material.php'</script>";
                } else {

                    if ($title == '' || $description == '') {
                        echo'<script>window.alert("Todos los campos són obligatorios")</script>';
                        echo "<script language='javascript'>window.location='misapuntes.php'</script>";
                    } else {
                        if (file_exists('mat_photo/' . $nombre)) {
                            echo'<script>window.alert("Debe cambiar el nombre del fichero")</script>';
                            echo "<script language='javascript'>window.location='gestion_material.php'</script>";
                        } else {
                            //Eliminando el archivo de foto antiguo
                            $sql = "SELECT filenamephoto FROM material WHERE id_material = '$id'";
                            $result = mysql_query($sql, $conexion) or die("Error en: $sql: " . mysql_error());
                            if ($rs = mysql_fetch_array($result)) {
                                $dato = $rs[0];
                                unlink("mat_photo/" . $dato);
                            }

                            //Subiendo al servidor el nuevo archivo                            
                            move_uploaded_file($nombre_tmp, 'mat_photo/' . $nombre);
                            //Actualizando en la BBDD
                            $sql = "UPDATE material Set title ='$title', oferta_state='$estado', description='$description', precio='$precio', filenamephoto='$nombre' where id_material='$id'";
                        }
                    }
                }
            }
        } else {
            echo'<script>window.alert("Archivo inválido: Extensión incorrecta o su tamaño es demasiado grande")</script>';
            echo "<script language='javascript'>window.location='gestion_material.php'</script>";
        }
    }
    $result1 = mysql_query($sql, $conexion) or die(mysql_error());
    echo'<script>window.alert("Material modificado correctamente")</script>';
    echo "<script language='javascript'>window.location='gestion_material.php'</script>";
    mysql_close($conexion);
    exit();
}
?>