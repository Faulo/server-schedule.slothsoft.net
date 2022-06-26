<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use phpseclib3\Exception\FileNotFoundException;

class GoogleClient {

    /** @var \Google\Client */
    private $client;

    /** @var \Google\Service\Sheets */
    private $service;

    public function __construct() {
        $this->client = self::getClient();
        $this->service = new \Google\Service\Sheets($this->client);
    }

    public function getSpreadsheetValues(): \Google\Service\Sheets\Resource\SpreadsheetsValues {
        return $this->service->spreadsheets_values;
    }

    private static function getClient(): \Google\Client {
        $file = ServerConfig::getGoogleCredentials();
        if (! is_file($file)) {
            throw new FileNotFoundException($file);
        }

        $client = new \Google\Client();
        $client->setApplicationName('My PHP App');
        $client->setScopes([
            \Google\Service\Sheets::SPREADSHEETS_READONLY
        ]);
        $client->setAccessType('offline');
        $client->setAuthConfig($file);

        return $client;
    }
}

