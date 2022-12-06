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
            new TwigFilter('skillCard', [$this, 'skillCard'], ['is_safe' => ['html']]),
        ];
    }

   /*  public function getFunctions(): array
    {
        return [
            new TwigFunction('skillCard', [$this, 'skillCard'], ['is_safe' => ['html']]),
        ];
    } */

    public function skillCard($skill)
    {
        $details = "";
        if ($skill["distance"] !== null) {
            if ($skill["distance"] > 0) {
                $distance = $skill["distance"] ." mètres";
            }
            else {
                $distance = "contact";
            }
            $details .= "Portée : {$distance} \n";
        }
        $details .= "Durée : {$skill["duration"]} {$skill["durationType"]} \n";
        if ($skill["damage"] !== null) {
            $details .= "Dégats : {$skill["damage"]} \n";
        }
        if ($skill["radius"] !== null) {
            $details .= "Rayon : {$skill["radius"]} mètres \n";
        }
        $details .= "Jet : {$skill["diceThrow"]} \n";

        $textArea = "<textarea readonly>{$details}\n{$skill["description"]}</textarea>";
        $skillCard = 
        '<div class="competence"><div class="dropdown">
            <button class="dropbtn">'.$skill["name"].', '.$skill["cost"].''.$skill["resource"].'<img src="/img/list.svg" alt="" class="drop-logo" height="10"></button>
            <div class="hidden dropdown-content">
                '.$textArea.'
            </div>
        </div></div> 
        ';
        return $skillCard;
    }
}
