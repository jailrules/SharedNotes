<?php

$error_2 = '';
$sihaydato = $_REQUEST["haydato"];
$mensaje_noerror = "Gracias por subir apuntes, tendrás que esperar a que el apunte sea aprobado por un revisor<BR>"
        . "para que se visualice en la web";
if (isset($_FILES['inputArchivo'])) {
    $var = isset($_FILES['inputArchivo']);
    $nombre_original = $_FILES['inputArchivo']['name'];
    $tipo = $_FILES['inputArchivo']['type'];
    $tamano = $_FILES['inputArchivo']['size'];
    $nombre_temporal = $_FILES['inputArchivo']['tmp_name'];
    $error = $_FILES['inputArchivo']['error'];
    $max = 5120000;

    $title = $_REQUEST["inputTitulo"];
    $description = $_REQUEST["inputDescripcion"];

    $ext_permitidas = array('pdf');
    $partes_nombre = explode('.', $nombre_original);
    $extension = end($partes_nombre);
    $ext_correcta = in_array($extension, $ext_permitidas);

    // if(tamanyo_archivoz

    if ($title == '' || $description == '' || $nombre_original == '') {
        $error_2 = "No se puede subir el archivo, faltan campos por rellenar, recuerda que debes rellenar el Título"
                . ", la Descripción y adjuntar un fichero en el formulario de subir apuntes.";
        //
    } else {
        $fecha = gmdate("YmdHis");

        if ($tamano <= $max && $ext_correcta) {

            $path = $_SERVER['DOCUMENT_ROOT'] . "/apuntes/";
            $temp = "C:/Users/Miguel/Documents/Programacion/xampp/tmp/";

            $id = $_SESSION['s_id'];
            $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
            mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
            mysql_query("SET NAMES 'utf8'");

            $uploadfile = $path . basename($_FILES['inputArchivo']['name']);
            move_uploaded_file($_FILES['inputArchivo']['tmp_name'], $uploadfile);

            $sql = "INSERT INTO apunte (author, title, description, state, filename, pathfile, id_revisor, fecha_subida )VALUES (" . $_SESSION['s_id'] . ", '$title', '$description', 'preparado', '$nombre_original', 'apuntes', 1, '$fecha');";
            $result = mysql_query($sql, $conexion);

            mysql_close($conexion);
        } else {
            $error_2 = "El archivo no puede pesar más de 5MB y su extensión debe ser .pdf";
        }
    }
} else {
    $error_2 = "Tienes que elegir un archivo.<br/>"
            . "Además recuerda que el campo Título y Descripción del formulario de subir apuntes son obligatorio.";
}
?>