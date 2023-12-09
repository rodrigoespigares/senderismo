<?php

namespace Models;

use Models\Validar;

class Usuarios
{
    protected static $errores;
    public function __construct(
        // Atributos de la clase Usuarios
        private string|null $id = null,
        private string $usuario,
        private string $contrasena,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $fecha_nacimiento,
        private string $movil,
        private string $rol,
        private string $lastCommit
    ) {
    }
    /**
     * Obtiene el valor del id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Cambia el valor del id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el valor del usuario
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * Cambia el valor del usuario
     */
    public function setUsuario(string $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * Obtiene el valor del contrasena
     */
    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    /**
     * Cambia el valor del contrasena
     */
    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    /**
     * Obtiene el valor del nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Cambia el valor del nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Obtiene el valor del apellidos
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * Cambia el valor del apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Obtiene el valor del email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Cambia el valor del email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Obtiene el valor del fecha_nacimiento
     */
    public function getFechaNacimiento(): string
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Cambia el valor del fecha_nacimiento
     */
    public function setFechaNacimiento(string $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * Obtiene el valor del movil
     */
    public function getMovil(): string
    {
        return $this->movil;
    }

    /**
     * Cambia el valor del movil
     */
    public function setMovil(string $movil): void
    {
        $this->movil = $movil;
    }

    /**
     * Obtiene el valor del rol
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Cambia el valor del rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }
    /**
     * Obtiene el valor del rol
     */
    public function getLastCommit(): string
    {
        return $this->rol;
    }

    /**
     * Cambia el valor del rol
     */
    public function setLastCommit(string $lastCommit): void
    {
        $this->lastCommit = $lastCommit;
    }
    /**
     * Función para crea un usuario a partir de un array
     * 
     * @return Usuarios
     */
    public static function fromArray(array $data): Usuarios
    {
        return new Usuarios(
            $data['id'] ?? null,
            $data['usuario'] ?? '',
            $data['contrasena'] ?? "",
            $data['nombre'] ?? '',
            $data['apellidos'] ?? "",
            $data['email'] ?? "",
            $data['fecha_nacimiento'] ?? '',
            $data['movil'] ?? "",
            $data['rol'] ?? "user",
            $data['lastCommit'] ?? "",
        );
    }
    /**
     * Función para validar un nuevo usuario
     * 
     * @param array data con los datos para sanear y validar
     * @param array errores que sera modificado si hay errores
     * @param array arrayUsuarios array con todos los usuarios registrados para validar que no repite el nombre
     * @param array arrayUsuarios array con todos los usuarios registrados para validar que no repite el nombre
     * 
     * @return array
     */
    public static function validation(array $data, array &$errores, array $arrayUsuarios, array $arrayEmail): array
    {
        ############### ASIGNO VARIABLES ###############
        $user = $data['user'];
        $pass1 = $data['password'];
        $pass2 = $data['password2'];
        $email = $data['email'];
        $name = $data['name'];
        $subname = $data['subname'];
        $date = $data['date'];
        $movil = $data['movil'];
        ############### VALIDO ###############
        ##############
        #    USER    #
        ##############
        if (empty($user)) {
            $errores['usuario'] = "Usuario campo obligatorio";
        } elseif(Validar::validar_array($user, $arrayUsuarios)){
            $errores['usuario']="Usuario registrado";
        }elseif (strlen($user) < 4) {
            $errores['usuario'] = "Usuario debe tener más de 4 caracteres";
        } elseif (!Validar::son_letras($user)) {
            $errores['usuario'] = "Usuario tiene caracteres no permitidos";
        }
        ##############
        #  PASSWORD  #
        ##############
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        } elseif ($pass1 != $pass2) {
            $errores['password'] = "Las contraseñas no coinciden";
            $errores['password2'] = "Las contraseñas no coinciden";
        }
        if (strlen($pass1) <= 8) {
            $errores['password'] = "Contraseña debe tener más de 8 caracteres";
        }
        #Comprobar que tenga una buena forma;
        ##############
        #   EMAIL    #
        ##############
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif(Validar::validar_array($email, $arrayEmail)){
            $errores['email']="Email registrado";
        }elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        ##############
        #    NAME    #
        ##############
        if (empty($name)) {
            $errores['name'] = "Nombre obligatorio";
        } elseif ( !Validar::son_letras($name)) {
            $errores['name'] = "Nombre tiene caracteres extraños";
        }
        ##############
        #  SUBNAME   #
        ##############
        if (empty($subname)) {
            $errores['subname'] = "Apellidos obligatorios";
        } elseif (!Validar::son_letras($subname)) {
            $errores['subname'] = "Apellidos tiene caracteres extraños";
        }
        ##############
        #    DATE    #
        ##############
        if (empty($date)) {
            $errores['date'] = "Fecha de nacimiento obligatoria";
        } elseif( !Validar::validarFecha($date)){
            $errores['date'] = "Fecha incorrecta";
        }
        ##############
        #    MOVIL   #
        ##############
        if (empty($movil)) {
            $errores['movil'] = "Movil obligatorio";
        } elseif(!Validar::esNumero($movil)){
            $errores['movil'] = "Formato de número incorrecto";
        }


        return $errores;
    }
    /**
     * Función para validar un nuevo usuario cuando hace el login
     * 
     * @param array data con los datos para sanear y validar
     * @param array errores que sera modificado si hay errores
     * 
     * @return array
     */
    public static function validationLogin(array $data,array &$errores) : array {
        ############### VALIDA ###############
        $pass1 = $data['password'];
        $email = $data['email'];
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        }
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        return $errores;
    }
}
