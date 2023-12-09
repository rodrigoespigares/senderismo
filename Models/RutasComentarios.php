<?php

namespace Models;
use Models\Validar;
class RutasComentarios
{
    public function __construct(
        // Atributos de la clase Rutas Comentarios
        private string|null $id = null,
        private string $id_ruta,
        private string $id_usuario,
        private string $nombre,
        private string $texto,
        private string $fecha
    ) {
    }
    /**
     * Obtiene el valor del of id
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
     * Obtiene el valor del of id_ruta
     */
    public function getIdRuta(): string
    {
        return $this->id_ruta;
    }

    /**
     * Cambia el valor del id_ruta
     */
    public function setIdRuta(string $id_ruta): void
    {
        $this->id_ruta = $id_ruta;
    }

    /**
     * Obtiene el valor del of id_usuario
     */
    public function getIdUsuario(): string
    {
        return $this->id_usuario;
    }

    /**
     * Cambia el valor del id_usuario
     */
    public function setIdUsuario(string $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * Obtiene el valor del of nombre
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
     * Obtiene el valor del of texto
     */
    public function getTexto(): string
    {
        return $this->texto;
    }

    /**
     * Cambia el valor del texto
     */
    public function setTexto(string $texto): void
    {
        $this->texto = $texto;
    }

    /**
     * Obtiene el valor del of fecha
     */
    public function getFecha(): string
    {
        return $this->fecha;
    }

    /**
     * Cambia el valor del fecha
     */
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }
    /**
     * Función para crear un objeto de RutasComentarios desde un array
     * 
     * @return RutasComentarios
     */
    public static function fromArray(array $data): RutasComentarios
    {
        return new RutasComentarios(
            $data['id'] ?? null,
            $data['id_ruta'] ?? '',
            $data['id_usuario'] ?? '',
            $data['nombre'] ?? '',
            $data['texto'] ?? "",
            $data['fecha'] ?? '',
        );
    }
    /**
     * Función para validar un nuevo comentario
     * 
     * @param array data con los datos para sanear y validar
     * @param array errores que sera modificado si hay errores
     * 
     * @return array
     */
    public static function validar(string $comentario, array &$errores): array
    {
        ############### SANEA ###############
        $comentario = htmlspecialchars($comentario);
        ############### VALIDA ###############
        if(empty($comentario)){
            $errores['comentario']="Comentario debe tener texto";
        }elseif(!Validar::son_letras($comentario)){
            $errores['comentario']="Caracteres no aceptados";
        }
        if (!empty($_SESSION['identity']['ultimo_Commit'])) {
            $fechaUltimoCommit = strtotime($_SESSION['identity']['ultimo_Commit']);
            $actual = strtotime(date("d-m-Y H:i:00",time()));
            if($actual<$fechaUltimoCommit){
                $errores['comentario']="No podrás comentar hasta mañana";
            }
        }
        return $errores;
    }
}
