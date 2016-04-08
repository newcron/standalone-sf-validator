<?php

namespace Constraints;

use Symfony\Component\Validator\Constraint;

class Phone extends Constraint
{
    public $message = 'The string "%value%" is not valid phone number.';
}
