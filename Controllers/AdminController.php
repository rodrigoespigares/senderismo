<?php
    namespace Controllers;
    use Services\UsuariosService;
    use Lib\Pages;
    use Models\Validar;
    class AdminController{
        // Creamos atributo de la clase usando la clase UsuarioService
        private UsuariosService $userService;
        // Creamos la variable de la clase usando la clase Pages
        private Pages $pages;
        public function __construct(){
            # Instaciamos las clases
            $this->userService = new UsuariosService();
            $this->pages = new Pages();
        }
        /**
         * Función que gestiona los usuarios accediendo a los servicios del usuario
         * y recuperando los usuarios de la base de datos y mandandolos a la clase Pages
         *
         * @return void
         */
        public function gestionUsuarios() : void {
            // Recupero los usuarios
            $result = $this->userService->allUsers();
            // Los muestro
            $this->pages->render("pages/admin/gestionUsuarios",["usuarios"=>$result]);
        }
        /**
         * Función que gestiona los usuarios que pueden borrar un usuario o editar el rol de un usuario
         * 
         * @return void
         */
        public function operaciones():void {
            // Gestiona el borrar
            if (isset($_POST['borrar'])) {
                // Borra el usuario
                $this->userService->removeUser($_POST['borrar']);
                // Lo manda a la pagina principal de gestion
                $this->gestionUsuarios();
            // Gestiona el editar
            }elseif(isset($_POST['editar'])){
                // Lo manda al formulario de editar
                $this->pages->render("pages/admin/editarUsuario",["id"=>$_POST['editar']]);
            }
        }
        /**
         * Función que devuelve un JSON con los datos del usuario
         * 
         * @return void
         */
        public function getDataUser():void {
            // Obtiene los datos del usuario con el ID
            $dataUser = $this->userService->getData($_GET['id']);
            // Devuelve los datos del usuario en JSON
            $this->pages->converter(["user"=>$dataUser]);
        }
        /**
         * Funcion para validar el rol editado
         * 
         * @return void
         */
        public function vEdit() :void {
            // Array de errores
            $errores = [];
            // Valida que es correcto el rol introducido
            Validar::validarRol($_POST['rol'],$errores);
            // Si errores esta vacío
            if (empty($errores)) {
                // Cambia el rol del usuario
                $this->userService->update($_POST['editar'],$_POST['rol']);
                // Vuelve a la página inicial
                header("Location:".BASE_URL);
            // En caso de que errores este lleno
            }else{
                // Vuelve y muestra el error
                $this->pages->render("pages/login/formLogin",["errores"=>$errores]);
            }
        }
    }