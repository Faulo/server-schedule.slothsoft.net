<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use Slothsoft\Core\Calendar\DateTimeFormatter;
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
    private $dateFormat = DateTimeFormatter::FORMAT_DATETIME;

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
        $node->setAttribute('start', $this->start->format($this->dateFormat));
        $node->setAttribute('start-buffered', $this->start->sub($this->table->getShiftBuffer())
            ->format($this->dateFormat));
        $node->setAttribute('end', $this->end->format($this->dateFormat));
        return $node;
    }
}

