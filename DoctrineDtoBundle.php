<?php

namespace KonstantinKuklin\DoctrineDtoBundle;

use KonstantinKuklin\DoctrineDto\Configuration\Map;
use KonstantinKuklin\DoctrineDto\Configuration\MapInterface;
use KonstantinKuklin\DoctrineDto\DtoClassMap;
use KonstantinKuklin\DoctrineDtoBundle\DependencyInjection\DtoHydratorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineDtoBundle extends Bundle
{
    public function boot()
    {
        $classMap           = $this->container->getParameter('doctrine_dto.class_map');
        $mapGeneratorDto    = $this->container->getParameter('doctrine_dto.map_generator_dto');
        $mapGeneratorEntity = $this->container->getParameter('doctrine_dto.map_generator_entity');

        $entityDtoMap = new Map();

        foreach ($classMap as $entityPath => $dtoPath) {
            $entityDtoMap->addMapElement($entityPath, $dtoPath);
        }

        foreach ($mapGeneratorDto as $classPath) {
            /** @var MapInterface $classPath */
            $object = new $classPath();
            $entityDtoMap->addMapGeneratorElement($object);
        }

        $dtoEntityMap = $entityDtoMap->getFlippedMap();
        foreach ($mapGeneratorEntity as $classPath) {
            /** @var MapInterface $classPath */
            $object = new $classPath();
            $dtoEntityMap->addMapGeneratorElement($object);
        }

        DtoClassMap::setMap($entityDtoMap, $dtoEntityMap);
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerExtension(new DtoHydratorExtension());
    }
}