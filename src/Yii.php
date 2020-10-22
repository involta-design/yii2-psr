<?php

use Psr\Container\ContainerInterface;
use yii\BaseYii;
use Yiisoft\Aliases\Aliases;

/**
 * @var ContainerInterface $container
 * @var Aliases $aliases
 */
class Yii extends BaseYii
{
    public static function getAlias($alias, $throwException = true)
    {
        $aliases = static::$container->get(Aliases::class);

        try {
            return $aliases->get($alias);
        } catch (InvalidArgumentException $e) {
            if ($throwException) {
                throw $e;
            }
        }

        return false;
    }

    public static function setAlias($alias, $path)
    {
        $aliases = static::$container->get(Aliases::class);
        $aliases->set($alias, $path);
    }
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = $aliases->get('@vendor/yiisoft/yii2/classes.php');
Yii::$container = $container;
