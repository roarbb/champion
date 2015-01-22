<?php namespace Champion\Helpers\Objects;

use Champion\Core\ServiceContainer;

/**
 * Class PropertiesInjector
 * @package Champion\Helpers\Objects
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PropertiesInjector
{
    private $injectPlaceholder = "@inject";

    public function injectProperties($classRequestedProperty, array $properties, ServiceContainer $serviceContainer)
    {
        if (empty($properties)) {
            return false;
        }

        /** @var \ReflectionProperty $property */
        foreach ($properties as $property) {
            $classNameToInject = $this->getClassNameFromDocBlock($property);
            $this->setClassToProperty($classRequestedProperty, $property, $classNameToInject, $serviceContainer);
        }
    }

    private function getClassNameFromDocBlock(\ReflectionProperty $property)
    {
        $docblock = $property->getDocComment();
        preg_match('/' . $this->injectPlaceholder . ' (.*?) /ism', $docblock, $match);

        if (isset($match[1]) && !empty($match[1])) {
            return trim($match[1]);
        }

        return false;
    }

    private function setClassToProperty(
        $classRequestedProperty,
        \ReflectionProperty $property,
        $classNameToInject,
        ServiceContainer $serviceContainer
    ) {
        if (!$classNameToInject) {
            return false;
        }

        $classObject = new ClassObject($classNameToInject);
        $propertyClass = $classObject->getInstanceWithDependencies($serviceContainer);
        $property->setValue($classRequestedProperty, $propertyClass);
    }
}
