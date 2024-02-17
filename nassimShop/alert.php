<?php
if (isset($success_msg)) {
    foreach($success_msg as $success_msg){
        echo '<script>swal("'.$success_msg.'", "", "success");</script>';
    }
}
?>