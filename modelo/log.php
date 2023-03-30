<?php
$conn = mysqli_connect("localhost", "root", "", "agendamiento");

if (isset($_POST['iniciar'])) {
    $username = $_POST['username'];
    $password = $_POST['contrasena'];

    $query = "SELECT * FROM usuario WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['contrasena'])) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['id_rol'];

            header("Location: ../vista/consulta.php");
            exit();
        } else {
            echo "<script> alert('Usuario o contraseña incorrectas.')
                    location.href = '../login.php';</script>";
        }
    } else {
        echo "<script> alert('Usuario no existe en nuestros registros.')
                location.href = '../login.php';</script>";
    }
}


?>
