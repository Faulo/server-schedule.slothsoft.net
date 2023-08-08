<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Sanitizer\StringSanitizer;
use Slothsoft\Farah\Module\Asset\ParameterFilterStrategy\AbstractMapParameterFilter;

class QRParameterFilter extends AbstractMapParameterFilter {

    protected function createValueSanitizers(): array {
        return [
            'text' => new StringSanitizer()
        ];
    }
}

