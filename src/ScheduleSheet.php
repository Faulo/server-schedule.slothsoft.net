<?php
namespace Slothsoft\Server\Schedule;

class ScheduleSheet extends SheetBase {

    /** @var Schedule[] */
    private $schedules = [];

    protected function appendRow(array $data) {
        $this->schedules[] = new Schedule($data);
    }
}

