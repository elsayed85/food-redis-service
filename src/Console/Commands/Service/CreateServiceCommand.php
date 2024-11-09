<?php

namespace Elsayed85\LmsRedis\Console\Commands\Service;

use Elsayed85\LmsRedis\Console\Command;

class CreateServiceCommand extends Command
{
    protected string $command = 'make:redis-service name';

    protected string $description = 'Create exception class';

    protected string $stub = 'exception';

    protected function handle($input, $output): int
    {
        $name = $this->validateServiceName($input, $output);
        if (! $name) {
            return 1;
        }

        $nameLower = strtolower($name);
        $serviceName = $this->getServiceName($name);
        $baseDir = __DIR__.'/../../../Services';
        $dstDir = $baseDir.'/'.$serviceName;

        $this->copyDirectory($baseDir.'/BaseService', $dstDir);
        $this->renameAndReplaceInFiles($dstDir, $name, $serviceName, $nameLower);

        $output->writeln('<info>Service created successfully!</info>');

        return 0;
    }

    private function validateServiceName($input, $output): ?string
    {
        $name = $input->getArgument('name');

        if ($this->isInvalidName($name, $output)) {
            return null;
        }
        return ucfirst($name);
    }

    private function isInvalidName(string $name, $output): bool
    {
        if (preg_match('/^\d/', $name)) {
            $output->writeln('<error>Service name must not start with a number!</error>');

            return true;
        }

        if (preg_match('/[^A-Za-z0-9]/', $name)) {
            $output->writeln('<error>Service name must not contain special characters!</error>');

            return true;
        }

        if (str_starts_with($name, 'Redis') || str_starts_with($name, 'redis')) {
            $output->writeln('<error>Service name must not start with Redis or redis!</error>');

            return true;
        }

        return false;
    }

    private function renameAndReplaceInFiles(string $dstDir, string $name, string $serviceName, string $nameLower): void
    {
        $this->renameFiles($dstDir.'/DTO', 'ServiceData', $name.'Data');
        $this->renameFiles($dstDir.'/Enum', 'ServiceEvent', $name.'Event');
        $this->renameEventFiles($dstDir, $name);
        $this->renameFiles($dstDir, 'RedisService', $name.'RedisService');

        $this->replaceInFiles($dstDir, '{ServiceName}', $name);
        $this->replaceInFiles($dstDir, '{ServiceFullName}', $serviceName);
        $this->replaceInFiles($dstDir, '{ServiceNameLower}', $nameLower);
    }

    private function renameEventFiles(string $dstDir, string $name): void
    {
        $events = ['Created', 'Updated', 'Deleted'];
        foreach ($events as $event) {
            $this->renameFiles($dstDir.'/Event', 'Service'.$event.'Event', $name.$event.'Event');
        }
    }

    private function copyDirectory(string $src, string $dst): void
    {
        mkdir($dst, 0777, true);

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $dstPath = $dst.'/'.$iterator->getSubPathName();
            if ($item->isDir()) {
                mkdir($dstPath);
            } else {
                copy($item, $dstPath);
            }
        }
    }

    private function replaceInFiles(string $dir, string $search, string $replace): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $contents = file_get_contents($file->getRealPath());
                file_put_contents($file->getRealPath(), str_replace($search, $replace, $contents));
            }
        }
    }

    private function renameFiles(string $dir, string $search, string $replace): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && strpos($file->getFilename(), $search) !== false) {
                $newName = str_replace([$search, '.stub'], [$replace, '.php'], $file->getFilename());
                rename($file->getRealPath(), $file->getPath().'/'.$newName);
            }
        }
    }

    private function getServiceName(string $name): string
    {
        return str_ends_with($name, 'Service') ? $name : $name.'Service';
    }
}
