<?php
namespace Slothsoft\Server\Schedule;

class Volunteer {

    /** @var string */
    public $email;

    /** @var string */
    public $name;

    public function __construct(array $data) {
        $this->email = $data['Email'];
        $this->name = $data['Name'];
    }
}

