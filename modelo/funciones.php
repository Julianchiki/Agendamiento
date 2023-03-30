<?php

// Establece la conexión a la base de datos
function obtenerConexion() {
  $servidor = "localhost";
  $usuario = "root";
  $contraseña = "";
  $bd = "agendamiento";
  
  $conexion = new mysqli($servidor, $usuario, $contraseña, $bd);

  if ($conexion->connect_error) {
    die("Falló la conexión a la base de datos: " . $conexion->connect_error);
  }

  return $conexion;
}

function obtenerUsuarioPorId($id) {
  // Realizamos la conexión a la base de datos
  $conexion = mysqli_connect('localhost', 'root', '', 'agendamiento');
  
  // Verificamos que la conexión se haya realizado correctamente
  if (!$conexion) {
    die('Error al conectar a la base de datos');
  }
  
  // Escapamos el ID para evitar inyección de SQL
  $id = mysqli_real_escape_string($conexion, $id);
  
  // Creamos la consulta para obtener los datos del usuario por su ID
  $consulta = "SELECT * FROM users WHERE id = '$id'";
  
  // Ejecutamos la consulta y obtenemos el resultado
  $resultado = mysqli_query($conexion, $consulta);
  
  // Verificamos que se haya obtenido un resultado
  if (mysqli_num_rows($resultado) == 0) {
    return null;
  }
  
  // Obtenemos el primer y único registro del resultado
  $usuario = mysqli_fetch_assoc($resultado);
  
  // Cerramos la conexión a la base de datos
  mysqli_close($conexion);
  
  // Retornamos los datos del usuario
  return $usuario;
}

// Obtiene todos los roles de la base de datos
function obtenerRoles() {
  $conexion = obtenerConexion();

  $query = "SELECT * FROM roles";
  $resultado = $conexion->query($query);

  $roles = array();
  while ($fila = $resultado->fetch_assoc()) {
    $roles[] = $fila;
  }

  $conexion->close();

  return $roles;
}

// Obtiene todos los usuarios de la base de datos
function obtenerUsuarios() {
  $conexion = obtenerConexion();

  $query = "SELECT * FROM users";
  $resultado = $conexion->query($query);

  $usuarios = array();
  while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
  }

  $conexion->close();

  return $usuarios;
}

// Verifica si el usuario actual está autenticado
function estaAutenticado() {
  session_start();
  return isset($_SESSION["username"]);
}


// Verifica si un usuario tiene un permiso específico
function tienePermiso($idUsuario, $permiso) {
  $conexion = obtenerConexion();

  $query = "SELECT * FROM usuarios_roles ur
            INNER JOIN roles_permisos rp ON ur.id_rol = rp.id_rol
            WHERE ur.id_usuario = ? AND rp.permiso = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("is", $idUsuario, $permiso);
  $stmt->execute();

  $resultado = $stmt->get_result();

  $stmt->close();
  $conexion->close();

  return $resultado->num_rows > 0;
}

function obtenerRolPorUsername($username) {
  // Abrir la conexión a la base de datos
  $conexion = obtenerConexion();

  // Escapar el nombre de usuario para evitar inyección de SQL
  $username = mysqli_real_escape_string($conexion, $username);

  // Consultar los roles del usuario
  $query = "SELECT roles.nombre as nombre FROM usuarios_roles
            INNER JOIN roles ON usuarios_roles.id_rol=roles.id 
            WHERE id_usuario = (SELECT id FROM users WHERE username = '$username')";
  $result = mysqli_query($conexion, $query);

  // Crear un array con los roles
  $roles = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row['nombre'];
  }

  // Cerrar la conexión a la base de datos
  $conexion->close();

  // Retornar el array de roles
  return $roles;
}

function obtenerUsuarioPorUsername($username) {
  // Abrimos la conexión a la base de datos
  $conexion = obtenerConexion();

  // Preparamos la consulta SQL para obtener el usuario por su nombre de usuario
  $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("s", $username);

  // Ejecutamos la consulta
  $stmt->execute();
  $result = $stmt->get_result();

  // Cerramos la conexión a la base de datos
  $conexion->close();


  // Si encontramos el usuario, lo retornamos como un arreglo asociativo
  if ($result->num_rows === 1) {
    return $result->fetch_assoc();
  } else {
    return false;
  }
}
// Obtiene los roles de un usuario por su ID
function obtenerRolesPorUsuarioId($idUsuario) {
  $conexion = obtenerConexion();

  $query = "SELECT * FROM usuarios_roles ur
            INNER JOIN roles r ON ur.id_rol = r.id
            WHERE ur.id_usuario = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $idUsuario);
  $stmt->execute();

  $resultado = $stmt->get_result();

  $roles = array();
  while ($fila = $resultado->fetch_assoc()) {
    $roles[] = $fila["nombre"];
  }

  $stmt->close();
  $conexion->close();

  return $roles;
}

// Asigna un rol a un usuario por su ID
function asignarRolAUsuario($idUsuario, $idRol) {
  $conexion = obtenerConexion();

  $query = "INSERT INTO usuarios_roles (id_usuario, id_rol) VALUES (?, ?)";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("ii", $idUsuario, $idRol);
  $stmt->execute();

  $stmt->close();
  $conexion->close();
}

// Elimina todos los roles de un usuario por su ID
function eliminarRolesPorUsuarioId($idUsuario) {
  $conexion = obtenerConexion();

  $query = "DELETE FROM usuarios_roles WHERE id_usuario = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $idUsuario);
  $stmt->execute();

  $stmt->close();
  $conexion->close();
}