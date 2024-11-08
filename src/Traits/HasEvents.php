<?php

namespace Elsayed85\LmsRedis\Traits;

use ReflectionClass;

trait HasEvents
{
    public static function events(): array
    {
        $namespace = (new ReflectionClass(static::class))->getNamespaceName().'\\Event';
        $eventFiles = glob(dirname((new ReflectionClass(static::class))->getFileName()).'/Event/*.php');

        $eventClasses = array_filter(array_map(
            fn ($file) => self::getClassFromFile($file, $namespace),
            $eventFiles
        ));

        return array_combine($eventClasses, array_map(
            fn ($event) => self::getConstructorParameterTypes($event),
            $eventClasses
        ));
    }

    private static function getClassFromFile(string $file, string $namespace): ?string
    {
        $className = $namespace.'\\'.pathinfo($file, PATHINFO_FILENAME);

        return class_exists($className) ? $className : null;
    }

    private static function getConstructorParameterTypes(string $class): array
    {
        $constructor = (new ReflectionClass($class))->getConstructor();

        return $constructor
            ? array_map(fn ($param) => $param->getType()?->getName() ?? 'mixed', $constructor->getParameters())
            : [];
    }
}
