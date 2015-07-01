<?php

namespace KonstantinKuklin\DoctrineDtoBundle\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $configuration = $this;

        $rootNode = $treeBuilder->root('doctrine_dto');
        $rootNode
            ->children()
                ->arrayNode('class_map')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('map_generator_dto')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function ($v) use ($configuration) {
                                $v = trim($v);
                                $configuration->isMapGeneratorInterface($v);
                                return $v;
                            })
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('map_generator_entity')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function ($v) use ($configuration) {
                                $v = trim($v);
                                $configuration->isMapGeneratorInterface($v);
                                return $v;
                            })
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param string $classPath
     *
     * @return bool|null
     */
    public function isMapGeneratorInterface($classPath)
    {
        return $this->isImplement('KonstantinKuklin\DoctrineDto\Configuration\MapGeneratorInterface', $classPath);
    }

    /**
     * @param string $interfacePath
     * @param string $classPath
     *
     * @return bool|null
     */
    private function isImplement($interfacePath, $classPath)
    {
        if (!class_exists($classPath)) {
            throw new InvalidConfigurationException('The class path: [' . $classPath . '] was not found.');
        }
        $classImplementList = array_flip(class_implements($classPath, true));

        if (!isset($classImplementList[$interfacePath])) {
            throw new InvalidConfigurationException(
                'The class:[' . $classPath . '] should implement:[' . $interfacePath . '].'
            );
        }

        return true;
    }
}
