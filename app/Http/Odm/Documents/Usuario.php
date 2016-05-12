<?php
namespace App\Http\Odm\Documents;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Illuminate\Support\Facades\App;

/** @ODM\Document */
class Usuario
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $firstname;

    /** @ODM\Field(type="string") */
    private $email;

    /** @ODM\Field(type="string") */
    private $lastname;

    /** @ODM\Field(type="string") */
    private $facebookID;

    /** @ODM\Field(type="string") */
    private $password;

    /** @ODM\Field(type="string") */
    private $activationCode="";

    /** @ODM\Field(type="string") */
    private $forgotCode="";

    /** @ODM\Field(type="date") */
    private $forgotAt;

    /** @ODM\Field(type="bool") */
    private $accountEnable = 0;

    /** @ODM\Field(type="date") */
    private $createdAt;

    /** @ODM\Field(type="date") */
    private $updatedAt;

    /** @ODM\Field(type="string") */
    private $idhw;


    /** @ReferenceMany(targetDocument="App\Http\Odm\Documents\Auto", mappedBy="usuario") */
    private $autos;


    /**
     * @ReferenceMany(
     *      targetDocument="App\Http\Odm\Documents\Auto",
     *      mappedBy="usuario",
     *      sort={"createdAt"="desc"},
     *      limit=5
     * )
     */
    private $last5autos;


    public function __construct(){ $this->autos = new ArrayCollection(); }

    /**
     * @return mixed
     */
    public function getIdhw()
    {
        return $this->idhw;
    }

    /**
     * @param mixed $idwh
     */
    public function setIdhw($idhw)
    {
        $this->idhw = $idhw;
    }




    /**
     * @return mixed
     */
    public function getAccountEnable()
    {
        return $this->accountEnable;
    }

    /**
     * @param mixed $accountEnable
     */
    public function setAccountEnable($accountEnable)
    {
        $this->accountEnable = $accountEnable;
    }

    /**
     * @return mixed
     */
    public function getLast5autos()
    {
        return $this->last5autos;
    }




    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * @param mixed $activationCode
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param mixed $facebookID
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;
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
    public function getForgotCode()
    {
        return $this->forgotCode;
    }

    /**
     * @param mixed $forgotCode
     */
    public function setForgotCode($forgotCode)
    {
        $this->forgotCode = $forgotCode;
    }

    /**
     * @return mixed
     */
    public function getForgotAt()
    {
        return $this->forgotAt;
    }

    /**
     * @param mixed $forgotAt
     */
    public function setForgotAt()
    {
        $this->forgotAt =  date('Y-m-d H:i:s');
    }

    public function removeForgotAt()
    {
        $this->forgotAt =   null;
    }

    /**
     * @return mixed
     */
    public function getAutos()
    {
        return $this->autos;
    }

    /**
     * @param mixed $autos
     */
    public function setAutos($autos)
    {
        $this->autos[] = $autos;
    }


    public function getNumeroAutos()
    {
        return count($this->autos);
    }


}
