<?php
/**
 * Created by PhpStorm.
 * User: jbarron
 * Date: 3/29/16
 * Time: 11:48 PM
 */


namespace App\Http\Odm\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;

/** @EmbeddedDocument */
class FotoAuto
{

    /** @ODM\Field(type="string") */
    private $filename;

    /** @ODM\Field(type="boolean") */
    private $selected = false;


    /**
     * @return mixed
     */
    public function getFilename()
    {
        $filename = explode('-',$this->filename);
        return $filename[1];
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * @param mixed $selected
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }




}