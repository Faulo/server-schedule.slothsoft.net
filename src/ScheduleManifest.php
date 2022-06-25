<?php
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
     * @return Volunteer[]
     */
    public function getSchedules(string $email): iterable {
        foreach ($this->tables as $table) {
            $sheet = $table->load();
            yield from $sheet->getVolunteersByEmail($email);
        }
    }
}

