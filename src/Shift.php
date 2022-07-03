<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use DateTime;

class Shift {

    /** @var ScheduleTable */
    public $table;

    /** @var string */
    public $volunteer;

    /** @var string */
    public $name;

    /** @var string */
    public $location;

    /** @var DateTime */
    public $start;

    /** @var string */
    public $end;

    /** @var string */
    private $dateFormat = 'D, d.m.Y';

    /** @var string */
    private $timeFormat = 'H:i';

    public function __construct(ScheduleTable $table, array $data) {
        $this->table = $table;

        $this->volunteer = $data['VOLUNTEER_NAME'] ?? '';
        $this->name = $data['SHIFT_NAME'] ?? '';
        $this->location = $data['SHIFT_LOCATION'] ?? '';

        $date = $this->table->getDate();
        $this->start = new DateTime("$date {$data['SHIFT_START']}");
        $this->end = new DateTime("$date {$data['SHIFT_END']}");
    }

    public function asNode(\DOMDocument $document): \DOMElement {
        $node = $document->createElement('shift');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('location', $this->location);

        $buffered = $this->start->sub($this->table->getShiftBuffer());
        $node->setAttribute('date', $this->start->format($this->dateFormat));
        $node->setAttribute('start', $this->start->format($this->timeFormat));
        $node->setAttribute('date-buffered', $buffered->format($this->dateFormat));
        $node->setAttribute('start-buffered', $buffered->format($this->timeFormat));
        $node->setAttribute('end', $this->end->format($this->timeFormat));

        return $node;
    }
}

