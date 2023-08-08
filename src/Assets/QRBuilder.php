<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Adapter\ChunkWriterFromStringWriter;
use Slothsoft\Core\IO\Writable\Delegates\FileWriterFromFileDelegate;
use Slothsoft\Core\IO\Writable\Delegates\StringWriterFromStringDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\ChunkWriterResultBuilder;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\FileWriterResultBuilder;
use Slothsoft\Server\Schedule\ServerConfig;
use chillerlan\QRCode\QRCode;
use SplFileInfo;

class QRBuilder implements ExecutableBuilderStrategyInterface {

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $text = trim($args->get('text', ''));

        if ($text === '') {
            return new ExecutableStrategies(new ChunkWriterResultBuilder(new ChunkWriterFromStringWriter(new StringWriterFromStringDelegate(function () {
                return 'Missing "text" parameter.';
            })), 'error.txt'));
        }

        $writer = function () use ($text): SplFileInfo {
            $file = temp_file(__CLASS__);
            $options = ServerConfig::getQROptions();
            $options->imageTransparent = false;
            (new QRCode($options))->render($text, $file);
            return new SplFileInfo($file);
        };

        $resultBuilder = new FileWriterResultBuilder(new FileWriterFromFileDelegate($writer), 'qr.png');

        return new ExecutableStrategies($resultBuilder);
    }
}

