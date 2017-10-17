<?php
namespace Shangpinchacheng\Entity;

use Doctrine\ORM\Mapping;

use Shangpinchacheng\Entity;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="image", uniqueConstraints={@Mapping\UniqueConstraint(name="image_id", columns={"id"})}))
 */
class Image{
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
    protected $description;

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

    public function setName($name){
        $this->name = $name;
    }

    /**
     * @Mapping\return string
     */
    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }
}
