<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Delegates\DOMWriterFromDocumentDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\DOMWriterResultBuilder;
use DOMDocument;

class CronBuilder implements ExecutableBuilderStrategyInterface {

    public const CREDENTIALS_LOCATION = '../config/credentials.json';

    public const SCHEDULE_ID = '1aaARqmsTbQ10YRjugEL-YeEhNFGU9uXVZBPHfQVmrIU';

    public const SCHEDULE_RANGE = 'Termine!A2:B';

    public const SCHEDULE_LOCATION = '../config/schedule.xml';

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $writer = function (): DOMDocument {
            $client = $this->getClient();
            $service = new \Google\Service\Sheets($client);

            $response = $service->spreadsheets_values->get(self::SCHEDULE_ID, self::SCHEDULE_RANGE);
            $values = $response->getValues();

            $targetDoc = new \DOMDocument();
            $rootNode = $targetDoc->createElement('schedule');
            foreach ($values as $row) {
                $date = date('d.m.y', strtotime(str_replace('/', '.', $row[0])));
                $name = $row[1] ?? '';
                $node = $targetDoc->createElement('row');
                $node->setAttribute('date', $date);
                $node->setAttribute('name', $name);
                $rootNode->appendChild($node);
            }
            $targetDoc->appendChild($rootNode);

            return $targetDoc;
        };
        $resultBuilder = new DOMWriterResultBuilder(new DOMWriterFromDocumentDelegate($writer), 'user.xml');
        return new ExecutableStrategies($resultBuilder);
    }

    private function getClient(): \Google\Client {
        $client = new \Google\Client();
        $client->setApplicationName('My PHP App');
        $client->setScopes([
            \Google\Service\Sheets::SPREADSHEETS_READONLY
        ]);
        $client->setAccessType('offline');
        $client->setAuthConfig(self::CREDENTIALS_LOCATION);

        return $client;
    }
}

