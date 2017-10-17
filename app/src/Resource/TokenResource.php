<?php
namespace Shangpinchacheng\Resource;

use Shangpinchacheng\AbstractResource;

class TokenResource extends AbstractResource {
    public function get($token){
        $tokenObj = $this->entityManager->getRepository('Shangpinchacheng\Entity\Token')->findOneBy(
            array('token' => $token)
        );
        if ($tokenObj) {
            return $tokenObj;
        }

        return null;
    }
}
