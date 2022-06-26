<?php
declare(strict_types = 1);
namespace Slothsoft\Server\Schedule\Assets;

use Slothsoft\Core\IO\Writable\Delegates\DOMWriterFromElementDelegate;
use Slothsoft\Farah\FarahUrl\FarahUrlArguments;
use Slothsoft\Farah\Module\Asset\AssetInterface;
use Slothsoft\Farah\Module\Asset\ExecutableBuilderStrategy\ExecutableBuilderStrategyInterface;
use Slothsoft\Farah\Module\Executable\ExecutableStrategies;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\DOMWriterResultBuilder;
use Slothsoft\Farah\Module\Executable\ResultBuilderStrategy\NullResultBuilder;
use DOMDocument;
use DOMElement;
use Slothsoft\Server\Schedule\ScheduleManifest;

class UserBuilder implements ExecutableBuilderStrategyInterface {

    public function buildExecutableStrategies(AssetInterface $context, FarahUrlArguments $args): ExecutableStrategies {
        $id = $args->get('user');
        
        if (!$id) {
            return new ExecutableStrategies(new NullResultBuilder());
        }
        
        $manifest = new ScheduleManifest();
        $volunteer = $manifest->getVolunteerByEmail($id);

        $writer = function (DOMDocument $document) use ($volunteer): DOMElement {
            return $volunteer->asNode($document);
        };

        $resultBuilder = new DOMWriterResultBuilder(new DOMWriterFromElementDelegate($writer), 'user.xml');

        return new ExecutableStrategies($resultBuilder);
    }
}

