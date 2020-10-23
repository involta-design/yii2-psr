<?php

namespace Involta\Yii\Web;

use Involta\Yii\Configurator;
use Psr\Container\ContainerInterface;
use yii\base\Action;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class Application
 * @package Involta\Yii\Web
 *
 * @property Module $module
 * @property string $id
 * @property string $requestedRoute
 * @property Controller $controller
 * @property int $state
 * @property array $catchAll
 * @property array $extensions
 * @property array $requestedParams
 * @property Action $requestedAction
 */
final class Application extends \yii\Psr7\web\Application
{
    public function __construct(array $config = [])
    {
        if (!isset($config['container'])) {
            throw new \InvalidArgumentException('Container is not defined');
        }

        /** @var ContainerInterface $container */
        $container = $config['container'];

        $config = (new Configurator($container))
            ->withConfig($config)
            ->withPsr3() // logger
            ->apply();

        parent::__construct($config);
    }
}
