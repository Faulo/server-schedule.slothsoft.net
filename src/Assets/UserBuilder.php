<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Delegates\DOMWriterFromElementDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\DOMWriterResultBuilder;
use DOMDocument;
use DOMElement;
use Slothsoft\Server\Schedule\ScheduleManifest;

class UserBuilder implements ExecutableBuilderStrategyInterface {

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $id = $args->get('id');

        $writer = function (DOMDocument $targetDoc) use ($id): DOMElement {
            $manifest = new ScheduleManifest();
            $rootNode = $targetDoc->createElement('user');
            $rootNode->setAttribute('id', $id);
            foreach ($manifest->getSchedules($id) as $shift) {
                $rootNode->setAttribute('name', $shift->name);

                $node = $targetDoc->createElement('shift');
                $node->setAttribute('name', $shift->shiftName);
                $rootNode->appendChild($node);
            }
            return $rootNode;
        };

        $resultBuilder = new DOMWriterResultBuilder(new DOMWriterFromElementDelegate($writer), 'user.xml');

        return new ExecutableStrategies($resultBuilder);
    }
}

