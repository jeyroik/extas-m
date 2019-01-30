<?php
namespace jeyroik\extas\components\systems\plugins;

/**
 * Class PluginLog
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginLog
{
    /**
     * bc - stage count
     * bct - stage count total
     * pc - plugin count
     * pct - plugin count total
     * rc - riser count
     * rct - riser count total
     *
     * @var array
     */
    protected static $pluginLog = [
        'count' => [
            'bs' => [],
            'bst' => 0,
            'pc' => [],
            'pct' => 0,
            'rc' => [],
            'rct' => 0
        ],
        'log' => []
    ];

    /**
     * @return int
     */
    public static function getLogIndex()
    {
        return count(self::$pluginLog['log']);
    }

    /**
     * @param $riser
     * @param $stage
     * @param $pluginsCount
     *
     * @return int
     */
    public static function log($riser, $stage, $pluginsCount)
    {
        $logIndex = static::getLogIndex();
        self::$pluginLog['log'][$logIndex] = [
            'stage' => $stage,
            'riser' => $riser,
            'plugins_count' => $pluginsCount,
            'plugins' => []
        ];
        static::logPluginRiser($riser);
        static::logPluginStage($stage);

        return $logIndex;
    }

    /**
     * @param $stage
     */
    public static function logPluginStage($stage)
    {
        self::$pluginLog['count']['bs'][$stage] = self::$pluginLog['count']['by_stage'][$stage] ?? 0;
        self::$pluginLog['count']['bs'][$stage] ++;
        self::$pluginLog['count']['bst'] ++;
    }

    /**
     * @param $riserClass
     */
    public static function logPluginRiser($riserClass)
    {
        self::$pluginLog['count']['rc'][$riserClass] = self::$pluginLog['count']['rct'][$riserClass] ?? 0;
        self::$pluginLog['count']['rc'][$riserClass] ++;
        self::$pluginLog['count']['rct'] ++;
    }

    /**
     * @param $class
     * @param $logIndex
     */
    public static function logPluginClass($class, $logIndex)
    {
        self::$pluginLog['log'][$logIndex]['plugins'][] = $class;
        self::$pluginLog['count']['pct'] ++;
        self::$pluginLog['count']['pc'][$class] = self::$pluginLog['count']['pc'][$class] ?? 0;
        self::$pluginLog['count']['pc'][$class] ++;
    }
}
