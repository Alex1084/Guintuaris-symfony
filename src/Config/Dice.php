<?php

namespace App\Config;

enum Dice: string
{
    case diceZero = '0D0';
    case diceFour = '1D4';
    case diceSix = '1D6';
    case diceEight = '1D8';
    case diceTen = '1D10';
    case diceTwelve = '1D12';
    case diceTwenty = '1D20';
    case diceFourByTwo = '1D4/2';
}