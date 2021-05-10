<?php declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\Calendar;
use Luracast\Restler\OpenApi3\Explorer;
use Luracast\Restler\Restler;
use Luracast\Restler\Router;

Router::mapApiClasses([
    Calendar::class,
    Explorer::class
]);

(new Restler)->handle();
