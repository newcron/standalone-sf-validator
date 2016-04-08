<?php

namespace Constraints\Ad;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

class ParametersValidator extends ConstraintValidator
{
    /**
     * @var mixed some entity manager
     */
    private $entityManger;

    /**
     * @var ParameterConstraintsBuilder
     */
    private $builder;

    /**
     * ParametersValidator constructor.
     * @param $entityManger
     * @param ParametersConstraintsBuilder $builder
     */
    public function __construct($entityManger, ParametersConstraintsBuilder $builder)
    {
        $this->entityManger = $entityManger;
        $this->builder = $builder;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value) && !($value instanceof \Traversable && $value instanceof \ArrayAccess)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }

        //$availableParameters = $this->entityManger->getRepository(AdParameters::class)->findAvailableParameters();
        $availableParameters = [
            'param_price' => [
                'type' => 'price',
                'from' => 0,
                'to' => 10000,
                'currency' => ['UZS', 'USD']
            ]
        ];

        $constraints = [];

        foreach ($availableParameters as $key => $parameter) {
            if ($constraint = $this->builder->build($parameter)) {
                $constraints[$key] = $constraint;
            }
        }

        $validator = $this->context->getValidator()->inContext($this->context);

        foreach ($value as $parameterName => $parameterValue) {
            if (isset($constraints[$parameterName])) {
                $validator
                    ->atPath('['.$parameterName.']')
                    ->validate($parameterValue, $constraints[$parameterName]);
            } else {
                $this->context
                    ->buildViolation('This parameter was not expected.')
                    ->atPath('['.$parameterName.']')
                    ->setParameter('{{ field }}', $this->formatValue($parameterName))
                    ->setInvalidValue($parameterValue)
                    ->setCode(Collection::NO_SUCH_FIELD_ERROR)
                    ->addViolation();
            }
        }
    }
}