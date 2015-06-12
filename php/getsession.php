<?php

if(isset($_SESSION['s_username'])){
    return 1;
}else{
    return 0;
}
exit();
?>
