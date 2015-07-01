<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DoctrineDtoBundle\Tests\DependencyInjection;


use KonstantinKuklin\DoctrineDto\Configuration\MapGeneratorInterface;

class SimpleGenerator implements MapGeneratorInterface
{

    /**
     * @param string $classPath
     *
     * @return string
     */
    public function getPath($classPath)
    {
        // TODO: Implement getPath() method.
    }
}