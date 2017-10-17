<?php
namespace Shangpinchacheng\Entity;

use Doctrine\ORM\Mapping;

use Shangpinchacheng\Entity;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="user", uniqueConstraints={@Mapping\UniqueConstraint(name="user_id", columns={"id"})}))
 */
class User{
    /**
     * @Mapping\Id
     * @Mapping\Column(name="id", type="integer")
     * @Mapping\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $password;

    /**
     * @return array
     */
    public function getArrayCopy(){
        return get_object_vars($this);
    }

    /**
     * @Mapping\return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @Mapping\return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @Mapping\return string
     */
    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }
}
