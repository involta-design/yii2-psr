<?php

namespace Involta\Yii\Web;

use http\Exception\InvalidArgumentException;
use Psr\Container\ContainerInterface;
use yii\base\Action;
use yii\base\Module;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Arrays\ArrayHelper;

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

        /** @var Aliases $aliases */
        $aliases = $container->get(Aliases::class);

        $config['aliases'] = ArrayHelper::merge(
            [
                '@vendor' => $aliases->get('@vendor'),
                '@bower' => $aliases->get('@vendor/bower-asset'),
            ],
            is_array($config['aliases']) ? $config['aliases'] : []
        );

        parent::__construct($config);
    }
}
