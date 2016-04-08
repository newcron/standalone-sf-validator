<?php

namespace Constraints\Ad;

use Symfony\Component\Validator\Constraint;

class Parameters extends Constraint
{
    public $message = 'Invalid category parameters provided.';

    public function validatedBy()
    {
        return 'app.validator.ad.parameters';
    }
}
