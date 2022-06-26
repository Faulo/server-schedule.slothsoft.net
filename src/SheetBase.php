<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use phpseclib3\Exception\FileNotFoundException;

abstract class SheetBase {

    public function __construct(string $location) {
        if (! is_file($location)) {
            throw new FileNotFoundException($location);
        }

        if ($handle = fopen($location, 'r')) {
            // 1st row is header
            if ($data = fgetcsv($handle)) {
                $indices = [];
                foreach ($data as $i => $key) {
                    if (strlen($key)) {
                        $indices[$key] = $i;
                    }
                }
            }

            // 2nd row is irrelevant
            fgetcsv($handle);

            // all remaining rows are data
            while ($data = fgetcsv($handle)) {
                $row = [];
                foreach ($indices as $key => $i) {
                    if (!isset($data[$i])) {
                        break;
                    }
                    $row[$key] = $data[$i];
                }
                $this->appendRow($row);
            }

            fclose($handle);
        }
    }

    protected abstract function appendRow(array $row): void;
}

