<?php
namespace Slothsoft\Server\Schedule;

class Volunteer {

    /** @var string */
    public $email;
    
    /** @var string */
    public $name;
    
    /** @var string */
    public $shiftName;

    public function __construct(array $data) {
        $this->email = $data['VOLUNTEER_EMAIL'] ?? '';
        $this->name = $data['VOLUNTEER_NAME'] ?? '';
        $this->shiftName = $data['SHIFT_NAME'] ?? '';
    }
}

