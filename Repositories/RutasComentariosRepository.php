<?php
    namespace Repositories;
    use Lib\DataBase;
    use PDOException;
    use PDO;
    class RutasComentariosRepository{
        // Creamos atributo de la clase usando la clase DataBase
        private DataBase $conection;
        // Creamos atributo con valor mixed
        private mixed $sql;
        function __construct(){
            // Instanciamos la clase
            $this->conection = new DataBase();
        }
        public function findAll(int $id_ruta):?array {
            $rutaCommit = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM rutas_comentarios WHERE id_ruta = :id_ruta");
                $this->sql->bindValue(":id_ruta", $id_ruta);
                $this->sql->execute();
                $rutaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $rutaCommit = $rutaCommitData ?: null;
            } catch (PDOException $e) {
                $rutaCommit = $e->getMessage();
            }
            return $rutaCommit;
        }
        /**
         * Función para añadir un comentario
         * 
         * @param array $data con los datos del comentarios añadir
         * @return string en caso de error lo muestra
         */
        public function addCommit(array $data):?string {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO rutas_comentarios(id_ruta,id_usuario,nombre,texto,fecha) VALUES (:id_ruta,:id_usuario,:nombre,:texto,:fecha);");
                $this->sql->bindValue(":id_ruta",$data['id_ruta']);
                $this->sql->bindValue(":id_usuario",$data['id_usuario']);
                $this->sql->bindValue(":nombre",$data['usuario']);
                $this->sql->bindValue(":texto",$data['text']);
                $this->sql->bindValue(":fecha",$data['fecha']);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        /**
         * Función para borrar un comentario de la ruta
         * 
         * @param int $id con la id del comentario a borrar
         * @return string en caso de error lo muestra
         */
        public function delete(int $id):?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM rutas_comentarios WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }