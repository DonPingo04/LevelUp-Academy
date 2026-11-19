<?php

namespace App;

enum TipoAsistencia : string
{
    case Presente           = 'presente';
    case Falta              = 'falta';
    case Justificada        = 'justificada';
    case Retraso            = 'retraso';
}