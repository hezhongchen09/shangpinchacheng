<?php
namespace Shangpinchacheng\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

use Shangpinchacheng\Common\StatusCode;
use Shangpinchacheng\Common\ApplicationError;
use Shangpinchacheng\Common\Utility;
use Shangpinchacheng\Entity\Token;
use Shangpinchacheng\Resource\UserResource;
use Shangpinchacheng\Resource\TokenResource;

final class UserAction{
    private $view;
    private $logger;
    private $userResource;
    private $tokenResource;

    public function __construct(Twig $view, LoggerInterface $logger, UserResource $userResource, TokenResource $tokenResource){
        $this->view = $view;
        $this->logger = $logger;
        $this->userResource = $userResource;
        $this->tokenResource = $tokenResource;
    }

    public function loginPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'login.twig');
    }

    public function changePasswordPage($request, $response, $args){
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'change-password.twig');
    }

    public function login($request, $response, $args){
        $parsedBody = $request->getParsedBody();

        if (!isset($parsedBody['username']) || $parsedBody['username']=="" || $parsedBody['password']=="" || !isset($parsedBody['password'])) {
            return json_encode((object)[
                "Code" => StatusCode::Error,
                "Message" => ApplicationError::error()["USERNAME_OR_PASSWORD_REQUIRED"]
            ]);
        }

        $user = $this->userResource->getByName($parsedBody['username']);
        if ($user && md5($parsedBody['password'])==$user->getPassword()) {
            $token = new Token();
            $token->setUserId($user->getId());
            $token->setToken(Utility::getToken());
            $token->setExpireTime(date('Y-m-d H:i:s',time()+1800));

            $this->tokenResource->getEntityManager()->persist($token);
            $this->tokenResource->getEntityManager()->flush();

            return json_encode((object)[
                "Code" => StatusCode::Ok,
                "Message" => ""
            ]);
        }

        return json_encode((object)[
            "Code" => StatusCode::Error,
            "Message" => ApplicationError::error()["USERNAME_OR_PASSWORD_ERROR"]
        ]);
    }

    public function logout($request, $response, $args){
        $token = $request->getHeader('X-Auth-Token')[0];

        $tokenObj = $this->tokenResource->get($token);
        $this->tokenResource->getEntityManager()->remove($tokenObj);
        $this->tokenResource->getEntityManager()->flush();

        return json_encode((object)[
            "Code" => StatusCode::Ok,
            "Message" => ""
        ]);
    }

    public function changePassword($request, $response, $args){
        $parsedBody = $request->getParsedBody();

        $token = $request->getHeader('X-Auth-Token')[0];
        $tokenObj = $this->tokenResource->get($token);

        $user = $this->userResource->getById($tokenObj->getUserId());
        if ($user && md5($parsedBody['password'])==$user->getPassword()) {
            $user->setPassword(md5($parsedBody['new_password']));

            $this->userResource->getEntityManager()->persist($user);
            $this->userResource->getEntityManager()->flush();

            return json_encode((object)[
                "Code" => StatusCode::Ok,
                "Message" => ""
            ]);
        }

        return json_encode((object)[
            "Code" => StatusCode::Error,
            "Message" => ApplicationError::error()["PASSWORD_ERROR"]
        ]);
    }
}
