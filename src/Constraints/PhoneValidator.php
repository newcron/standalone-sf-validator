<?php

namespace Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/^[0-9]{9}$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%value%', $value)
                ->addViolation();
        }
    }
}