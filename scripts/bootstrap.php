<?php
declare(strict_types = 1);

use Slothsoft\Farah\Module\Module;
use Slothsoft\Farah\HTTPResponse;

Module::registerWithXmlManifestAndDefaultAssets('slothsoft@schedule.slothsoft.net', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets');

HTTPResponse::cacheDurations()['application/xhtml+xml'] = 1;