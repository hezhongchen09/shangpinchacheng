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

use Shangpinchacheng\Action\UserAction;
use Shangpinchacheng\Action\ProductAction;
use Shangpinchacheng\Action\ImageAction;

use Shangpinchacheng\Resource\ImageResource;

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
			return new UserAction($c->get('view'), $c->get('logger'));
		};

		$this->container['Action\ProductAction'] = function ($c) {
			return new ProductAction($c->get('view'), $c->get('logger'));
		};

		$this->container['Action\ImageAction'] = function ($c) {
			$imageResource = new ImageResource($c->get('em'));
			return new ImageAction($imageResource);
		};
	}

	public function setRouter(){
		$this->app->get('/admin/login', 'Action\UserAction:showLoginPage');
		$this->app->get('/admin/change-password', 'Action\UserAction:showLoginPage');

		$this->app->get('/admin', 'Action\ProductAction:listProduct');
		$this->app->get('/admin/product/list', 'Action\ProductAction:listProduct');
		$this->app->get('/admin/product/view/{product_id}', 'Action\UserAction:showLoginPage');
		$this->app->get('/admin/product/add', 'Action\ProductAction:addProduct');

		$this->app->get('/api/images', 'Action\ImageAction:fetch');
		$this->app->get('/api/images/{name}', 'Action\ImageAction:fetchOne');
	}
}