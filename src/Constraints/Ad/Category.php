<?php

namespace Constraints\Ad;

use Symfony\Component\Validator\Constraint;

class Category extends Constraint
{
    public $message = 'Category id "%category_id%" is invalid.';

    public function validatedBy()
    {
        return 'app.validator.ad.category';
    }
}
