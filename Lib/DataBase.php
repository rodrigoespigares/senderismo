<?php
namespace lib;
use PDO;
use PDOException;

class DataBase
{
    // Crea la clase PDO
    private $conexion;
    // Variable para los resultados
    private mixed $result;
    // Variable para asignar el servidor
    private string $server;
    // Variable para asignar el usuario de la base de datos
    private string $user;
    // Variable para asignar la contraseña del usuario
    private string $pass;
    // Variable para asignar el nombre de la base de datos
    private string $data_base;
    function __construct()
    {
        // Se instancian las cariables asignando los valores de la variable globar $_ENV
        $this->server = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->data_base = $_ENV['DB_DATABASE'];
        // Se crea la conexion
        $this->conexion = $this->conect();
    }
    /**
     * Funcion para crear la conexion
     * 
     * @return PDO
     */
    function conect() : PDO {
        try {
            // Array con las opciones de la base de datos
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );
            // Crea la base de datos instanciando de la clase PDO
            $conexion = new PDO("mysql:host={$this->server};dbname={$this->data_base}",$this->user,$this->pass,$opciones);
            // Devuelve la conexion
            return $conexion;
        } catch (PDOException $e) {
            // En caso de error saca el mensaje por la pantalla
            echo "Ha surgido un error y no se puede conectar con la base de datos".$e->getMessage();
            exit;
        }
    }
    /**
     * Función para hacer una consulta
     * 
     * @return void
     */
    public function querySQL(string $querySQL) : void {
        $this->result = $this->conexion->query($querySQL);
    }
    /**
     * Función que obtiene una fila del resultado
     * 
     * @return array
     */
    public function register() :array {
        return ($fila = $this->result->fetch(PDO::FETCH_ASSOC))?$fila:false;
    }
    /**
     * Función que obtiene todos los registros del resultado
     * 
     * @return array
     */
    public function allRegister():array {
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function prepareSQL( $querySQL) {
        return $this->conexion->prepare($querySQL);
    }
    /**
     * Función para cerrar la conexion de la base de datos
     * 
     * @return void
     */
    public function close():void{
        $this->conexion = null;
    }
}