<?php
    namespace Controllers;
    use Services\UsuariosService;
    use Models\Usuarios;
    use Lib\Pages;

    class LoginController{
        // Creamos atributo de la clase UsuarioService
        private UsuariosService $userService;
        // Creamos la variable de la case Pages
        private Pages $pages;
        /**
         * Constructor de la clase sin parámetros
         */
        public function __construct(){
            # Instaciamos las clases
            $this->userService = new UsuariosService();
            $this->pages = new Pages();
        }
        /**
         * Función para mostrar el formulario del login
         * 
         * @return void
         */
        public function login():void{
            // Muestra el formulario
            $this->pages->render("pages/login/formLogin");
        }
        /**
         * Funcion que valida el inicio de sesion y registro
         * 
         * @return void
         */
        public function vLogin():void{
            // Asigna a variable más legible
            $registro = $_POST['data'];            
            
            // Si es falso es porque es registro
            if ($_POST['isLogin']==="false") {
                // Array de errores
                $errores = [];
                // Array para obtener todos los usuarios
                $users = [];
                // Variable para obtener todos los email
                $email = [];
                // Obtiene todos los usuarios
                $usuariosInfo =$this->userService->allUsers();
                // Lo rerecorre
                foreach($usuariosInfo as $usuario){
                    // Introduce el nombre de usuario
                    array_push($users, $usuario->getUsuario());
                    // Introduce el email
                    array_push($email,$usuario->getEmail());
                }
                // Valida los datos, modifica los errores, introduce los usuario y email para comprobar que no existen
                Usuarios::validation($registro,$errores,$users,$email);
                // Si no hay errores
                if (empty($errores)) {
                    // Codifica la contraseña
                    $registro["password"] = password_hash($registro['password'], PASSWORD_BCRYPT,["cost"=>4]);
                    // Registra al usuario
                    $this->userService->register($registro['user'],$registro['password'],$registro['name'],$registro['subname'],$registro['email'],$registro['date'],$registro['movil']);
                    // Vuelve a la pagina principal
                    header("Location:".BASE_URL);
                }else{
                    // Muestra el formulario con los errores y los datos
                    $this->pages->render("pages/login/formLogin",["errores"=>$errores,"datos"=>$registro]);
                }
            // Si es un login
            }elseif ($_POST['isLogin']==="true") {
                // Array de errores
                $error = [];
                // Asigna los datos del usuario a un array
                $identity = $this->userService->getIdentity($registro['email']);
                // Valida los datos
                Usuarios::validationLogin($registro,$error);
                // Comprueba que no hay errores
                if(empty($error)){
                    // Valida que el usuario exita
                    if($identity != null){
                        // Valida que la contraseña es correcta
                        if(password_verify($registro['password'],$identity['contrasena'])){
                            // Se asigna la sesion
                            $_SESSION['identity']=$this->userService->getIdentity($registro['email']);
                            // Si es admin o owner sesion admin es true
                            if($_SESSION['identity']['rol']==="admin" || $_SESSION['identity']['rol']==="owner"){
                                $_SESSION['admin']=true;
                            }else{
                                $_SESSION['admin']=false;
                            }
                            // Vuelve a la principal
                            header("Location:".BASE_URL);
                        // Si no es contraseña
                        }else{
                            // Muestra que la contraseña es incorrecta
                            $error["password"]="Error en la contraseña";
                            // Muestra el formulario con error y datos
                            $this->pages->render("pages/login/formLogin",["error"=>$error,"datos"=>$registro]);
                        }
                    }else{
                        //  Si el email no existe
                        $error['email'] = "Email no registrado";
                        // Muestra el formulario con error y datos
                        $this->pages->render("pages/login/formLogin",["error"=>$error,"datos"=>$registro]);
                    }
                }else{
                    // Si no se introduce contraseña
                    $error['password'] = "Contraseña sin introducir";
                    // Muestra el formulario con error y datos
                    $this->pages->render("pages/login/formLogin",["error"=>$error,"datos"=>$registro]);
                }
            }
        }
        /**
         * Función para cerrar la sesión
         * 
         * @return void
         */
        public function logout():void{
            // Sesión identity a null
            $_SESSION['identity']=null;
            // Sesión admin a null
            $_SESSION['admin']=null;
            // Se destruye la sesión
            session_destroy();
            // Vuelve a la principal
            header("Location:".BASE_URL);
        }
    }