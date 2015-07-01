<?php

/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DoctrineDtoBundle\Tests\DependencyInjection;

use KonstantinKuklin\DoctrineDtoBundle\DependencyInjection\Configuration;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testValidClassMap()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(
            new Configuration(),
            array(
                array(
                    'class_map' => array(
                        'Entity1' => 'Dto1'
                    ),
                    'map_generator_dto' => array(
                        'KonstantinKuklin\DoctrineDtoBundle\Tests\DependencyInjection\SimpleGenerator'
                    ),
                    'map_generator_entity' => array(
                        'KonstantinKuklin\DoctrineDtoBundle\Tests\DependencyInjection\SimpleGenerator'
                    )
                )
            )
        );

        self::assertEquals(array('Entity1' => 'Dto1'), $config['class_map']);
    }

    public function testInvalidDtoMapGenerator()
    {
        self::setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');

        $processor = new Processor();
        $config = $processor->processConfiguration(
            new Configuration(),
            array(
                array(
                    'class_map' => array(
                        'Entity1' => 'Dto1'
                    ),
                    'map_generator_dto' => array(
                        'stdClass'
                    )
                )
            )
        );

        self::assertEquals(array('Entity1' => 'Dto1'), $config['class_map']);
    }

    public function testInvalidEntityMapGenerator()
    {
        self::setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');

        $processor = new Processor();
        $config = $processor->processConfiguration(
            new Configuration(),
            array(
                array(
                    'class_map' => array(
                        'Entity1' => 'Dto1'
                    ),
                    'map_generator_entity' => array(
                        'stdClass'
                    )
                )
            )
        );

        self::assertEquals(array('Entity1' => 'Dto1'), $config['class_map']);
    }
}