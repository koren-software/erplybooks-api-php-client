<?php
$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->notPath('vendor')
    ->notPath('docs')
    ->name('*.php');

return (new PhpCsFixer\Config)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
