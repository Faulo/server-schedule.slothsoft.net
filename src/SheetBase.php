<?php
namespace Slothsoft\Server\Schedule;

abstract class SheetBase {

    public function __construct(string $location) {
        if ($handle = fopen($location, 'r')) {
            $data = fgetcsv($handle);
            $indices = [];
            foreach ($data as $i => $key) {
                if (strlen($key)) {
                    $indices[$key] = $i;
                }
            }
            while ($data = fgetcsv($handle)) {
                $row = [];
                foreach ($indices as $key => $i) {
                    $row[$key] = $data[$i];
                }
                $this->appendRow($row);
            }
            fclose($handle);
        }
    }

    protected abstract function appendRow(array $row);
}

