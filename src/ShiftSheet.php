<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

class ShiftSheet extends SheetBase {

    /** @var Shift[] */
    private $shifts = [];

    protected function appendRow(array $data): void {
        $this->shifts[] = new Shift($data);
    }

    /**
     *
     * @return Shift[]
     */
    public function getShiftsByEmail(string $email): iterable {
        foreach ($this->shifts as $shift) {
            if ($shift->volunteerEmail === $email) {
                yield $shift;
            }
        }
    }
}

