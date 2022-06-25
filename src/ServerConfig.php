<?php
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

    public static function setGoogleCredentials(string $file) {
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

    public static function setScheduleManifest(string $file) {
        self::scheduleManifest()->setValue($file);
    }

    public static function getScheduleManifest(): string {
        return self::scheduleManifest()->getValue();
    }
}

