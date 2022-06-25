<?php
namespace Slothsoft\Server\Schedule;

class ScheduleManifest {

    /** @var ScheduleTable[] */
    private $tables = [];

    public function __construct() {
        $manifest = json_decode(file_get_contents(ServerConfig::getScheduleManifest()), true);
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
}

