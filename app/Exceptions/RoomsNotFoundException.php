<?php

namespace App\Exceptions;

use Exception;

class RoomsNotFoundException extends Exception
{
    protected $message = 'Nie ma wolnych pokojów w tym terminie';
}
