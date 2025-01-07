<?php


// if(isset($_POST['update_password'])){
//             print_r($_POST);
// }



// if (isset($_GET['message'])) {
//     print_r($_GET);
// }

if (isset($_GET['message'])  &&  isset($_GET['change_password'])) {
    $edit_before = false;
    $edit_after = false;
    $change_password = true;
    print_r($_GET);
}


?>