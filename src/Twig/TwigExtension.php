<?php

namespace Jacquesndl\EasyAdminPlusBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
class TwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('easy_admin_plus_uniqid', [$this, 'getUniqid']),
        ];
    }

    public function getUniqid()
    {
        return uniqid();
    }
}
