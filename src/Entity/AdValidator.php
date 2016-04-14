<?php


namespace Entity;


use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Validator as v;

class AdValidator
{
    public function validate(Ad $ad)
    {
        v::with("Entity\\");

        return v::attribute("title", v::stringType()->notBlank()->length(5, 255))
            ->attribute("categoryId", v::intType()->notEmpty()->in([1, 2, 3]))
            ->attribute("privateBusiness", v::stringType()->in(["private", "business"]))
            ->attribute("person", v::stringType()->notBlank()->length(5, 100))
            ->attribute("email", v::email())#I didn't understand the group thing :(
            ->attribute("phone", v::phone())
            ->attribute("images", v::arrayVal()->each(v::key("href", v::notBlank())))
            ->attribute("params", v::attributeRule())
            #->attribute("params")
            ->assert($ad);
    }
}

class AttributeRule extends AbstractRule
{
    public function validate($input)
    {
        foreach ($input as $key => $value) {
            switch ($value["type"]) {
                case "price":
                    v::key("from", v::intType()->min(0))
                        ->key("to", v::intType()->min($value["from"]))
                        ->key("currency", v::stringType()->in(["EUR", "USD"]))
                        ->assert($value);
                    break;
                default:
                    throw new AttributeRuleException("Unsupported Attribute Type");
            }
        }

        return true;
    }
}

class AttributeRuleException extends NestedValidationException
{

}