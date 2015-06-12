<?php

if (isset($_REQUEST['eliminar'])) {
    if (isset($_SESSION['s_username'])) {
        $id = $_REQUEST['eliminar'];
        $uid = $_SESSION['s_id'];
        $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'");
        $sql = 'DELETE FROM cesta WHERE id_material=' . $id . ' AND id_user=' . $uid . '';
        $result2 = mysql_query($sql, $conexion) or die(mysql_error());
        mysql_close($conexion);
        header("Location: ../carrito.php");
        exit();
    } else {
        //TODO
        $carro=$_SESSION['carro[]'];
        $id=$_REQUEST['eliminar'];
        $aux=array();
        foreach ($carro as $value) {
            if($value!=$id){
                array_push($aux, $value);
            }
        }
        $carro=$aux;
        $_SESSION['carro[]']=$carro;        
        header("Location: ../carrito.php");
        exit();
    }
}
?>
