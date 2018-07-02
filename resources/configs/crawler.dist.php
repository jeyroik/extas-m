<?php

use jeyroik\extas\interfaces\systems\plugins\IPluginCrawler as I;

return [
    I::CONFIG__PACKAGE__ROOT_NAME => 'composer.lock',
    I::CONFIG__PACKAGE__ROOT_EXTRACTOR => \jeyroik\extas\components\systems\packages\PackageRootComposer::class,

    I::CONFIG__PACKAGE__NAME => 'extas.json',
    I::CONFIG__PACKAGE__EXTRACTOR => \jeyroik\extas\components\systems\packages\PackageExtractorJson::class
];
