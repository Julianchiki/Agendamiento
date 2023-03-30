<?php
// Incluimos el archivo que contiene las funciones de autenticación y de acceso a la base de datos
require_once('../modelo/funciones.php');


// Si se ha enviado el formulario, procesamos la asignación de roles
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtenemos el ID del usuario seleccionado y los roles que se han asignado
  $idUsuario = $_POST['usuario'];
  $roles = $_POST['roles'];

  // Eliminamos todos los roles anteriores del usuario
  eliminarRolesPorUsuarioId($idUsuario);

  // Asignamos los nuevos roles al usuario
  foreach ($roles as $rol) {
    asignarRolAUsuario($idUsuario, $rol);
  }

  // Redirigimos a la página de inicio
  header('Location: ../index.php');
  exit;
}

// Obtenemos la lista de usuarios desde la base de datos    
$usuarios = obtenerUsuarios();

// Obtenemos la lista de roles desde la base de datos
$roles = obtenerRoles();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Asignar roles</title>
</head>
<body>
  <h1>Asignar roles</h1>

  <form method="POST">
    <label for="usuario">Usuario:</label>
    <select name="usuario" id="usuario">
      <?php foreach ($usuarios as $usuario): ?>
        <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['username']; ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>

    <label for="roles[]">Roles:</label><br>
    <?php foreach ($roles as $rol): ?>
      <input type="checkbox" name="roles[]" value="<?php echo $rol['id']; ?>"> <?php echo $rol['nombre']; ?><br>
    <?php endforeach; ?>

    <br><br>

    <input type="submit" value="Asignar roles">
  </form>
</body>
</html>