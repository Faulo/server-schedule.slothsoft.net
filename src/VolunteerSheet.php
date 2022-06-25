<?php
namespace Slothsoft\Server\Schedule;

class VolunteerSheet extends SheetBase {

    /** @var Volunteer[] */
    private $volunteers = [];

    protected function appendRow(array $data) {
        $this->volunteers[] = new Volunteer($data);
    }

    /** @return Volunteer[] */
    public function getVolunteersByEmail(string $email): iterable {
        foreach ($this->volunteers as $volunteer) {
            if ($volunteer->email === $email) {
                yield $volunteer;
            }
        }
    }
}

