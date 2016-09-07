<?php
namespace Shangpinchacheng;

use \Slim\App;
use \Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig_Extension_Debug;
use \Slim\Flash\Messages;

use \Monolog\Logger;
use \Monolog\Processor\UidProcessor;
use \Monolog\Handler\StreamHandler;

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

use Shangpinchacheng\Settings;

use Shangpinchacheng\Action\UserAction;
use Shangpinchacheng\Action\ProductAction;
use Shangpinchacheng\Action\ImageAction;

use Shangpinchacheng\Common\StatusCode;
use Shangpinchacheng\Common\GenericError;

use Shangpinchacheng\Resource\ProductResource;
use Shangpinchacheng\Resource\ImageResource;
use Shangpinchacheng\Resource\UserResource;
use Shangpinchacheng\Resource\TokenResource;

class Config {
	private $app;
	private $container;

	public function __construct(App $app){
		$this->app = $app;
		$this->container = $app->getContainer();
	}

	public function setDependency(){
		$this->container['view'] = function ($c) {
			$settings = $c->get('settings');
			$view = new Twig($settings['view']['template_path'], $settings['view']['twig']);

			$basePath = rtrim(str_ireplace('index.php', '', $c->get('request')->getUri()->getBasePath()), '/');

			$view->addExtension(new TwigExtension($c->get('router'), $basePath));
			$view->addExtension(new Twig_Extension_Debug());
			
			return $view;
		};

		$this->container['flash'] = function ($c) {
			return new Messages;
		};

		$this->container['logger'] = function ($c) {
			$settings = $c->get('settings');
			$logger = new Logger($settings['logger']['name']);
			$logger->pushProcessor(new UidProcessor());
			$logger->pushHandler(new StreamHandler($settings['logger']['path'], Logger::DEBUG));
			
			return $logger;
		};

		$this->container['em'] = function ($c) {
			$settings = $c->get('settings');
			$config = Setup::createAnnotationMetadataConfiguration(
				$settings['doctrine']['meta']['entity_path'],
				$settings['doctrine']['meta']['auto_generate_proxies'],
				$settings['doctrine']['meta']['proxy_dir'],
				$settings['doctrine']['meta']['cache'],
				false
			);
			return EntityManager::create($settings['doctrine']['connection'], $config);
		};
	}

	public function setAction(){
		$this->container['Action\UserAction'] = function ($c) {
			$userResource = new UserResource($c->get('em'));
			$tokenResource = new TokenResource($c->get('em'));
			return new UserAction($c->get('view'), $c->get('logger'), $userResource, $tokenResource);
		};

		$this->container['Action\ProductAction'] = function ($c) {
			$productResource = new ProductResource($c->get('em'));
			$imageResource = new ImageResource($c->get('em'));
			return new ProductAction($c->get('view'), $c->get('logger'), $productResource, $imageResource);
		};

		$this->container['Action\ImageAction'] = function ($c) {
			$imageResource = new ImageResource($c->get('em'));
			return new ImageAction($imageResource);
		};
	}

	public function setRouter(){
		$checkAuth = function ($request, $response, $next) {
			$token = $request->getHeader('X-Auth-Token')[0];

			$settings = Settings::getSettings()['settings'];
			$config = Setup::createAnnotationMetadataConfiguration(
				$settings['doctrine']['meta']['entity_path'],
				$settings['doctrine']['meta']['auto_generate_proxies'],
				$settings['doctrine']['meta']['proxy_dir'],
				$settings['doctrine']['meta']['cache'],
				false
			);
			$em = EntityManager::create($settings['doctrine']['connection'], $config);
			$tokenResource = new TokenResource($em);
			$tokenObj = $tokenResource->get($token);

			if($tokenObj && strtotime($tokenObj->getExpireTime())-time()>0 && strtotime($tokenObj->getExpireTime())-time()<1800){
				if(strtotime($tokenObj->getExpireTime())-time()<30){
					$tokenObj->setExpireTime(date('Y-m-d H:i:s',time()+1800));
					$tokenResource->getEntityManager()->persist($tokenObj);
            		$tokenResource->getEntityManager()->flush();
				}
			} else {
				$response->getBody()->write(
					json_encode((object)[
            			"Code" => StatusCode::UnAuthorized,
            			"Message" => GenericError::info(StatusCode::UnAuthorized)
        			])
				);
				return $response;
			}

			return $next($request, $response);
		};

		$this->app->get('/admin/login', 'Action\UserAction:loginPage');
		$this->app->get('/admin/change-password', 'Action\UserAction:changePasswordPage');

		$this->app->get('/admin', 'Action\ProductAction:listProductPage');
		$this->app->get('/admin/product/list', 'Action\ProductAction:listProductPage');
		$this->app->get('/admin/product/view/{product_id}', 'Action\ProductAction:viewProductPage');
		$this->app->get('/admin/product/add', 'Action\ProductAction:addProductPage');

		$this->app->get('/api/images', 'Action\ImageAction:fetch');
		$this->app->get('/api/images/{name}', 'Action\ImageAction:fetchOne');

		$this->app->post('/api/login', 'Action\UserAction:login');
		$this->app->get('/api/logout', 'Action\UserAction:logout')->add($checkAuth);
		$this->app->post('/api/change-password', 'Action\UserAction:changePassword')->add($checkAuth);

		$this->app->post('/api/product/add', 'Action\ProductAction:addProduct');
	}
}