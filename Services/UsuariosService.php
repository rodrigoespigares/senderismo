<?php

namespace Services;

use Repositories\UsuariosRepository;

class UsuariosService
{
    // Creamos atributo de la clase usando la clase UsuariosRepository
    private UsuariosRepository $userRepository;
    function __construct()
    {
        //Instanciamos la clase
        $this->userRepository = new UsuariosRepository();
    }
    /**
     * Función para devolver todas los usuarios
     * 
     * @return array en caso de que haya resultados
     */
    public function allUsers(): ?array
    {
        return $this->userRepository->findAll();
    }
    /**
     * Función para crear un nuevo usuario
     * 
     * @param string $usuario con el nombre de usuario del usuario
     * @param string $contrasena con la contraseña del usuario
     * @param string $nombre con el nombre del usuario
     * @param string $apellidos con los apellidos del usuario
     * @param string $email con el email del usuario
     * @param string $fecha_nacimiento con la fecha de nacimiento del usuario
     * @param string $movil con el numero telefonico del usuario
     * 
     * @return string en caso de error
     * @return null en caso de que sea correcto
     */
    public function register(string $usuario, string $contrasena, string $nombre, string $apellidos, string $email, string $fecha_nacimiento, string $movil): ?string
    {
        return $this->userRepository->registro($usuario, $contrasena, $nombre, $apellidos, $email, $fecha_nacimiento, $movil);
    }
    /**
     * Función para obtener los datos de un usuario
     * 
     * @param string $email con los datos del usuario
     * 
     * @return array devolverá un array si no da error
     */
    public function getIdentity(string $email) :? array
    {
        return $this->userRepository->getIdentity($email);
    }
    /**
     * Función para obtener los datos de un usuario
     * 
     * @param int $id con el id del usuario
     * 
     * @return array devolverá un array si no hay errores
     */
    public function getData(int $id):?array
    {
        return $this->userRepository->getIdentityId($id);
    }
    /**
     * Función para eliminar un usuario
     * 
     * @param int $id con el id del usuario
     * 
     * @return string en caso de error
     * @return null en caso de que sea correcto
     */
    public function removeUser(int $id): ?string
    {
        return $this->userRepository->removeUser($id);
    }
    /**
     * Función para actualizar el rol del usuario
     * 
     * @param int $id con el id del usuario
     * @param string $rol con el nuevo rol del usuario
     * 
     * @return string en caso de error
     * @return null en caso de que sea correcto
     */
    public function update(int $id, string $rol): ?string
    {
        return  $this->userRepository->update($id, $rol);
    }
    /**
     * Función para actualizar el último comentario
     * 
     * @param int $id con el id del usuario
     * @param string $date con la fecha cuando podrá introducir un nuevo comentario
     * 
     * @return string en caso de error
     * @return null en caso de que sea correcto
     */
    public function addCommit(int $id, string $date): ?string
    {
        return $this->userRepository->addCommit($id, $date);
    }
}
