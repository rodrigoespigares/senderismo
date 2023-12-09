<?php
    namespace Services;
    use Repositories\RutasRepository;
    class RutasService{
        // Creamos atributo de la clase usando la clase RutasRepository
        private RutasRepository $repository;
        function __construct() {
            // Instanciamos la clase en la variable
            $this->repository = new RutasRepository();
        }
        /**
         * Función para devolver todas las rutas
         * 
         * @return array en caso de que haya resultados
         */
        public function allRutas() :?array {
            return $this->repository->findAll();
        }
        /**
         * Función para añadir una ruta
         * 
         * @param array $data con todos los datos
         * @return void
         */
        public function addRuta(array $data) :void {
            $this->repository->addRuta($data);
        }
        /**
         * Función para contrar las rutas
         * 
         * @return int tras contar las rutas
         */
        public function countRutas() :?int {
            return $this->repository->countRutas();
        }
        /**
         * Función para obtener la distancia máxima
         * 
         * @return float con el resultado
         */
        public function maxDistancia() :? float {
            return $this->repository->maxDistancia();
        }
        /**
         * Función para borrar una ruta
         * 
         * @param int $id con el id de la ruta
         * 
         * @return string si ha ocurrido un error
         * @return null si no hay error
         */
        public function delete($id):? string {
            return $this->repository->delete($id);
        }
        /**
         * Función para borrar una ruta
         * 
         * @param int $id con el id de la ruta
         * 
         * @return array si ha ocurrido un error
         * @return null si no hay error
         */
        public function getData($id):?array {
            return $this->repository->getData($id);
        }
        /**
         * Función para modificar una ruta
         * 
         * @param array $data con los datos a modificar de la ruta
         * 
         * @return void
         */
        public function edit(array $data):void {
            $this->repository->edit($data);
        }
        /**
         * Función para buscar una ruta
         * 
         * @param string $opt para saber por que campo se ha de buscar
         * @param string $search el valor a buscar
         * 
         * @return array con el resultado 
         * @return null si no hay error
         */
        public function buscar(string $opt,string $search) :?array {
            return $this->repository->search($opt,$search);
        }
    }