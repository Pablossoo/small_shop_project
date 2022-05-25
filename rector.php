<?php

declare(strict_types=1);

use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::NAMING);
    $containerConfigurator->import(SetList::PHP_74);
    $containerConfigurator->import(SetList::PHP_80);
    $containerConfigurator->import(SetList::PRIVATIZATION);
    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);

    $parameters->set(
        Option::SKIP,
        [
            ChangeAndIfToEarlyReturnRector::class,
            ChangeOrIfReturnToEarlyReturnRector::class,
            ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class,
            ChangeReadOnlyVariableWithDefaultValueToConstantRector::class,
            RemoveUnusedConstructorParamRector::class,
            RenameParamToMatchTypeRector::class,
            RenamePropertyToMatchTypeRector::class,
            UnSpreadOperatorRector::class,
            VarConstantCommentRector::class,
            AddArrayReturnDocTypeRector::class,
            AddArrayParamDocTypeRector::class,

            ArgumentAdderRector::class,
            RenameVariableToMatchMethodCallReturnTypeRector::class,
            RenameVariableToMatchNewTypeRector::class,
            UnionTypesRector::class,
            CallableThisArrayToAnonymousFunctionRector::class,
        ]
    );

    $services = $containerConfigurator->services();
    $services->set(PreslashSimpleFunctionRector::class);
    $parameters->set(Option::PATHS, [__DIR__ . '/src']);
};
