<?php
namespace tratabor\interfaces\systems;

/**
 * Interface IPluginsAcceptable
 *
 * @package tratabor\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginsAcceptable
{
    const FIELD__PLUGINS = 'plugins';
    const FIELD__PLUGINS_SUBJECT_ID = 'plugins_subject_id';

    /**
     * @param mixed $subject
     * @param string $stage
     * @param IPlugin $plugin
     *
     * @return bool
     */
    public function registerPlugin($subject, $stage, IPlugin $plugin);

    /**
     * @param string $stage
     *
     * @return IPlugin[]
     */
    public function getPluginsByStage($stage);
}
