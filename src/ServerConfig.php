<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use Slothsoft\Core\Configuration\FileConfigurationField;

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
}

