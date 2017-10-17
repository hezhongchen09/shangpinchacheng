<?php
namespace Shangpinchacheng\Resource;

use Shangpinchacheng\AbstractResource;

class UserResource extends AbstractResource {
    public function getByName($username){
        $user = $this->entityManager->getRepository('Shangpinchacheng\Entity\User')->findOneBy(
            array('name' => $username)
        );
        if ($user) {
            return $user;
        }

        return null;
    }

    public function getById($userId){
        $user = $this->entityManager->getRepository('Shangpinchacheng\Entity\User')->findOneBy(
            array('id' => $userId)
        );
        if ($user) {
            return $user;
        }

        return null;
    }
}
