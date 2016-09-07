<?php
namespace Shangpinchacheng\Entity;

use Doctrine\ORM\Mapping;

use Shangpinchacheng\Entity;

/**
 * @Mapping\Entity
 * @Mapping\Table(name="token", uniqueConstraints={@Mapping\UniqueConstraint(name="token_id", columns={"id"})}))
 */
class Token{
    /**
     * @Mapping\Id
     * @Mapping\Column(name="id", type="integer")
     * @Mapping\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Mapping\Column(name="userId", type="integer")
     */
    protected $userId;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $token;

    /**
     * @Mapping\Column(type="string", length=100)
     */
    protected $expireTime;

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
     * @Mapping\return integer
     */
    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    /**
     * @Mapping\return string
     */
    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
    }

    /**
     * @Mapping\return string
     */
    public function getExpireTime(){
        return $this->expireTime;
    }

    public function setExpireTime($expireTime){
        $this->expireTime = $expireTime;
    }
}
