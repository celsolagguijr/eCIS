<?php
    if(isset($_GET['systemInfo'])) {
        require_once('./includes/Functions/SpecialFunctions.php');
        sec();
        return;
    }

    header("Location: /eCIS/views/");
?>




