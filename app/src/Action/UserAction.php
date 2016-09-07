<?php
namespace Shangpinchacheng\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

final class UserAction{
    private $view;
    private $logger;

    public function __construct(Twig $view, LoggerInterface $logger){
        $this->view = $view;
        $this->logger = $logger;
    }

    public function showLoginPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'login.twig');
    }

    public function changePassword($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'change-password.twig');
    }
}
