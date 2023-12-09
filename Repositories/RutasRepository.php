<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Rutas;
    use PDOException;
    use PDO;
    class RutasRepository{
        // Creamos atributo de la clase usando la clase DataBase
        private DataBase $conection;
        // Creamos atributo con valor mixed
        private mixed $sql;
        function __construct(){
            // Instanciamos la clase
            $this->conection = new DataBase();
        }
        /**
         * Función para obtener todas las rutas
         * 
         * @return array en caso de que no haya error 
         */
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM rutas;");
            
            return $this->extractAll();
        }
        /**
         * Función para contar todas las rutas
         * 
         * @return int en caso de que no haya error 
         */
        public function countRutas(): ?int {
            $this->conection->querySQL("SELECT COUNT(*) as total FROM rutas;");
        
            $result = $this->conection->register();
            
            return $result['total'];
        }
        /**
         * Función para encontrar la ruta con mas distancia
         * 
         * @return float en caso de que no haya error 
         */
        public function maxDistancia() :? float {
            $this->conection->querySQL("SELECT MAX(distancia) as total FROM rutas;");
        
            $result = $this->conection->register();
            
            return $result['total'];
        }
        /**
         * Función para extraer todas las rutas
         * 
         * @return array en caso de que no haya error 
         */
        public function extractAll():?array {
            $contactos = [];
            try{
                $contactosData = $this->conection->allRegister();
                foreach ($contactosData as $contactoData){
                    $contactos[]=Rutas::fromArray($contactoData);
                }
            }catch(PDOException){
                $contactos=null;
            }
            return $contactos;
        }
        /**
         * Función para añadir una ruta
         * 
         * @param array $data los datos de la ruta para añadir
         * @return string en caso de que haya error 
         */
        public function addRuta(array $data):?string {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO rutas(id_usuario,titulo,descripcion,desnivel,distancia,notas,dificultad) VALUES (:id_usuario,:titulo,:descripcion,:desnivel,:distancia,:notas,:dificultad);");
                $this->sql->bindValue(":id_usuario",$data['id_user']);
                $this->sql->bindValue(":titulo",$data['title']);
                $this->sql->bindValue(":descripcion",$data['description']);
                $this->sql->bindValue(":desnivel",$data['desnivel']);
                $this->sql->bindValue(":distancia",$data['distancia']);
                $this->sql->bindValue(":dificultad",$data['dificultad']);
                $this->sql->bindValue(":notas",$data['notas']);
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
         * Función para borrar una ruta
         * 
         * @param int $id con el id de la ruta que se quiere borrar
         * @return string en caso de que haya error 
         */
        public function delete(int $id):?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM rutas WHERE id = :id;");
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
        /**
         * Función para obtener los datos de una ruta con el id
         * 
         * @param int $id con el id de la ruta que se quiere obtener la ruta
         *
         * @return array si no hay errores
         */
        public function getData(int $id):?array{
            $ruta = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM rutas WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $rutaData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $ruta = $rutaData ?: null;
                
            } catch (PDOException $e) {
                $ruta = $e->getMessage();
            }
            return $ruta;
        }
        /**
         * Función para editar una ruta
         * 
         * @param int $id con el id de la ruta que se quiere editar la ruta
         *
         * @return string si hay errores
         */
        public function edit(array $data):?string {
            $result = "";
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE rutas SET titulo=:titulo, descripcion=:descripcion, desnivel=:desnivel, distancia=:distancia, notas=:notas, dificultad=:dificultad WHERE id = :id;");
                $this->sql->bindValue(":id",$data['editar']);
                $this->sql->bindValue(":titulo",$data['title']);
                $this->sql->bindValue(":descripcion",$data['description']);
                $this->sql->bindValue(":desnivel",$data['desnivel']);
                $this->sql->bindValue(":distancia",$data['distancia']);
                $this->sql->bindValue(":notas",$data['notas']);
                $this->sql->bindValue(":dificultad",$data['dificultad']);
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
         * Función para buscar las rutas
         * 
         * @param string $opt para la tabla en la que se quiere buscar
         * @param string $search para ver los parametros que se quieren buscar
         *
         * @return array si no hay errores
         */
        public function search(string $opt,string $search) :? array {
            $result =[];
            $resultados =[];
                $this->conection->querySQL("SELECT * FROM rutas;");
                
                $result = $this->conection->allRegister();
                $resultadosData = array_filter($result, function ($element) use ($opt,$search) {
                    $temporal = str_contains(strtolower($element[$opt]), strtolower($search));
                    return $temporal;
                });
                foreach ($resultadosData as $resultadoData){
                    $resultados[]=Rutas::fromArray($resultadoData);
                }
            return $resultados;
        }
    }