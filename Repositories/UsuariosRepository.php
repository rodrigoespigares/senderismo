<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Usuarios;
    use DateTime;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        // Creamos atributo de la clase usando la clase DataBase
        private DataBase $conection;
        // Creamos atributo con valor mixed
        private mixed $sql;
        function __construct(){
            // Instanciamos la clase
            $this->conection = new DataBase();
        }
        /**
         * Función para obtener todos los usuarios
         * 
         * @return array en caso de que no haya error 
         */
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM usuarios;");
            return $this->extractAll();
        }
        /**
         * Función para obtener todas los registros
         * 
         * @return array en caso de que no haya error 
         */
        public function extractAll():?array {
            $usuarios = [];
            try{
                $this->conection->querySQL("SELECT * FROM usuarios");
                $usuariosData = $this->conection->allRegister();
                foreach ($usuariosData as $usuarioData){
                    $usuarios[]=Usuarios::fromArray($usuarioData);
                }
            }catch(PDOException){
                $usuarios=null;
            }
            return $usuarios;
        }
        /**
         * Función para crear un nuevo usuario
         * 
         * @param string $usuario con el nombre de usuario
         * @param string $contrasena con la contraseña del usuario
         * @param string $nombre con el nombre del usuario
         * @param string $apellidos con los apellidos del usuario
         * @param string $email con el email del usuario
         * @param string $fecha_nacimiento con la fecha de nacimiento del usuario
         * @param string $movil con el movil del usuario
         * 
         * @return string en caso de que haya error 
         */
        public function registro(string $usuario,string $contrasena,string $nombre,string $apellidos,string $email,string $fecha_nacimiento,string $movil):?string{
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(usuario,contrasena,nombre,apellidos,email,fecha_nacimiento,movil,rol) VALUES (:usuario,:contrasena,:nombre,:apellidos,:email,:fecha_nacimiento,:movil,:rol);");
                $rol = "user";
                $fechaObjeto = DateTime::createFromFormat('d-m-Y', $fecha_nacimiento);
                // Obtener la fecha en el nuevo formato yyyy-mm-dd
                $fechaFormateada = $fechaObjeto->format('Y-m-d');
                $this->sql->bindValue(":usuario",$usuario);
                $this->sql->bindValue(":contrasena",$contrasena);
                $this->sql->bindValue(":nombre",$nombre);
                $this->sql->bindValue(":apellidos",$apellidos);
                $this->sql->bindValue(":email",$email);
                $this->sql->bindValue(":fecha_nacimiento",$fechaFormateada);
                $this->sql->bindValue(":movil",$movil);
                $this->sql->bindValue(":rol",$rol);
                $this->sql->execute();
                $this->sql->closeCursor();
                $this->sql = null;
                
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            return $result;
        }
        /**
         * Función para obtener todos los datos de un usuario con el email
         * 
         * @param string $email con el email del usuario
         * 
         * @return array devolverá un array si no hay errores
         * 
         */
        public function getIdentity(string $email) :?array{
            $usuario = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE email = :email");
                $this->sql->bindValue(":email", $email);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
            return $usuario;
        }
        /**
         * Función para obtener todos los datos de un usuario con el id
         * 
         * @param int $id con el id del usuario
         * 
         * @return array devolverá un array si no hay errores
         */
        public function getIdentityId(int $id) :?array{
            $usuario = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
            return $usuario;
        }
        /**
         * Función para eliminar un usuario con el id
         * 
         * @param int $id con el id del usuario
         * 
         * @return string en caso de que haya error 
         */
        public function removeUser(int $id):?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM usuarios WHERE id = :id;");
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
         * Función cambiar el rol del usuario con el id
         * 
         * @param int $id con el id del usuario
         * @param string $rol con el nuevo rol del usuario
         * 
         * @return string en caso de que haya error 
         */
        public function update(int $id,string $rol) :?string {
            $result = "";
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET rol=:rol WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":rol",$rol);
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
         * Función actualizar cuando el usuario podrá poner un nuevo comentario
         * 
         * @param int $id con el id del usuario
         * @param string $data con la fecha cuando el usuario podrá comentar de nuevo
         * 
         * @return string en caso de que haya error 
         */
        public function addCommit(int $id,string $date) :?string {
            $result = "";
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET ultimo_Commit=:fecha WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":fecha",$date);
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