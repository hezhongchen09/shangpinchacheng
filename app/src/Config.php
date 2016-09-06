<?php
namespace Shangpinchacheng;

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Flash\Messages;

use Monolog\logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Shangpinchacheng\Action\HomeAction;
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

			$view->addExtension(new TwigExtension($c->get('router'), $c->get('request')->getUri()));
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
		$this->container['Action\HomeAction'] = function ($c) {
			return new HomeAction($c->get('view'), $c->get('logger'));
		};

		$this->container['Action\ImageAction'] = function ($c) {
			$imageResource = new ImageResource($c->get('em'));
			return new ImageAction($imageResource);
		};
	}

	public function setRouter(){
		$this->app->get('/api/images', 'Action\ImageAction:fetch');
		$this->app->get('/api/images/{name}', 'Action\ImageAction:fetchOne');
	}
}