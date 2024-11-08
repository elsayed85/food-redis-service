<?php

namespace Elsayed85\LmsRedis\Utils;

use Elsayed85\LmsRedis\LmsRedis;
use ReflectionClass;

class Service
{
    public static function getAllServices(): array
    {
        $services = [];
        $serviceDir = __DIR__.'/../Services';
        $namespace = 'Elsayed85\\LmsRedis\Services\\';
        $parentClass = new ReflectionClass(LmsRedis::class);

        foreach (glob("$serviceDir/*/*.php") as $file) {
            $className = self::getFullClassName($file, $serviceDir, $namespace);

            if (self::isValidService($className, $parentClass)) {
                $services[] = $className;
            }
        }

        return $services;
    }

    private static function getFullClassName(string $file, string $serviceDir, string $namespace): string
    {
        $folder = str_replace("$serviceDir/", '', dirname($file));
        $className = pathinfo($file, PATHINFO_FILENAME);

        return "$namespace$folder\\$className";
    }

    private static function isValidService(string $className, ReflectionClass $parentClass): bool
    {
        return class_exists($className) && (new ReflectionClass($className))->isSubclassOf($parentClass);
    }
}
