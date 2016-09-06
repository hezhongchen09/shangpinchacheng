<?php
namespace Shangpinchacheng\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

final class ProductAction{
    private $view;
    private $logger;

    public function __construct(Twig $view, LoggerInterface $logger){
        $this->view = $view;
        $this->logger = $logger;
    }

    public function listProduct($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'product-list.twig');
    }

    public function addProduct($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'add-product.twig');
    }
}
