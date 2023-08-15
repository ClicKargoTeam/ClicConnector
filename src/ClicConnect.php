<?php

namespace ClicKargoTeam\ClicConnector;

use AllowDynamicProperties;
use ClicKargoTeam\ClicConnector\Exceptions\ClicConnectServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Throwable;

#[AllowDynamicProperties]
class ClicConnect
{
    /**
     * Dynamically instantiate all connection services
     * from app/Services/Connections directory.
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function __construct()
    {
        if (config('clicconnect.autoload')) {
            $path = config('clicconnect.directory');
            $this->loadFromDir($path);
        }
    }

    public function __call($name, $arguments)
    {
        return $this->$name;
    }

    /**
     * Check if we should throw error.
     *
     * @return bool
     */
    private function shouldThrowError(): bool
    {
        return (bool) config('clicconnect.throw_error');
    }

    /**
     * Add a new connection service.
     *
     * @param  string  $filePath
     *
     * @throws BindingResolutionException
     * @throws Throwable
     *
     * @return void
     */
    public function add(string $filePath): void
    {
        throw_if(
            !file_exists($filePath) && $this->shouldThrowError(),
            ClicConnectServiceException::invalidPath($filePath)
        );

        $this->makeService(file: $filePath);
    }

    /**
     * @param  string  $file
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    private function makeService(string $file): void
    {
        $classFullName = $this->getClassFullNameFromFile($file);
        $basename = basename($file, '.php');

        app()->singleton($classFullName);
        $this->{$this->getServiceName($basename)} = app()->make($classFullName);
    }

    /**
     * @param  string  $baseFilename
     *
     * @return string
     */
    private function getServiceName(string $baseFilename): string
    {
        return strtolower(str_replace('Connection', '', $baseFilename));
    }

    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class".
     *
     * @param  string  $filePathName
     *
     * @return  string
     */
    public function getClassFullNameFromFile(string $filePathName): string
    {
        return $this->getClassNamespaceFromFile($filePathName).'\\'.$this->getClassNameFromFile($filePathName);
    }

    /**
     * get the class namespace form file path using token.
     *
     * @param $filePathName
     *
     * @return  string|null
     */
    protected function getClassNamespaceFromFile($filePathName): ?string
    {
        $src = file_get_contents($filePathName);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace = trim($namespace);

                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }

                break;
            }
            ++$i;
        }
        if (!$namespace_ok) {
            return null;
        }

        return $namespace;
    }

    /**
     * get the class name form file path using token.
     *
     * @param  string  $filePathName
     *
     * @return  string
     */
    protected function getClassNameFromFile(string $filePathName): string
    {
        $php_code = file_get_contents($filePathName);

        $classes = [];
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; ++$i) {
            if ($tokens[$i - 2][0] === T_CLASS
                && $tokens[$i - 1][0] === T_WHITESPACE
                && $tokens[$i][0] === T_STRING
            ) {
                $classes[] = $tokens[$i][1];
            }
        }

        return $classes[0];
    }

    /**
     * Add Directory of connection services.
     *
     * @param  string  $path
     *
     * @throws BindingResolutionException
     * @throws Throwable
     *
     * @return void
     */
    public function loadFromDir(string $path): void
    {
        throw_if(
            !file_exists($path) && $this->shouldThrowError(),
            ClicConnectServiceException::invalidPath($path)
        );

        // list every class on app/Services/Connections directory
        foreach (glob("{$path}/*.php", GLOB_NOSORT) as $file) {
            $this->makeService(file: $file);
        }
    }
}
