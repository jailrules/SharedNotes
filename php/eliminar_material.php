<?php

if (isset($_REQUEST['confirmareliminarMaterial'])) {
    


    $id = $_REQUEST['confirmareliminarMaterial'];
    
    
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    
    //Eliminar arichivo de fotografía del servidor
    $sql = "SELECT filenamephoto FROM material WHERE id_material = '.$id.'";
    $result = mysql_query($sql, $conexion) or die("Error en: $sql: " . mysql_error());
    if ($rs = mysql_fetch_array($result)) {
        $dato = $rs[0];
        unlink("mat_photo/".$dato);
    }
    
    //Eliminar de la BDA
    $sql = 'DELETE FROM material WHERE id_material=' . $id . '';
    $result2 = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_close($conexion);
    echo "<script language='javascript'>window.location='gestion_material.php'</script>"; 
    exit();
}
?>
