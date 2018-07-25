<?php

use jeyroik\extas\interfaces\systems as S;
use jeyroik\extas\interfaces\systems\states as IStates;
use jeyroik\extas\components\systems\states as CStates;
use jeyroik\extas\interfaces\systems\plugins as ISystemPlugins;

return [
    IStates\IStateFactory::class => CStates\StateFactory::class,
    IStates\dispatchers\IDispatchersFactory::class => CStates\dispatchers\DispatcherFactory::class,
    ISystemPlugins\IPluginRepository::class => \jeyroik\extas\components\systems\plugins\PluginRepository::class,
    S\extensions\IExtensionRepository::class => \jeyroik\extas\components\systems\extensions\ExtensionRepository::class,
    S\packages\IPackageRepository::class => \jeyroik\extas\components\systems\packages\PackageRepository::class,
    S\plugins\stages\IStageRepository::class => \jeyroik\extas\components\systems\plugins\stages\StageRepository::class,
];
