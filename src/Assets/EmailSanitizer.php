<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Sanitizer\SanitizerInterface;

class EmailSanitizer implements SanitizerInterface {

    private $default;

    public function __construct(string $default = '') {
        $this->default = $default;
    }

    public function apply($value) {
        $value = (string) $value;
        $value = trim($value);
        return $value === '' ? $this->getDefault() : $value;
    }

    public function getDefault() {
        return $this->default;
    }
}

