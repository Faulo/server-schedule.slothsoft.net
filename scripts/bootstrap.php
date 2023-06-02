<?php
declare(strict_types = 1);

use Slothsoft\Core\ServerEnvironment;
use Slothsoft\Farah\Dictionary;
use Slothsoft\Farah\HTTPResponse;
use Slothsoft\Farah\Kernel;
use Slothsoft\Farah\Module\Module;
use Slothsoft\Server\Schedule\ServerConfig;

Module::registerWithXmlManifestAndDefaultAssets('slothsoft@schedule.slothsoft.net', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets');

HTTPResponse::cacheDurations()['application/xhtml+xml'] = 1;

ServerEnvironment::setRootDirectory(dirname(__DIR__));
ServerEnvironment::setCacheDirectory(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache');
ServerEnvironment::setLogDirectory(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'log');
ServerEnvironment::setDataDirectory(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data');

Kernel::setCurrentSitemap('farah://slothsoft@schedule.slothsoft.net/sitemap');
Kernel::setTrackingEnabled(false);

Dictionary::setSupportedLanguages('en-us');

ServerConfig::setGoogleCredentials(dirname(__DIR__) . '/config/google-credentials.json');
ServerConfig::setScheduleManifest(dirname(__DIR__) . '/config/schedule-manifest.json');