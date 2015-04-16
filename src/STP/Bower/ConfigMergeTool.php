<?php

namespace STP\Bower;

class ConfigMergeTool
{
    /**
     * @throws \Exception
     */
    public static function mergeConfig()
    {
        exec('ls vendor/*/*/bower.json', $output);

        $dependencies = [];
        foreach ($output as $filename) {
            $dependencies = self::parseDependencies($filename, $dependencies);
        }

        $fileContent = file_get_contents('bower.json');
        if ($fileContent === false) {
            throw new \Exception('Can not read file bower.json');
        }

        $fileContent = json_decode($fileContent, true);
        if ($fileContent === null) {
            throw new \Exception('Can not parse content of file bower.json');
        }

        $dependencies = self::parseDependencies('bower.json', $dependencies);

        $fileContent['dependencies'] = $dependencies;

        file_put_contents('bower.json', json_encode($fileContent));
    }

    /**
     * @param string $filename
     * @param array $dependencies
     *
     * @return array
     * @throws \Exception
     */
    protected static function parseDependencies($filename, $dependencies)
    {
        $fileContent = file_get_contents($filename);
        if ($fileContent === false) {
            throw new \Exception('Can not read file ' . $filename);
        }

        $fileContent = json_decode($fileContent, true);
        if ($fileContent === null) {
            throw new \Exception('Can not parse content of file ' . $filename);
        }

        foreach ($fileContent['dependencies'] as $name => $version) {
            if (isset ($dependencies[$name]) && $dependencies[$name] > $version) {
                continue;
            }

            $dependencies[$name] = $version;
        }

        return $dependencies;
    }
}
