<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use phpseclib3\Exception\FileNotFoundException;

class ScheduleManifest {

    /** @var ScheduleTable[] */
    private $tables = [];

    public function __construct() {
        $file = ServerConfig::getScheduleManifest();
        if (! is_file($file)) {
            throw new FileNotFoundException($file);
        }
        $manifest = json_decode(file_get_contents($file), true);
        foreach ($manifest as $sheet) {
            foreach ($sheet['tables'] as $tableName) {
                $this->tables[] = new ScheduleTable($sheet['id'], $sheet['name'], $tableName);
            }
        }
    }

    /**
     *
     * @return ScheduleTable[]
     */
    public function getTables(): iterable {
        return $this->tables;
    }

    /**
     *
     * @return Volunteer
     */
    public function getVolunteerByEmail(string $email): Volunteer {
        $volunteer = new Volunteer($email);
        foreach ($this->tables as $table) {
            if ($table->exists()) {
                $sheet = $table->load();
                foreach ($sheet->getShiftsByEmail($email) as $shift) {
                    $volunteer->appendShift($shift);
                }
            }
        }
        return $volunteer;
    }
}

