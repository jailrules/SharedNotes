<?php
if(isset($_REQUEST['comprar'])){
    $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
    mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");
    //POR CADA MATERIAL DEL CARRITO
    $query = "SELECT id_material FROM cesta WHERE id_user=\"" . $_SESSION['s_id'] ."\"";
    $result = mysql_query($query, $conexion) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        //DEBEMOS ACTUALIZAR SU ESTADO A VENDIDO DE TODOS LOS MATERIALES
        while ($rs = mysql_fetch_array($result)) {
            $sql="UPDATE material SET vendido=1 WHERE id_material=$rs[0]";
            $resultado = mysql_query($sql, $conexion) or die(mysql_error());
        }
    }
    //BORRAR EL CARRITO DEL USUARIO
    
    $sql="DELETE FROM cesta WHERE id_user=\"".$_SESSION['s_id']."\"";
    $resultado = mysql_query($sql, $conexion) or die(mysql_error());
    echo'<script>window.alert("¡GRACIAS POR SU COMPRA!")</script>';
}
?>

