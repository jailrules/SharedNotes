<?php

if (isset($_REQUEST['confElimApunte'])) {
    $apunte = $_REQUEST['confElimApunte'];
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");

    //Eliminando el archivo del servidor
    $sql = "SELECT filename FROM apunte WHERE id_apunte = '.$apunte.'";
    $result = mysql_query($sql, $conexion) or die("Error en: $sql: " . mysql_error());
    if ($rs = mysql_fetch_array($result)) {
        $dato = $rs[0];
        unlink("apuntes/".$dato);
    }


    //Eliminando apunte de la BBDD
    $sql = 'DELETE FROM apunte WHERE id_apunte=' . $apunte . '';
    $result2 = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_close($conexion);
    echo'<script>window.alert("Apunte eliminado")</script>';
    echo "<script language='javascript'>window.location='misapuntes.php'</script>";
}

?>

