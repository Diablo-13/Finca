<?php
session_start();

require('./modelo/modelo.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

	if (isset($_SESSION['nombre'])) {
   		header('location:index.php');
 
 }

//MOSTAR PRODUCTOS
	function mostrar_productos(){
		$conexion = mysqli_connect('localhost', 'root', 'root', 'finca_aletheia');
		$query = "SELECT * FROM productos";
		$resultado = $conexion->query($query);
		$productos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

		mysqli_close($conexion);
		return $productos;
	}

//REGISTRAR USUARIO

	//Filtrado común para los datos
		function filtrarDatos($datos){
			$datos = trim($datos); // Elimina espacios antes y después de los datos
			$datos = stripcslashes($datos); // Elimina backslashes \
			$datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
			return $datos;
		}

	//La función 'filtrarDatos()' se aplica a cada campo del formulario al recibir los datos:

	if (isset($_POST['btnReg'])) {
		$mensaje = "";
		$nombre = filtrarDatos($_POST['nombre']);
		$apellido = filtrarDatos($_POST['apellido']);
		$email = filtrarDatos($_POST['email']);
		$password = filtrarDatos($_POST['password']);
		$password = password_hash($password, PASSWORD_DEFAULT);

	//validacion del formulario de registro
		// $error_nombre = $error_apellido = $error_email = $error_password = '';

		// if(empty($_POST['nombre'])){
        // 	echo $error_nombre = "El nombre es requerido";
    	// }
    	// if(empty($_POST['apellido'])){
        // 	echo $error_apellido = "El apellido es requerido";
    	// }
	    
	    // if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['email'])){
	    //     echo $error_email = "El formato de email es incorrecto";
	    // }
	    // if(empty($_POST["password"]) || strlen($_POST['password']) < 4){
	    //     echo $error_password = "La contraseña es requerida y debe contener más de 4 caracteres";
	    // }

	  //Chequeo que el email ingresado al registrarse no exista en la BD

		$check_email = mysqli_num_rows(mysqli_query($conexion, "SELECT email FROM usuarios WHERE email = '$email'"));
		
			if ($check_email > 0) {
				 	 $mensaje ='<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
					 <strong>El email que ingresaste ya existe</strong>
					 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
					   <span aria-hidden=""></span>
					 </button>
				   </div>';
			}else {
				 $query = "INSERT INTO usuarios (nombre, apellido, email, password) VALUES ('$nombre', '$apellido', '$email', '$password')";
				 $resultado = mysqli_query($conexion, $query);
				 if ($resultado) {
					 	 $mensaje = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
						 <strong>Ya estás registrado/a. Ahora podés iniciar sesión.</strong>
						 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
						   <span aria-hidden=""></span>
						 </button>
					   </div>';
				 	}else {
					//  	$mensaje = '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
					// 	 <strong>Ocurrió un error</strong>
					// 	 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
					// 	   <span aria-hidden=""></span>
					// 	 </button>
					//    </div>';
		}
	}
	mysqli_close($conexion);
}

//LOGIN USUARIO // VALIDAR LA CONTRASEÑA(QUE LA CONTRASEÑA sea igual a la de la BD)

		

		if (isset($_POST['btnLogin'])) {
  // Datos formulario
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Datos true
  if ($email && $password) {

    /**
     * Recuerda tambien añadir tu conexion.
     * 
    */
    
    // Sentencia preparada
    $query = 'SELECT count(*) exist, email, password FROM usuarios WHERE email = ?';
    $stmt = $conexion->prepare($query);
    // Parametros sentencia ?, este caso una string (cadena), por eso pasamos el tipo 's' y su valor
    $stmt->bind_param("s",$email);
    // Ejecutar sentencia
    $stmt->execute();
    // Ligamos resultado
    $stmt->bind_result($exist,$correo,$passwordHash);
    $stmt->fetch();
    $stmt->close();
    // Existe resultado
    if ($exist > 0) {    
      // Verificar contraseña
      if (password_verify($password,$passwordHash)) {
        // Creas sesion
        $_SESSION['email'] =  $correo;
        $_SESSION['password'] =  $passwordHash;

        $mensaje = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                   <strong>¡Bienvenido/a a nuestra Finca!</strong>
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                     <span aria-hidden=""></span>
                   </button>
                 </div>';
        //echo "<script>setTimeout( function() { location.reload() }, 9000 );</script>";
      }else {
        $mensaje = '<div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                   <strong>Contraseña incorrecta</strong>
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                     <span aria-hidden=""></span>
                   </button>
                 </div>';             
      }
    }  else {
      $mensaje = 'Usuario no encontrado';
    } 
  } else {
    $mensaje = 'Problemas con datos POST';
  }  
}



















	// CARRITO DE COMPRAS

	if (isset($_POST['btnComprar'])) {
		$mensaje = "";
		$id = $_POST['id'];
		$producto = $_POST['nombre_producto'];
		$imagen = $_POST['imagen'];
		$precio = $_POST['precio'];
		$cantidad = $_POST['cantidad'];
		
	
		if (!isset($_SESSION['carrito'])) {
			$producto = array(
				'id' => $id,
				'nombre_producto' => $producto,
				'imagen' => $imagen,
				'precio' => $precio,
				'cantidad' => $cantidad
			);
			
			$_SESSION['carrito'][0] = $producto;//almacena el primer producto en la posicion 0
			 $mensaje = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
					<strong>El producto se añadió al carrito</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
					</button></div>';
			
			
			}else{ //pero si tenemos un producto en el carrito
				$numeroProductos = count($_SESSION['carrito']);//contabiliza el carrito de compras
				//recupera los datos del producto ya seleccionado
				//$idProductos=array_column($_SESSION['CARRITO'],"id");   
				$producto = array(
					'id' => $id,
					'nombre_producto' => $producto,
					'imagen' => $imagen,
					'precio' => $precio,
					'cantidad' => $cantidad
				);
				//numero de elementos que obtuvimos al contabilizar la variable de session
				$_SESSION['carrito'][$numeroProductos] = $producto;
				//echo "<script>return false;</script>";
				$mensaje = '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
					<strong>El producto se añadió al carrito</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
					</button></div>';
			}
		}	//	VALIDAR QUE NO SE PUEDA AGREGAR EL PRODUCTO QUE YA ESTA EN EL CARRITO
		//eliminar producto del carrito
		if (isset($_POST['btnEliminar'])) {
			foreach($_SESSION['carrito'] as $indice=>$producto){
				if ($producto['id'] == $_POST['id']) {
					unset($_SESSION['carrito'][$indice]);
					$mensaje = 'El producto se eliminó del carrito';
				}
			}
		}
	

?>

