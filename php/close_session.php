<?php

if (isset($_REQUEST['cerrar'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
