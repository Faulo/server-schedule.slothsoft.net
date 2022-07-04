<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use Slothsoft\Core\Configuration\ConfigurationField;
use Slothsoft\Core\Configuration\FileConfigurationField;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class ServerConfig {

    private static function googleCredentials(): FileConfigurationField {
        static $field;
        if ($field === null) {
            $field = new FileConfigurationField();
        }
        return $field;
    }

    public static function setGoogleCredentials(string $file): void {
        self::googleCredentials()->setValue($file);
    }

    public static function getGoogleCredentials(): string {
        return self::googleCredentials()->getValue();
    }

    private static function scheduleManifest(): FileConfigurationField {
        static $field;
        if ($field === null) {
            $field = new FileConfigurationField();
        }
        return $field;
    }

    public static function setScheduleManifest(string $file): void {
        self::scheduleManifest()->setValue($file);
    }

    public static function getScheduleManifest(): string {
        return self::scheduleManifest()->getValue();
    }

    private static function qrOptions(): ConfigurationField {
        static $field;
        if ($field === null) {
            $field = new ConfigurationField(new QROptions());
        }
        return $field;
    }

    public static function setQROptions(QROptions $options): void {
        self::qrOptions()->setValue($options);
    }

    public static function getQROptions(): QROptions {
        return self::qrOptions()->getValue();
    }

    public static function printQR(string $name): string {
        return (new QRCode(self::getQROptions()))->render($name);
    }
}

