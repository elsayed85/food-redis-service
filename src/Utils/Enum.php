<?php

namespace Elsayed85\LmsRedis\Utils;

class Enum
{
    private static function getEnumFiles(string $enumsNamespace): array
    {
        $serviceDir = __DIR__.'/../Services';
        $files = glob("$serviceDir/*/Enum/*.php");
        $namespacePrefix = 'Elsayed85\\LmsRedis\\Services\\';

        $classes = array_map(function ($file) use ($serviceDir, $namespacePrefix) {
            $relativePath = str_replace([$serviceDir.'/', '/'], ['', '\\'], dirname($file));
            $className = $namespacePrefix.$relativePath.'\\'.pathinfo($file, PATHINFO_FILENAME);

            return class_exists($className) ? $className : null;
        }, $files);

        return array_filter($classes);
    }

    private static function all(): array
    {
        return collect(Service::getAllServices())
            ->map(fn ($service) => self::getEnumFiles(substr($service, 0, strrpos($service, '\\')).'\\Enum'))
            ->flatten()
            ->mapWithKeys(fn ($enumClass) => [$enumClass => $enumClass::cases()])
            ->toArray();
    }

    public static function from(string $type): ?object
    {
        foreach (self::all() as $enumCases) {
            $matchingCase = collect($enumCases)->firstWhere('value', $type);
            if ($matchingCase) {
                return $matchingCase;
            }
        }

        return null;
    }
}
