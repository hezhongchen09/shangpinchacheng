<?php
namespace Shangpinchacheng\Resource;

use Shangpinchacheng\AbstractResource;

class ImageResource extends AbstractResource {
    public function getByName($name){
        $image = $this->entityManager->getRepository('Shangpinchacheng\Entity\Image')->findOneBy(
            array('name' => $name)
        );
        if ($image) {
            return $image;
        }

        return null;
    }
}
