<?php
namespace Slothsoft\Server\Schedule;

class VolunteerSheet extends SheetBase {

    /** @var Volunteer[] */
    private $volunteers = [];

    protected function appendRow(array $data) {
        $this->volunteers[] = new Volunteer($data);
    }

    public function getVolunteerByEmail(string $email): Volunteer {
        foreach ($this->volunteers as $volunteer) {
            if ($volunteer->email === $email) {
                return $volunteer;
            }
        }
        throw new \InvalidArgumentException($email);
    }
}

