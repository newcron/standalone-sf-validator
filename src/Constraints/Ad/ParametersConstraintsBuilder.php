<?php

namespace Constraints\Ad;

use Symfony\Component\Validator\Constraints as Assert;

class ParametersConstraintsBuilder
{
    public function build(array $parameter)
    {
        if ($parameter['type'] == 'price') {
            $constraints = [
                'type' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\EqualTo('price'),
                ]),
                'from' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\Type('int'),
                    new Assert\GreaterThanOrEqual($parameter['from']),
                ]),
                'to' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\Type('int'),
                    new Assert\GreaterThanOrEqual($parameter['from']),
                    new Assert\LessThan($parameter['to']),
                ]),
                'currency' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\Choice($parameter['currency'])
                ]),
            ];
        } else {
            return null;
        }

        return new Assert\Collection([
            'fields' => $constraints,
            'allowMissingFields' => false,
            'allowExtraFields' => false
        ]);
    }
}