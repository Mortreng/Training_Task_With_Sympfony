<?php

namespace App\Entity\Card;

enum CardVendors
{
    case MasterCard;
    case Visa;
    case Maestro;
    case DaroniCredit;
    case Unknown;
}