<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

class Volunteer {

    /** @var string */
    public $email;

    /** @var string */
    public $name;

    /** @var Shift[] */
    public $shifts = [];

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function appendShift(Shift $shift): void {
        if (! $this->name) {
            $this->name = $shift->getVolunteerName();
            $this->email = $shift->getVolunteerEmail();
        }
        $this->shifts[] = $shift;
    }

    public function asNode(\DOMDocument $document): \DOMElement {
        $node = $document->createElement('user');
        $node->setAttribute('email', $this->email);
        if ($this->name !== null) {
            $node->setAttribute('name', $this->name);
        }
        foreach ($this->shifts as $shift) {
            $node->appendChild($shift->asNode($document));
        }
        return $node;
    }
}

