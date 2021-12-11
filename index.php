<?php

require('./controlador/controlador.php');
//require_once 'mercadopago.php';

//VER => IPN Y WEEBHOOK

$productos = mostrar_productos();


?>

<!DOCTYPE html>
<html lang="en">
<head>
	 <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Finca</title>
        <!-- Favicon-->
        <link rel="icon" type="im/x-icon" href="img/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
</head>
<body>
	     <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container px-4 px-lg-5">
                  <div>
                      <a href="">
                      <img class ="logo" src="img/logo-aletheia.png" alt="" width="70px">
                      </a>
                  </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-3" id="navbarSupportedContent">
                  <div class="">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class=" nav-item lista-nav"><a class="nav-link" href="#nos" aria-current="page" href=""><strong>Sobre nosotros</strong></a></li>
                        <li class="nav-item lista-nav"><a class="nav-link" href="#preg"><strong>Preguntas</strong></a></li>
                        <li class="nav-item lista-nav nav-items"><a class="nav-link" href="#prod"><strong>Productos</strong></a></li>
                        <li class="nav-item lista-nav nav-items"><a class="nav-link" href="#cont"><strong>Contacto</strong></a></li>
                  </div>

                <?php if(!isset($_SESSION['email'])) {?>

                        <span id="log" class="nav-item lista-nav usuario-nav" data-bs-toggle="modal" data-bs-target="#exampleModal"><a class="nav-link"><i class="fas fa-sign-in-alt"></i> Iniciar sesion</a></span>
                        <span id="reg" class="nav-item lista-nav usuario-nav2" data-bs-toggle="modal" data-bs-target="#registro"><a class="nav-link"><i class="fas fa-user-plus"></i> Crear cuenta</a></span>
                        <br>
                          <div class="d-flex" data-bs-toggle="modal" data-bs-target="#modal-carrito">
                            <div class="btn btn-outline-dark button-cart">
                                <i class="bi-cart-fill me-1"></i>
                                <span class="badge bg-dark text-white ms-1 rounded-pill">
                                  <?php echo (empty($_SESSION['carrito']))?0:count($_SESSION['carrito']) ?>
                                </span>
                            </div>
                          </div>
                        <!-- Modal carrito -->
                      <div class="modal fade" id="modal-carrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                              <div class="text-center alert alert-success">
                                    <p> El carrito está vacío </p>
                              </div>
                          </div>
                        </div>
                      </div>       
                </div>
                    <!-- Modal Login-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                      <form action ="" method ="POST">
                          
                                          <!-- email-->
                                          <div class="form-group">
                                            <label for="email" class="text-dark">Email</label>
                                            <input type="email" name="email" class="form-control" id="emailLog" aria-describedby="emailHelp" placeholder="Ingresa tu email" required>
                                            <!-- <p id="errorEmailLogin"></p> -->
                                          </div>
                                          <br>
                                          <!-- password-->
                                          <div class="form-group">
                                            <label for="password" class="text-dark">Contraseña</label>
                                            <input type="password" name ="password" class="form-control" id="passLog" placeholder="Ingresa tu contraseña" required>
                                            <!-- <p id="errorPassLogin"></p> -->
                                          </div>
                                          <br>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" name="btnLogin" class="btn btn-primary">Iniciar sesión</button>
                                          </div>
                                      </form>
                                    </div>
                                </div>
                              </div>
                            </div>
                        <!-- Modal Registro-->                     
                            <div class="modal fade" id="registro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Crear cuenta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" id="registro">
                                              <!-- nombre-->
                                              <div class="form-group">
                                               <p id="message"></p> 

                                                <label for="nombre" class="text-dark">Nombre</label>
                                                <input type="text" name ="nombre" id="nombre" class="form-control" value="" placeholder="Ingresa tu nombre">
                                                <p id="errorName"></p>
                                                <label for="apellido" class="text-dark">Apellido</label>
                                                <br>
                                                <input type="text" name ="apellido" id ="apellido" class="form-control" value="" placeholder="Ingresa tu apellido">
                                                <p id="errorApellido"></p>
                                                <!-- email-->
                                                <label for="email" class="text-dark">Email</label>
                                                <input type="email"  name ="email" id="emailUsuario" class="form-control" value="" aria-describedby="emailHelp" placeholder="Ingresa tu email">
                                                <p id="errorEmail"></p>
                                              </div>
                                              <!-- password-->
                                              <div class="form-group">
                                                <label for="password" class="text-dark">Contraseña</label>
                                                <input type="password" name="password" id ="passUsuario" class="form-control" value="" placeholder="Ingresa tu contraseña">
                                                <p id="errorPass"></p>
                                              </div>
                          
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" name="btnReg" value="enviar" id="btn-registro" class="btn btn-primary">Enviar</button>
                                              </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    </ul>

                <?php }else{?>

                      <?php echo '¡Hola '. $_SESSION['email'] . '!';?>

                      <form class="d-flex" data-bs-toggle="modal" data-bs-target="#modal-carrito">
                          <div class="btn btn-outline-dark button-cart">
                              <i class="bi-cart-fill me-1"></i>
                              <span class="badge bg-dark text-white ms-1 rounded-pill">
                                <?php echo (empty($_SESSION['carrito']))?0:count($_SESSION['carrito']) ?>
                              </span>
                          </div>
                    </form>
                         <!-- Modal carrito -->
                        <div class="modal fade" id="modal-carrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Carrito de compras</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                        <!-- Modal detalle del carrito -->
                            <div class="modal-body">
                                <?php if (!empty($_SESSION['carrito'])){ ?>
                                      <table class="table align-middle table-responsive-sm">
                                        <thead>
                                          <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col"></th>
                                          </tr>
                                        </thead>
                                        <tbody class="">
                                          <?php $total = 0;?>
                                          <?php foreach($_SESSION['carrito'] as $indice=>$producto){?>
                                              <tr>
                                                <th scope="row"></th>
                                                <td><img src="img/<?php echo $producto['imagen'];?>" width="100px"/> <?php echo $producto['nombre_producto'];?></td>
                                                
                                                <td><?php echo $producto['cantidad'];?></td>
                                                <td>$<?php echo $producto['precio'];?></td>
                                                <td>$<?php echo $producto['precio'] * $producto['cantidad'];?></td>
                                                <td>
                                                  <form action="" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $producto['id'];?>">
                                                  <button class="btn btn-danger" name="btnEliminar" value="Eliminar" type="submit"><i class="fas fa-trash-alt"></i></button>
                                                  </form>
                                                </td>
                                              </tr>
                                            <tr class="text-center"> 
                                          <?php $total = $total + ($producto['precio'] * $producto['cantidad']);?>                                     
                                          <?php } ?>
                                            </tr>
                                          <tr>
                                            <td scope="col"><h4>Total</h4></td>
                                            <td scope="col"><h5>$<?php echo $total; ?></h5></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                <?php }else{
                                      echo '<div class="text-center alert alert-success">El carrito está vacío</div>';
                                ?>
                                <?php } ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="<?php echo $preference->init_point; ?>" class="btn btn-primary">Iniciar compra</a>
                            </div>
                            </div>
                        </div>
                        </div>
                      <a  class="logout" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                    <?php } ?>
                </div>
        </nav>

    <?php if (isset($_POST['btnReg'])) {
         $mensaje;  
    }else{
         $mensaje;
  }
     ?>

