<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

class Shift {

    /** @var string */
    public $volunteer;

    /** @var string */
    public $name;

    /** @var string */
    public $location;

    /** @var string */
    public $start;

    /** @var string */
    public $end;

    public function __construct(array $data) {
        $this->volunteer = $data['VOLUNTEER_NAME'] ?? '';
        $this->name = $data['SHIFT_NAME'] ?? '';
        $this->location = $data['SHIFT_LOCATION'] ?? '';
        $this->start = $data['SHIFT_START'] ?? '';
        $this->end = $data['SHIFT_END'] ?? '';
    }

    public function asNode(\DOMDocument $document): \DOMElement {
        $node = $document->createElement('shift');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('location', $this->location);
        $node->setAttribute('start', $this->start);
        $node->setAttribute('end', $this->end);
        return $node;
    }
}

