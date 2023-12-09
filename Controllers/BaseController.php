<?php
    namespace Controllers;
    use Services\UsuariosService;
    use Services\RutasService;
    use Services\RutasComentariosService;
    use Models\Rutas;
    use Lib\Pages;
    use Models\RutasComentarios;
    use DateTime;
    use DateInterval;

    class BaseController{
        // Creamos atributo del servicio Usuarios
        private UsuariosService $userService;
        // Creamos atributo del servicio Rutas
        private RutasService $ruteService;
        // Creamos atributo del servicio Comentarios de Rutas
        private RutasComentariosService $ruteCommitService;
        // Creamos la variable de la clase Pages
        private Pages $pages;
        /**
         * Constructor de la clase sin parámetros
         */
        public function __construct(){
            # Instaciamos las clases
            $this->userService = new UsuariosService();
            $this->ruteService = new RutasService();
            $this->ruteCommitService = new RutasComentariosService();
            $this->pages = new Pages();
        }
        /**
         * Función por defecto de la clase que mostrara los datos de las tablas
         * 
         * @return void
         */
        public function showPage():void{
            // Obtenemos todas las rutas
            $rutas = $this->ruteService->allRutas();
            // Contamos las rutas
            $count = $this->ruteService->countRutas();
            // Obtenemos la distancia máxima
            $maxDistancia = $this->ruteService->maxDistancia();
            // Mostramos los datos introducidos
            $this->pages->render("pages/base/showRutes",["rutas"=>$rutas,"contador"=>$count, "distancia"=>$maxDistancia]);
        }
        /**
         * Función para crear una nueva ruta
         * 
         * @return void
         */
        public function newRute():void{
            // Entra cuando el dato es rellenado
            if(isset($_POST['data'])){
                // Se crea el array con los errores
                $errores = [];
                // Se asignan a una variable más cómoda de tratar
                $ruta = $_POST["data"];
                // Se validan los datos
                Rutas::validar($ruta,$errores);
                // Si no hay errores:
                if (empty($errores)){
                    // se guarda el id del usuario
                    $ruta['id_user']=$_SESSION['identity']['id'];
                    // Se añade una nueva ruta
                    $this->ruteService->addRuta($ruta);
                    // Se vuelve a la pagina principal
                    header("Location:".BASE_URL);
                // Si hay errores:
                }else{
                    // Vuelve al formulario y muestra los errores y rellena los datos introducidos
                    $this->pages->render("pages/base/formRute",["errores"=>$errores,"relleno"=>$_POST["data"]]);
                }
            // Muestra el formulario para crear una nueva ruta
            }else{
                $this->pages->render("pages/base/formRute");
            }
        }
        /**
         * Función para gestionar las opciones de una ruta en la página principal
         * 
         * @return void
         */
        public function options() :void {
            // Si es editar
            if(isset($_POST['editar'])){
                // Muestra el formulario de editar y manda la id de la ruta
                $this->pages->render("pages/editar/editar",["id"=>$_POST['editar']]);
            // Si es eliminar
            }elseif(isset($_POST['delete'])){
                // Borra la ruta
                $this->ruteService->delete($_POST['delete']);
                // Vuelve a la pagina principal
                header("Location:".BASE_URL);
            // Si son los comentarios
            }elseif(isset($_POST['commit'])){
                // Muestra la página de los comentarios mandando la id de la ruta
                $this->pages->render("pages/detalle/informacion",["id"=>$_POST['commit']]);
            }
        }
        /**
         * Función que devuelve un JSON con los datos y comentarios de la ruta
         * 
         * @return void
         */
        public function getDataAndCommit():void {
            // Datos de la ruta
            $dataRute = $this->ruteService->getData($_GET['id']);
            // Comentarios de la ruta
            $commits = $this->ruteCommitService->searchRutaId($_GET['id']);
            // Devuelve la ruta con los comentarios en JSON
            $this->pages->converter(["ruta"=>$dataRute,"comentarios"=>$commits]);
        }
        /**
         * Función que añade un comentario
         * 
         * @return void
         */
        public function addCommit():void {
            // Si devuelve datos
            if(isset($_POST['data'])){
                // Array vacio
                $errores = [];
                // Asigna el texto a la variable comentarios
                $comentario = $_POST["data"]['text'];
                // Obtiene la fecha actual
                $fechaActual = new DateTime();
                // Obtiene el intervalo de un día
                $intervalo = new DateInterval('P1D');
                // Añade un dia
                $fechaManana = $fechaActual->add($intervalo);
                // Añade una variable al array
                $_POST['data']['comment'] = $fechaManana->format('Y-m-d H:i:s');
                // Valida el comentario por el usuario
                RutasComentarios::validar($comentario,$errores);
                // Si no hay errores
                if (empty($errores)){
                    // Asigna una nueva variable al array de la sesion
                    $_SESSION['identity']['ultimo_Commit'] = $_POST['data']['comment'];
                    // Asigna la fecha de hoy
                    $_POST['data']['fecha'] = date("Y-m-d");
                    // Asigna el id del usuario
                    $_POST['data']['id_usuario'] = $_SESSION['identity']['id'];
                    // Asigna el nombre del usuario
                    $_POST['data']['usuario'] = $_SESSION['identity']['usuario'];
                    // Añade el comentario
                    $this->ruteCommitService->addCommit($_POST['data']);
                    // Modifica la fecha del ultimo usuario
                    $this->userService->addCommit($_POST['data']['id_usuario'],$_POST['data']['comment']);
                    // Muestra la ruta con el comentario actualizado
                    $this->pages->render("pages/detalle/informacion",["id"=>$_POST['data']['id_ruta']]);
                }else{
                    // Muestra la ruta con errores
                    $this->pages->render("pages/detalle/informacion",["errores"=>$errores, "id"=>$_POST['data']['id_ruta']]);
                }
            }else{
                // Vuelve a la pantalla principal
                $this->showPage();
            }
        }
        /**
         * Función para las opciones de un comentario
         * 
         * @return void
         */
        public function optionsCommit() : void {
            // Si hace clic en borrar
            if(isset($_POST['delete'])){
                // Borra el comentario
                $this->ruteCommitService->delete($_POST['delete']);
                // Muestra la pagina con los datos de los comentarios
                $this->pages->render("pages/detalle/informacion",["id"=>$_POST['id_ruta']]);
            }else{
                // Vuelve a la pricipal
                $this->showPage();
            }
        }
        /**
         * Funcion que valida si se edita una Ruta
         * 
         * @return void
         */
        public function vEdit() : void {
            //Asigna el la variable a una mas legible
            $data = $_POST;
            // Cambia de titulo a title
            $data['title']=$data['titulo'];
            // Cambio de descripcion a description
            $data['description']=$data['descripcion'];
            // Array de errores
            $errores =[];
            // Se validan los datos
            Rutas::validar($data,$errores);
            // Si no hay errores
            if(empty($errores)){
                // Se edita
                $this->ruteService->edit($data);
                // Vuelve a la principal
                header("Location:".BASE_URL);
            }else{
                // Muestra los errores
                $this->pages->render("pages/editar/editar",["errores"=>$errores, "id"=>$data['editar']]);
            }
        }
        /**
         * Función que busca dentro de la tabla por la seleccion del usuario
         *
         * 
         * @return void
         */
        public function search(): void
        {
            // Obtiene la busqueda
            $resultado = $this->ruteService->buscar($_POST['option'],$_POST['search']);
            // Cuenta el total de rutas
            $count = $this->ruteService->countRutas();
            // muesta la distancia
            $maxDistancia = $this->ruteService->maxDistancia();
            // Muestra la pagina de busquedas
            $this->pages->render('pages/base/showSearch', ['rutas' => $resultado,"contador"=>$count, "distancia"=>$maxDistancia]);
        }
    }
