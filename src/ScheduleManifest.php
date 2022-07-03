<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use phpseclib3\Exception\FileNotFoundException;

class ScheduleManifest {

    /** @var ScheduleSheet[] */
    private $sheets = [];

    public function __construct() {
        $file = ServerConfig::getScheduleManifest();
        if (! is_file($file)) {
            throw new FileNotFoundException($file);
        }
        $manifest = json_decode(file_get_contents($file), true);
        foreach ($manifest as $sheet) {
            $this->sheets[] = new ScheduleSheet($sheet);
        }
    }

    /**
     *
     * @return ScheduleTable[]
     */
    public function getTables(): iterable {
        foreach ($this->sheets as $sheet) {
            yield from $sheet->getTables();
        }
    }

    /**
     *
     * @return Volunteer
     */
    public function getVolunteerByEmail(string $email): Volunteer {
        $volunteer = new Volunteer($email);
        foreach ($this->getTables() as $table) {
            if ($table->exists()) {
                foreach ($table->getShiftsByEmail($email) as $shift) {
                    $volunteer->appendShift($shift);
                }
            }
        }
        return $volunteer;
    }
}

