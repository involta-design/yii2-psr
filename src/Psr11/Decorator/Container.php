<?php

namespace Involta\Yii\Psr11\Decorator;

use Involta\Yii\Psr11\Container as DIContainer;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Arrays\ArrayHelper;

class Container implements ContainerInterface
{
    private ContainerInterface $container;

    public function __construct(array ...$args)
    {
        $definitions = [];

        $container = new DIContainer();
        foreach ($args as $arg) {
            $definitions = ArrayHelper::merge($definitions, $arg);
        }

        $container->setDefinitions($definitions);

        $this->container = $container;
        /** @var Aliases $aliases */
        $aliases = $container->get(Aliases::class);

        $yiiFile = $aliases->get('@vendor/involta-design/yii2-psr/src/Yii.php');
        if (file_exists($yiiFile)) {
            require $yiiFile;
        }

        throw new RuntimeException(sprintf("File %s not found", $yiiFile));
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    public function has($id): bool
    {
        return $this->container->has($id);
    }
}
