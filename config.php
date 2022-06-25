<?php
namespace Slothsoft;

use Slothsoft\Core\ServerEnvironment;
use Slothsoft\Farah\Dictionary;
use Slothsoft\Farah\Kernel;
use Slothsoft\Server\Schedule\ServerConfig;

// @include __DIR__ . '/../../global/slothsoft.core.php';
// @include __DIR__ . '/../../global/slothsoft.core.xslt.php';
// @include __DIR__ . '/../../global/slothsoft.core.dbms.php';
// @include __DIR__ . '/../../global/slothsoft.farah.php';
// @include __DIR__ . '/../../global/slothsoft.minecraft.php';
// @include __DIR__ . '/../../global/slothsoft.mtg.php';

ServerEnvironment::setRootDirectory(__DIR__);
ServerEnvironment::setCacheDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'cache');
ServerEnvironment::setLogDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'log');
ServerEnvironment::setDataDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'data');

Kernel::setCurrentSitemap('farah://slothsoft@schedule.slothsoft.net/sitemap');
Kernel::setTrackingEnabled(false);
Dictionary::setSupportedLanguages('en-us');

ServerConfig::setGoogleCredentials(__DIR__ . '/config/google-credentials.json');
ServerConfig::setScheduleManifest(__DIR__ . '/config/schedule-manifest.json');
