<?php

if (isset($_REQUEST['guardar'])) {

    if ($_FILES['archivo']['name'] == '' /*!isset($_FILES['archivo'])*/) {
        
        echo'<script>window.alert("Ha habido un error, tienes que elegir un archivo")</script>';
        echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 

    } else {

        $nombre = $_FILES['archivo']['name'];
        $nombre_tmp = $_FILES['archivo']['tmp_name'];
        $tipo = $_FILES['archivo']['type'];
        $tamano = $_FILES['archivo']['size'];

        $ext_permitidas = array('jpg');
        $partes_nombre = explode('.', $nombre);
        $extension = end($partes_nombre);
        $ext_correcta = in_array($extension, $ext_permitidas);

        $tipo_correcto = preg_match('/^mat_photo\/(jpg)$/', $tipo);

        $limite = 200 * 1024;

        if ($ext_correcta && $tamano <= $limite) {

            if ($_FILES['archivo']['error'] > 0) {
                echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
                echo'<script>window.alert("Fichero corrupto")</script>';
                echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 

            } else {
                if ($_REQUEST['textestado']=='') {
                echo'<script>window.alert("Estado incorrecto")</script>';
                echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 

                } else {

                    if ($_REQUEST['textnombre']=='' || $_REQUEST['textdescri']=='' || $_REQUEST['textprecio']=='') {
                        echo'<script>window.alert("Todos los campos són obligatorios")</script>';
                        echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 
                    } else {
                        if (file_exists('mat_photo/' . $nombre)) {
                            echo'<script>window.alert("Debe cambiar el nombre de la fotografía")</script>';
                            echo "<script language='javascript'>window.location='gestion_material.php'</script>";                             
                        } else {

                            $title = $_REQUEST['textnombre'];
                            $ofertaState = $_REQUEST['textestado'];
                            $description = $_REQUEST['textdescri'];
                            $precio = $_REQUEST['textprecio'];
                            $fecha = gmdate("YmdHis");
                            $id = $_SESSION['s_id'];

                            $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
                            mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
                            mysql_query("SET NAMES 'utf8'");


                            move_uploaded_file($nombre_tmp, 'mat_photo/' . $nombre);

                            $sql = "INSERT INTO material (title,id_categoria,oferta_state,vendido, description, precio, state, "
                                    . "id_user, filenamephoto, valoriacion, votos, fecha_subida)"
                                    . "VALUES ('$title',1,'$ofertaState', 0 ,'$description', $precio, 'preparado' , '$id', '$nombre', 0.0, 0, $fecha)";
                            $result1 = mysql_query($sql, $conexion) or die(mysql_error());
                            mysql_close($conexion);
                            
                            echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 
                            exit();
                        }
                    }
                }
            }
        } else {
            echo'<script>window.alert("Archivo inválido: Extensión incorrecta o su tamaño es demasiado grande")</script>';
            echo "<script language='javascript'>window.location='gestion_material.php'</script>";                             
        }
    }
    
    echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 
    //header("Location: ../index.php");
    exit();
    
}


?>
