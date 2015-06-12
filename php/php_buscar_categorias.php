<?php

//include './session.php';

//include './php_conexion.php';

$conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_NAME, $conexion) or die(mysql_error());

$query = "Select nombre from categoria";

$resultado = mysql_query($query, $conexion) or die("Error en: $query: " . mysql_error());

echo '<select name="categoria" id="categoria">';

$name = "Cualquiera";

echo '<option value="'.$name.'"">'.$name.'</option>';

while($data = mysql_fetch_array($resultado)){
    
    //echo $data['nombre'];
    
    $name = $data['nombre'];
    
    echo '<option value="'.$name.'"">'.$name.'</option>';
}

echo '</select>';
         mysql_close($conexion);                              
?>

