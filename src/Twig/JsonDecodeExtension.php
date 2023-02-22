<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SkillExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
        ];
    }

   /*  public function getFunctions(): array
    {
        return [
            new TwigFunction('skillCard', [$this, 'skillCard'], ['is_safe' => ['html']]),
        ];
    } */

    public function jsonDecode($data)
    {
        return json_decode($data);
    }
}
