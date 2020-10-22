<?php

namespace Involta\Yii\Web;

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

}