<?php if (isset($_POST['btnLogin'])) {
        echo $mensaje;
      }else{
        echo $mensaje;
    }
     ?>

      <?php if (isset($_POST['btnComprar'])) {
         $mensaje;
       }
     ?>
       
    <!-- Encabezado-->
        <header class="bg-dark py-5">
            <div class=" container  px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 text-white fw-bolder">Finca Aletheia</h1>
                </div>
            </div>
        </header>
     <!-- Sobre nosotros-->
        <section id="nos" class="py-5">
            <div class="container px-4 px-lg-5 my-5">
              <div class="row">
                     <div class="col-12 col-md-6  text-center">
                    <h2 class="display-5 fw-bolder mb-4 titulo">Sobre nosotros</h2>
                    <h3 id="nomUsuario"></h3>
                    <p class="p-info">Estamos ubicados en el departamento de Lavalle de la provincia de Mendoza. La gran mayoría de nuestra finca está cubierta por olivos y el resto por frutales y una pequeña chacra. </p>
                    <p class="p-info">Las plantaciones se cuidan con esmero, dedicación y realizando buenas prácticas agrícolas. 
                    Así obtenemos frutos de excelsos atributos que son utilizados para elaborar nuestras conservas.</p>  
                    <p class="p-info">El proceso de elaboración es artesanal, el cual se nos ha regalado de la mano de nuestros ancestros y honramos la materia prima en todas las etapas.
                    Contamos con exquisitos aceites de oliva y conservas artesanales sin conservantes ni agregados artificiales y con la habilitación bromatológica correspondiente.</p>
                </div>
                <div class="col-12 col-md-6 mt-4 text-center img-naturaleza" >
                  <img src="img/naturaleza2.jpeg" alt="ramas de árbol de olivo" class="img-nosotros" width="80%" style="border-radius:50%">
                </div>
              </div>
            </div>
         </section> 
         <!-- divisor de secciones-->
            <div class="divider-custom divider-light">
                  <div class="divider-custom-line"></div>
                    <img src="img/aceituna3.png" alt="" width="55px">
                  <div class="divider-custom-line"></div>
            </div>
        <!-- Productos-->
        <section id="prod" >
            <h2 class="fw-bolder text-center ">Nuestros productos</h2>
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row  gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">
              <?php foreach($productos as $producto) {?>
                    <div class="col mb-5 d-flex">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="img/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>" data-toggle="popover" data-trigger ="hover" title="<?php echo $producto['nombre_producto'];?>" data-bs-content="<?php echo $producto['descripcion'];?>"  />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $producto['nombre_producto'];?></h5>
                                    <!-- Product price-->
                                   <p>$<?php echo $producto['precio'];?></p>
                                </div>
                                <!-- Product actions-->
                       <?php if(!isset($_SESSION['email'])) {?>
                            <p type="" name=""  class="close text-center btn btn-dark mt-auto" data-bs-toggle="modal" data-bs-target="#modal-prueba">Agregar al carrito</p>
                            <!-- Modal -->
                                  <div class="modal fade" id="modal-prueba" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Aviso</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                         <h5> Debés registrarte para comprar.</h5>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php }else{?>
                                  <form method="post" class="form-product ">
                                    <input type="hidden" name="id"  value="<?php echo $producto['id'];?>">

                                    <input type="hidden" name="nombre_producto"  value="<?php echo $producto['nombre_producto'];?>">
                                    <input type="hidden" name="imagen"  value="<?php echo $producto['imagen'];?>">

                                    <input type="hidden" name="precio"  value="<?php echo $producto['precio'];?>">
                                      <div class="container">
                                        
                                    <div class="input-group input-group-sm mb-3">
                                      <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad</span>
                                      <input type="number" name="cantidad" class="form-control" aria-label="Sizing example input" value="1" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <!-- <input type="number" name="cantidad"  value="1"> -->
                                    </div>
                                    <div class="container">
                                    <button type="submit" name="btnComprar"  class="form-control close text-center btn btn-dark mt-auto">Agregar al carrito</button>
                                    </div>
                                  </form>
                               <?php } ?>
                            </div>
                        </div>
                    </div>
              <?php } ?>
                </div>
            </div>
        </section>
        <!-- divisor de secciones-->
            <div class="divider-custom divider-light">
                  <div class="divider-custom-line"></div>
                    <img src="img/aceituna3.png" alt="" width="55px">
                  <div class="divider-custom-line"></div>
            </div>  
         <!-- Preguntas frecuentes-->
        <section id="preg">
             <h2 class="fw-bolder text-center">Preguntas frecuentes</h2>
            <div class="container px-4 px-lg-5 my-5">
              <div class="row justify-content-center">
                <div class="col-8 col-md-4">
                  <p class="lead fw-normal fw-bolder mb-0">¿Cómo hacer un pedido?</p>
                  <p class="p-info mt-4"><i class="fas fa-check"></i> Nos contactas por la red que prefieras</p>
                  <p class="p-info"><i class="fas fa-check"></i> Tomamos tu pedido</p>
                  <p class="p-info"><i class="fas fa-check"></i> Cancelas la compra por el medio que te sea más<br>cómodo o al momento de la entrega</p>
                  <p class="p-info"><i class="fas fa-check"></i> Coordinamos la entrega</p>
                </div>
                <div class="col-8 col-md-6">
                  <p class="lead fw-normal fw-bolder mb-0">¿Cómo retirar un pedido?</p>
                  <p class=" p-info mt-4"><i class="fas fa-check"></i> No hay compra mínima</p>
                  <p class="p-info"><i class="fas fa-check"></i> Las compras a partir de $1500  pueden ser entregadas a domicilio en: Guaymallen, Las Heras y Capital</p>
                  <p class="p-info"><i class="fas fa-check"></i> Coordinamos con vos la entrega, según el día asignado a cada departamento</p>
                  <p class="p-info"><i class="fas fa-check"></i> También tenés la opción de retirarlo personalmente por nuestro domicilio en Guaymallen, previo aviso, así te estamos esperando</p>
                </div>
              </div>
            </div>
        </section>
        <!-- divisor de secciones-->
            <div class="divider-custom divider-light">
                  <div class="divider-custom-line"></div>
                    <img src="img/aceituna3.png" alt="" width="55px">
                  <div class="divider-custom-line"></div>
            </div>  
        <!-- Contacto-->
        <section id="cont">
            <div class="container px-4 px-lg-5 my-3">
                <div class="text-center">
                     <h2 class="fw-bolder text-center">Contacto</h2>
                    <a href="https://www.facebook.com/daniel.perea.7528610" target="blank"><i class="m-5 fab fa-facebook fa-3x" style="color: #339af0"></i></a>
                    <a href="https://www.instagram.com/finca.aletheia/" target="blank"><i class="m-5 fab fa-instagram fa-3x" style="color: #f06595;"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=2616137709" target="blank"><i class="m-5 fab fa-whatsapp fa-3x" style="color: #51cf66;"></i></a>
                </div>
            </div>
        </section>
        <!-- Boton scroll-top -->
            <button class="btn-scroll-top hidden">&#11014;</button>
        <!-- Footer-->
        <footer class=" footer py-5">
            <div class="container"><p class="m-0 text-center">Copyright &copy; Website 2021</p></div>
        </footer>
      <!-- JS -->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/b022c73f3f.js" crossorigin="anonymous"></script>
        
        
        
    </body>
</html>
