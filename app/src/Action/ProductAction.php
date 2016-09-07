<?php
namespace Shangpinchacheng\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

use Shangpinchacheng\Common\StatusCode;

use Shangpinchacheng\Entity\Image;
use Shangpinchacheng\Entity\Product;
use Shangpinchacheng\Resource\ProductResource;
use Shangpinchacheng\Resource\ImageResource;

final class ProductAction{
    private $view;
    private $logger;
    private $productResource;
    private $imageResource;

    public function __construct(Twig $view, LoggerInterface $logger, ProductResource $productResource, ImageResource $imageResource){
        $this->view = $view;
        $this->logger = $logger;
        $this->productResource = $productResource;
        $this->imageResource = $imageResource;
    }

    public function listProductPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'product-list.twig');
    }

    public function addProductPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'add-product.twig');
    }

    public function viewProductPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'view-product.twig');
    }

    public function addProduct($request, $response, $args){
        $parsedBody = $request->getParsedBody();

        $thumbnailId = "";
        $thumbnailImageObj = new Image();
        $thumbnailImageObj->setName($parsedBody['thumbnailImage']['name']);
        $thumbnailImageObj->setDescription($parsedBody['thumbnailImage']['description']);
        $this->imageResource->getEntityManager()->persist($thumbnailImageObj);
        $this->imageResource->getEntityManager()->flush();
        $thumbnailId = $this->imageResource->getByName($parsedBody['thumbnailImage']['name'])->getId();

        $imageIds = "";
        foreach ($parsedBody['images'] as $image) {
            $imageObj = new Image();

            $imageObj->setName($image['name']);
            $imageObj->setDescription($image['description']);

            $this->imageResource->getEntityManager()->persist($imageObj);
            $this->imageResource->getEntityManager()->flush();

            if ($imageIds=="") {
                $imageIds .= $this->imageResource->getByName($image['name'])->getId();
            } else {
                $imageIds .= ",".$this->imageResource->getByName($image['name'])->getId();
            }
        }

        $productObj = new Product();
        $productObj->setName($parsedBody['name']);
        $productObj->setType($parsedBody['type']);
        $productObj->setSize($parsedBody['size']);
        $productObj->setLevel($parsedBody['level']);
        $productObj->setOriginalPrice($parsedBody['originalPrice']);
        $productObj->setSalePrice($parsedBody['salePrice']);
        $productObj->setThumbnailId($thumbnailId);
        $productObj->setShopAddress($parsedBody['shopAddress']);
        $productObj->setImageIds($imageIds);
        $productObj->setDescription($parsedBody['description']);
        $productObj->setStatus($parsedBody['status']);
        $productObj->setHot($parsedBody['hot']);

        $this->productResource->getEntityManager()->persist($productObj);
        $this->productResource->getEntityManager()->flush();

        return json_encode((object)[
            "Code" => StatusCode::Ok,
            "Message" => ""
        ]);
    }
}
