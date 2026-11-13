<?php

namespace App;

enum Documento : string
{
    case DNI    = 'dni';
    case NIE    = 'nie';
    case NIF    = 'nif';
}
