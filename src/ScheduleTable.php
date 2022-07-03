<?php
namespace Slothsoft\Server\Schedule;

use Slothsoft\Core\ServerEnvironment;
use DateInterval;

class ScheduleTable {

    /** @var ScheduleSheet */
    private $sheet;

    /** @var string */
    private $id;

    /** @var string */
    private $date;

    /** @var CsvSheet */
    private $csv;

    /** @var string */
    private $location;

    public function __construct(ScheduleSheet $sheet, array $table) {
        $this->sheet = $sheet;
        $this->id = $table['id'];
        $this->date = $table['date'];
        $this->location = $this->buildLocation();
    }

    public function getSheetId(): string {
        return $this->sheet->getId();
    }

    public function getId(): string {
        return $this->id;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getShiftBuffer(): DateInterval {
        return $this->sheet->getShiftBuffer();
    }

    public function __toString(): string {
        return "{$this->sheet->getName()}.{$this->getId()}";
    }

    private function buildLocation(): string {
        $location = ServerEnvironment::getDataDirectory();
        $location .= DIRECTORY_SEPARATOR;
        $location .= $this->sheet->getName();
        $location .= '.';
        $location .= $this->getId();
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

    public function exists(): bool {
        return is_file($this->location) and is_readable($this->location);
    }

    private function load(): void {
        $this->csv = new CsvSheet($this->location);
    }

    /**
     *
     * @return Shift[]
     */
    public function getShiftsByEmail(string $email): iterable {
        if ($this->csv === null) {
            $this->load();
        }
        foreach ($this->csv->getRows() as $shift) {
            if ($shift['VOLUNTEER_EMAIL'] === $email) {
                yield new Shift($this, $shift);
            }
        }
    }
}

