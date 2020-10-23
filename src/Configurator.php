<?php

namespace Involta\Yii;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use samdark\log\PsrTarget;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Arrays\ArrayHelper;

final class Configurator
{
    private ContainerInterface $container;
    private array $config = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        /** @var Aliases $aliases */
        $aliases = $this->container->get(Aliases::class);
    }

    public function withConfig(array $config): self
    {
        $new = clone $this;
        $new->config = $config;

        /** @var Aliases $aliases */
        $aliases = $this->container->get(Aliases::class);

        if (isset($new->config['runtimePath'])) {
            $aliases->set('@runtime', $new->config['runtimePath']);
        }

        $new->config['aliases'] = ArrayHelper::merge(
            [
                '@vendor' => $aliases->get('@vendor'),
                '@bower' => $aliases->get('@vendor/bower-asset'),
            ],
            is_array($new->config['aliases']) ? $new->config['aliases'] : []
        );

        return $new;
    }

    public function withPsr3(): self
    {
        $new = clone $this;
        if (isset($new->config['components']['log']['targets'])) {
            $targets = $new->config['components']['log']['targets'];
            if (is_array($targets)) {
                foreach ($targets as &$target) {
                    if (isset($target['class']) && $target['class'] === PsrTarget::class) {
                        if (!isset($target['logger'])) {
                            $target['logger'] = $this->container->get(LoggerInterface::class);
                        }
                    }
                }

                $new->config['components']['log']['targets'] = $targets;
            }
        }

        return $new;
    }

    public function apply(): array
    {
        return $this->config;
    }
}