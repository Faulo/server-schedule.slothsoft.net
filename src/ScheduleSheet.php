<?php
namespace Slothsoft\Server\Schedule;

use DateInterval;

class ScheduleSheet {

    /**
     *
     * @var string
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var DateInterval
     */
    private $shiftBuffer;

    /** @var ScheduleSheet[] */
    private $tables = [];

    public function __construct(array $sheet) {
        $this->id = $sheet['id'];
        $this->name = $sheet['name'];
        $this->shiftBuffer = new DateInterval($sheet['shift-buffer'] ?? 'PT0S');
        if (isset($sheet['tables'])) {
            foreach ($sheet['tables'] as $table) {
                $this->tables[] = new ScheduleTable($this, $table);
            }
        }
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getShiftBuffer(): DateInterval {
        return $this->shiftBuffer;
    }

    /**
     *
     * @return ScheduleTable[]
     */
    public function getTables(): iterable {
        return $this->tables;
    }
}

