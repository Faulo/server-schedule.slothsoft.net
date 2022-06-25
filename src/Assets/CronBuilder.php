<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Delegates\ChunkWriterFromChunksDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\ChunkWriterResultBuilder;
use Slothsoft\Server\Schedule\GoogleClient;
use Slothsoft\Server\Schedule\ScheduleManifest;
use Generator;

class CronBuilder implements ExecutableBuilderStrategyInterface {

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $writer = function (): Generator {
            $manifest = new ScheduleManifest();

            $client = new GoogleClient();
            $values = $client->getSpreadsheetValues();

            yield 'Re-downloading schedule tables:' . PHP_EOL;

            sleep(1);

            foreach ($manifest->getTables() as $scheduleTable) {
                yield "  $scheduleTable...";
                sleep(1);
                $response = $values->get($scheduleTable->sheetId, $scheduleTable->tableName);
                if ($scheduleTable->save($response->getValues())) {
                    yield 'OK!' . PHP_EOL;
                } else {
                    yield 'ERROR!' . PHP_EOL;
                }
            }
        };
        $resultBuilder = new ChunkWriterResultBuilder(new ChunkWriterFromChunksDelegate($writer), 'cron.txt', false);
        return new ExecutableStrategies($resultBuilder);
    }
}

