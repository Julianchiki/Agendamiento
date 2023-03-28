<?php
include "modelo/config.php";

$sql = $con->query("SELECT * FROM citas c INNER JOIN usuario u ON c.id_usuario=u.id");
?>