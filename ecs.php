<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;


return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/application',
        __DIR__ . '/component',
    ]);
    $parameters->set(Option::PARALLEL, true);

    $setList = [
        SetList::ARRAY,
        SetList::STRICT,
        SetList::SYMPLIFY,
        SetList::NAMESPACES,
        SetList::PSR_12,
        SetList::COMMON,
        SetList::PHPUNIT,
        SetList::DOCBLOCK,
        SetList::CONTROL_STRUCTURES,
        SetList::COMMENTS,
        SetList::CLEAN_CODE,
    ];

    foreach ($setList as $list) {
        $containerConfigurator->import($list);
    }

    $services = $containerConfigurator->services();

    $services->set(BlankLineBeforeStatementFixer::class);

    $services->set(ArraySyntaxFixer::class)
             ->call('configure', [['syntax' => 'short']]);

    $services->set(BinaryOperatorSpacesFixer::class)
             ->call('configure', [['default' => 'align']]);

    $services->set(ConcatSpaceFixer::class)
             ->call('configure', [['spacing' => 'one']]);

    $services->set(NoUnusedImportsFixer::class);

    $parameters->set(Option::SKIP, [
        PhpdocToCommentFixer::class => null,
        MultilineWhitespaceBeforeSemicolonsFixer::class => null,
        GeneralPhpdocAnnotationRemoveFixer::class => null,
        MethodChainingIndentationFixer::class => null,
        MethodChainingNewlineFixer::class => null,
        LineLengthFixer::class => null,
        IsNullFixer::class,
    ]);
};
