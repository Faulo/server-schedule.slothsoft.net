<?php
namespace Slothsoft\Server\Schedule;

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
        $client = new \Google\Client();
        $client->setApplicationName('My PHP App');
        $client->setScopes([
            \Google\Service\Sheets::SPREADSHEETS_READONLY
        ]);
        $client->setAccessType('offline');
        $client->setAuthConfig(ServerConfig::getGoogleCredentials());

        return $client;
    }
}

