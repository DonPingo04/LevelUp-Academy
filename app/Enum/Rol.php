<?php

namespace App;

enum Rol : string
{
    case Secretaria = 'secretaria';
    case Profesor   = 'profesor';
    case Familiar   = 'familiar';
    case Alumno     = 'alumno';
}
