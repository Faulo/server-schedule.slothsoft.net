<?php
namespace Slothsoft\Server\Schedule;

use Slothsoft\Core\ServerEnvironment;

class ScheduleTable {

    /** @var string */
    public $sheetId;

    /** @var string */
    public $sheetName;

    /** @var string */
    public $tableName;

    /** @var string */
    public $location;

    public function __construct(string $sheetId, string $sheetName, string $tableName) {
        $this->sheetId = $sheetId;
        $this->sheetName = $sheetName;
        $this->tableName = $tableName;
        $this->location = $this->buildLocation();
    }

    public function __toString(): string {
        return "$this->sheetName.$this->tableName";
    }

    private function buildLocation(): string {
        $location = ServerEnvironment::getDataDirectory();
        $location .= DIRECTORY_SEPARATOR;
        $location .= $this->sheetName;
        $location .= '.';
        $location .= $this->tableName;
        $location .= '.csv';
        return $location;
    }

    public function save(array $rows): bool {
        $file = temp_file(__NAMESPACE__);
        $handle = fopen($file, 'w');
        if (! $handle) {
            return false;
        }
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        $success = fclose($handle);
        if (! $success) {
            return false;
        }
        copy($file, $this->location);
        chmod($this->location, 0777);
        return true;
    }

    public function load(): ShiftSheet {
        return new ShiftSheet($this->location);
    }
}

