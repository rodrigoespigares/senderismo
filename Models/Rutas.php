<?php

namespace Models;
use Models\Validar;
class Rutas
{
    public function __construct(
        // Atributos de la clase Rutas
        private string|null $id = null,
        private string $id_usuario,
        private string $titulo,
        private string $descripcion,
        private string $desnivel,
        private string $distancia,
        private string $notas,
        private string $dificultad
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
     * Obtiene el valor del id_usuario
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
     * Obtiene el valor del titulo
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * Cambia el valor del titulo
     */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * Obtiene el valor del descripcion
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Cambia el valor del descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Obtiene el valor del desnivel
     */
    public function getDesnivel(): string
    {
        return $this->desnivel;
    }

    /**
     * Cambia el valor del desnivel
     */
    public function setDesnivel(string $desnivel): void
    {
        $this->desnivel = $desnivel;
    }

    /**
     * Obtiene el valor del distancia
     */
    public function getDistancia(): string
    {
        return $this->distancia;
    }

    /**
     * Cambia el valor del distancia
     */
    public function setDistancia(string $distancia): void
    {
        $this->distancia = $distancia;
    }

    /**
     * Obtiene el valor del notas
     */
    public function getNotas(): string
    {
        return $this->notas;
    }

    /**
     * Cambia el valor del notas
     */
    public function setNotas(string $notas): void
    {
        $this->notas = $notas;
    }

    /**
     * Obtiene el valor del dificultad
     */
    public function getDificultad(): string
    {
        return $this->dificultad;
    }

    /**
     * Cambia el valor del dificultad
     */
    public function setDificultad(string $dificultad): void
    {
        $this->dificultad = $dificultad;
    }
    /**
     * Función para crear un objeto de Rutas desde un array
     * 
     * @return Rutas
     */
    public static function fromArray(array $data): Rutas
    {
        return new Rutas(
            $data['id'] ?? null,
            $data['id_usuario'] ?? null,
            $data['titulo'] ?? "",
            $data['descripcion'] ?? '',
            $data['desnivel'] ?? "",
            $data['distancia'] ?? "",
            $data['notas'] ?? '',
            $data['dificultad'] ?? "",
        );
    }
    /**
     * Función para validar una nueva ruta
     * 
     * @param array data con los datos para sanear y validar
     * @param array errores que sera modificado si hay errores
     * 
     * @return array
     */
    public static function validar(array $data, array &$errores): array
    {
        ############### SANEA ###############
        $title = htmlspecialchars($data['title']);
        $description = htmlspecialchars($data['description']);
        $desnivel = filter_var($data['desnivel'], FILTER_SANITIZE_NUMBER_INT);
        $distancia = filter_var($data['distancia'], FILTER_SANITIZE_NUMBER_INT);
        $dificultad = htmlspecialchars($data['dificultad']);
        $notas = htmlspecialchars($data['notas']);
        
        ############### VALIDA ###############
        if(empty($title)){
            $errores['title']="Campo obligatorio";
        }elseif(!Validar::son_letras($title)){
            $errores['title']="Caracteres no permitidos";
        }
        if(empty($description)){
            $errores['description']="Campo obligatorio";
        }elseif(!Validar::son_letras($description)){
            $errores['desc$description']="Caracteres no permitidos";
        }
        if(empty($desnivel)){
            $errores['desnivel']="Campo obligatorio";
        }
        if(!empty($distancia) && $distancia<0){
            $errores['distancia']="La distancia no puede ser negativa";
        }
        if(!Validar::validar_array($dificultad)){
            $errores['dificultad']="Dificultad no aceptada";
        }
        if(!empty($notas) && !Validar::son_letras($notas)){
            $errores['notas']="Caracteres no aceptados";
        }
        return $errores;
    }
}
