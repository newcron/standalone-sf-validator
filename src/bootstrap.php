<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

$container->set('container', $container);

$container
    ->register('entity_manager', \Db\EntityManager::class);

$container
    ->register('validator.ad_category', \Constraints\Ad\CategoryValidator::class)
    ->addArgument(new Reference('entity_manager'))
    ->addTag('validator.constraint_validator', ['alias' => 'app.validator.ad.category']);

$container
    ->register('validator.ad_parameters_constraints_builder', \Constraints\Ad\ParametersConstraintsBuilder::class);

$container
    ->register('validator.ad_parameters', \Constraints\Ad\ParametersValidator::class)
    ->addArgument(new Reference('entity_manager'))
    ->addArgument(new Reference('validator.ad_parameters_constraints_builder'))
    ->addTag('validator.constraint_validator', ['alias' => 'app.validator.ad.parameters']);

$container
    ->register('validator.builder', \Symfony\Component\Validator\ValidatorBuilderInterface::class)
    ->setFactory([\Symfony\Component\Validator\Validation::class, 'createValidatorBuilder'])
    ->setMethodCalls([
        ['setConstraintValidatorFactory', [new Reference('validator.validator_factory')]],
        ['addMethodMapping', ['loadValidatorMetadata']]
    ]);

$container
    ->register('validator.validator_factory', \Validator\ConstraintValidatorFactory::class)
    ->addArgument(new Reference('container'));

$validators = array();
foreach ($container->findTaggedServiceIds('validator.constraint_validator') as $id => $attributes) {
    if (isset($attributes[0]['alias'])) {
        $validators[$attributes[0]['alias']] = $id;
    }
}

$container->getDefinition('validator.validator_factory')->addArgument($validators);

return $container;