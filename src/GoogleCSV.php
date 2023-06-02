<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use phpseclib3\Exception\FileNotFoundException;

class GoogleCSV {

    /** @var string */
    private $location;

    public function __construct(string $location) {
        if (! is_file($location)) {
            throw new FileNotFoundException($location);
        }
        $this->location = $location;
    }

    /**
     *
     * @return array
     */
    public function getRows(): iterable {
        if ($handle = fopen($this->location, 'r')) {
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
                    $row[$key] = $data[$i] ?? '';
                }
                yield $row;
            }

            fclose($handle);
        }
    }
}

