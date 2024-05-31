<?php

namespace Model;


class Ponente extends ActiveRecord
{
    protected static $tabla = 'ponentes';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'redes'];

    public $id;
    public $nombre;
    public $apellido;
    public $ciudad;
    public $pais;
    public $imagen;
    public $tags;
    public $redes;

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if (!$this->ciudad) {
            self::$alertas['error'][] = 'El Campo Ciudad es Obligatorio';
        }
        if (!$this->pais) {
            self::$alertas['error'][] = 'El Campo País es Obligatorio';
        }
        if (!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
        if (!$this->tags) {
            self::$alertas['error'][] = 'El Campo áreas es obligatorio';
        }

        return self::$alertas;
    }
}