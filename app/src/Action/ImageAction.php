<?php
namespace Shangpinchacheng\Action;

use Shangpinchacheng\Resource\ImageResource;

final class ImageAction{
    private $imageResource;

    public function __construct(ImageResource $imageResource){
        $this->imageResource = $imageResource;
    }

    public function fetch($request, $response, $args){
        $images = $this->imageResource->get();
        return $response->withJSON($images);
    }

    public function fetchOne($request, $response, $args){
        $image = $this->imageResource->get($args['slug']);
        if ($image) {
            return $response->withJSON($image);
        }
        return $response->withStatus(404, 'No image found with that slug.');
    }
}
