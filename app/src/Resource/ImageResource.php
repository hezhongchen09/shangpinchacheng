<?php
namespace Shangpinchacheng\Resource;

use Shangpinchacheng\AbstractResource;

class ImageResource extends AbstractResource {
    public function get($name = null){
        if ($name === null) {
            $iamges = $this->entityManager->getRepository('Shangpinchacheng\Entity\Image')->findAll();
            $iamges = array_map(
                function ($image) {
                    return $image->getArrayCopy();
                },
                $iamges
            );

            return $iamges;
        } else {
            $image = $this->entityManager->getRepository('Shangpinchacheng\Entity\Image')->findOneBy(
                array('name' => $name)
            );
            if ($image) {
                return $image->getArrayCopy();
            }
        }

        return false;
    }
}
