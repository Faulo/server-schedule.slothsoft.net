<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule;

class ShiftSheet extends SheetBase {

    /**
     *
     * @return Shift[]
     */
    public function getShiftsByEmail(string $email): iterable {
        foreach ($this->getRows() as $shift) {
            if ($shift['VOLUNTEER_EMAIL'] === $email) {
                yield new Shift($shift);
            }
        }
    }
}

