<?php
namespace App\Http\Odm\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedMany;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/** @ODM\Document */
class Auto
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $nombre;

    /** @ODM\Field(type="string") */
    private $empaque;

    /** @ODM\Field(type="string") */
    private $marca;

    /** @ODM\Field(type="string") */
    private $descripcion;

    /** @EmbedMany(targetDocument="App\Http\Odm\Documents\FotoAuto") */
    private $fotos = array();


    /** @ReferenceOne(targetDocument="App\Http\Odm\Documents\Usuario", inversedBy="autos", cascade={"persist"}) */
    private $usuario;


    /** @ODM\Field(type="date") */
    private $createdAt;

    /** @ODM\Field(type="date") */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getEmpaque()
    {
        return $this->empaque;
    }

    /**
     * @param mixed $empaque
     */
    public function setEmpaque($empaque)
    {
        $this->empaque = $empaque;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getFotos()
    {
        return $this->fotos;
    }


    public function setFotos(FotoAuto $foto)
    {
        $this->fotos[] = $foto;
    }


    public function getSelectedFoto()
    {
        return $this->fotos[0];
    }


    public function createdAt()
    {
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function updatedAt()
    {
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt->format('r');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }




}
