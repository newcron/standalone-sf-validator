<?php

namespace Constraints\Ad;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CategoryValidator extends ConstraintValidator
{
    /**
     * @var mixed some entity manager
     */
    private $entityManger;

    public function __construct($entityManger)
    {
        $this->entityManger = $entityManger;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        //$availableCategories = $this->entityManger->getRepository(Category::class)->findAvailableCategoriesIds();
        $availableCategories = [1, 2, 3, 4, 5];

        if (!in_array($value, $availableCategories)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%category_id%', $value)
                ->addViolation();
        }
    }
}