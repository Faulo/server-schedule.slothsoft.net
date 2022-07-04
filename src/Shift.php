<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

use DateTime;

class Shift {

    /** @var ScheduleTable */
    private $table;

    /** @var string */
    private $volunteerName;

    /** @var string */
    private $volunteerEmail;

    /** @var string */
    private $name;

    /** @var string */
    private $location;

    /** @var string */
    private $note;

    /** @var DateTime */
    private $start;

    /** @var DateTime */
    private $end;

    /** @var string */
    private $dateFormat = 'D, d.m.Y';

    /** @var string */
    private $timeFormat = 'H:i';

    public function __construct(ScheduleTable $table, array $data) {
        $this->table = $table;

        $this->volunteerName = $data['VOLUNTEER_NAME'] ?? '';
        $this->volunteerEmail = $data['VOLUNTEER_EMAIL'] ?? '';
        $this->name = $data['SHIFT_NAME'] ?? '';
        $this->location = $data['SHIFT_LOCATION'] ?? '';

        $date = $this->table->getDate();
        $this->start = new DateTime("$date {$data['SHIFT_START']}");
        $this->end = new DateTime("$date {$data['SHIFT_END']}");
    }

    public function getVolunteerName(): string {
        return $this->volunteerName;
    }

    public function getVolunteerEmail(): string {
        return $this->volunteerEmail;
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

