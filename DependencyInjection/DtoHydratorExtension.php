<?php

namespace KonstantinKuklin\DoctrineDtoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DtoHydratorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        //        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        //        $loader->load('services.yml');

        $container->setParameter('doctrine_dto.class_map', $config['class_map']);
        $container->setParameter('doctrine_dto.map_generator_dto', $config['map_generator_dto']);
        $container->setParameter('doctrine_dto.map_generator_entity', $config['map_generator_entity']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'doctrine_dto';
    }
}
