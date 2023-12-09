<?php
    namespace Services;
    use Repositories\RutasComentariosRepository;
    class RutasComentariosService{
        // Creamos atributo de la clase usando la clase RutasComentariosRepository
        private RutasComentariosRepository $repository;
        public function __construct() {
            // Instancian la clase del repositorio
            $this->repository = new RutasComentariosRepository();
        }
        /**
         * Función para buscar una ruta
         * 
         * @param int $id con el id de la ruta a buscar
         * 
         * @return array en caso de no haber errores
         * @return null en caso de error
         */
        public function searchRutaId(int $id):?array {
            return $this->repository->findAll($id);
        }
        /**
         * Funcion para añadir un comentario
         * 
         * @param array $id con los datos a introducir
         * @return string si hay errores
         */
        public function addCommit(array $data):?string {
            return $this->repository->addCommit($data);
        }
        /**
         * Función para borrar una ruta
         * 
         * @param int $id con el id de la ruta a borrar
         * @return string si hay errores
         */
        public function delete(int $id):?string {
            return $this->repository->delete($id);
        }
    }