<?php
namespace Shangpinchacheng\Entity;

use Doctrine\ORM\Mapping;

use Shangpinchacheng\Entity;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="product", uniqueConstraints={@Mapping\UniqueConstraint(name="product_id", columns={"id"})}))
 */
class Product{
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
     * @Mapping\Column(type="integer")
     */
    protected $type;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $size;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $level;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $originalPrice;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $salePrice;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $thumbnailId;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $shopAddress;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $imageIds;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $status;

    /**
     * @Mapping\Column(type="integer")
     */
    protected $hot;

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
     * @Mapping\return integer
     */
    public function getType(){
        return $this->type;
    }

    public function setType($type){
        $this->type = $type;
    }

    /**
     * @Mapping\return integer
     */
    public function getSize(){
        return $this->size;
    }

    public function setSize($size){
        $this->size = $size;
    }

    /**
     * @Mapping\return integer
     */
    public function getLevel(){
        return $this->level;
    }

    public function setLevel($level){
        $this->level = $level;
    }

    /**
     * @Mapping\return integer
     */
    public function getOriginalPrice(){
        return $this->originalPrice;
    }

    public function setOriginalPrice($originalPrice){
        $this->originalPrice = $originalPrice;
    }

    /**
     * @Mapping\return integer
     */
    public function getSalePrice(){
        return $this->salePrice;
    }

    public function setSalePrice($salePrice){
        $this->salePrice = $salePrice;
    }

    /**
     * @Mapping\return integer
     */
    public function getThumbnailId(){
        return $this->thumbnailId;
    }

    public function setThumbnailId($thumbnailId){
        $this->thumbnailId = $thumbnailId;
    }

    /**
     * @Mapping\return string
     */
    public function getShopAddress(){
        return $this->shopAddress;
    }

    public function setShopAddress($shopAddress){
        $this->shopAddress = $shopAddress;
    }

    /**
     * @Mapping\return string
     */
    public function getImageIds(){
        return $this->imageIds;
    }

    public function setImageIds($imageIds){
        $this->imageIds = $imageIds;
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

    /**
     * @Mapping\return integer
     */
    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    /**
     * @Mapping\return integer
     */
    public function getHot(){
        return $this->hot;
    }

    public function setHot($hot){
        $this->hot = $hot;
    }
}
