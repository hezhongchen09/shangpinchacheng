<?php
namespace Shangpinchacheng\Resource;

use Shangpinchacheng\AbstractResource;

class ProductResource extends AbstractResource {
    public function getByName($name){
        $product = $this->entityManager->getRepository('Shangpinchacheng\Entity\Product')->findOneBy(
            array('name' => $name)
        );
        if ($product) {
            return $product;
        }

        return null;
    }
}
