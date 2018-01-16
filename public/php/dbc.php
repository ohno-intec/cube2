<?php
function DBC(){
    $server_name = $_SERVER['SERVER_NAME'];
    if($server_name == env("LOCALHOST")){
        return mysqli_connect(env("LOCALHOST"), env("LOCAL_DB_USER"), env("LOCAL_DB_PASSWORD") ,env("LOCAL_DB_NAME"));
    }elseif($server_name == env("HOST_NAME")){
        return mysqli_connect(env("DB_HOST"), env("DB_USERNAME"), env("DB_PASSWORD"), env("DB_DATABASE"));
    }
}
?>