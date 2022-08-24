<?php

namespace App\Entity;

enum CardVendors: string
{
    case MasterCard = 'master_card';
    case Visa = 'visa';
    case Maestro = "maestro";
    case DaroniCredit = "daroni_credit";
    case Unknown = 'unknown';
}