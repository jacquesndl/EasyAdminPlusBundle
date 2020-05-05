<?php

namespace Jacquesndl\EasyAdminPlusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('jacquesndl_easy_admin_plus');
    }
}
