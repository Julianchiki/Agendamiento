<?php

$host = "localhost";
$user = "root";
$clave = "";
$bd = "agendamiento";

$con = new mysqli($host, $user, $clave, $bd);

if($con->connect_errno) {
    echo "Ha ocurrido un error";
}
?>