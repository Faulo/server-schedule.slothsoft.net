<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Delegates\FileWriterFromFileDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\FileWriterResultBuilder;
use Slothsoft\Server\Schedule\ServerConfig;
use chillerlan\QRCode\QRCode;
use SplFileInfo;

class QRBuilder implements ExecutableBuilderStrategyInterface {

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $text = $args->get('text', '');

        $writer = function () use ($text): SplFileInfo {
            $file = tmp_file(__CLASS__);
            (new QRCode(ServerConfig::getQROptions()))->render($text, $file);
            return new SplFileInfo($file);
        };

        $resultBuilder = new FileWriterResultBuilder(new FileWriterFromFileDelegate($writer), 'qr.png');

        return new ExecutableStrategies($resultBuilder);
    }
}

