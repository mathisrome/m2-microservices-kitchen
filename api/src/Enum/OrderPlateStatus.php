<?php

namespace App\Enum;

enum OrderPlateStatus: string
{
    case EN_ATTENTE = 'En attente';
    case EN_PREPARATION = 'En préparation';
    case PRET_A_SERVIR = 'Prêt à servir';
}