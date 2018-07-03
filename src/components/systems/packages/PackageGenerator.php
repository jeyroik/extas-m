<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\interfaces\systems\packages\IPackageGenerator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class PackageGenerator
 *
 * @package jeyroik\extas\components\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
class PackageGenerator implements IPackageGenerator
{
    protected $whereToSearch = '';
    protected $whereToPut = '';
    protected $configName = '';

    /**
     * PackageGenerator constructor.
     *
     * @param $whereToSearch
     * @param $whereToPut
     * @param $configName
     */
    public function __construct($whereToSearch, $whereToPut, $configName)
    {
        $this->setPathToSearch($whereToSearch)
            ->setPathToPut($whereToPut)
            ->setConfigName($configName);
    }

    /**
     * @return bool
     */
    public function generate(): bool
    {
        $config = [
            'title' => '',
            'description' => '',
            'schema' => '1.0',
            'plugins' => [],
            'extensions' => []
        ];

        $config = $this->extractPlugins($config);
        $config = $this->extractExtensions($config);

        return file_put_contents($this->configName, json_encode($config));
    }

    /**
     * @param $config
     *
     * @return mixed
     */
    protected function extractExtensions($config)
    {
        $finder = new Finder();
        $finder->name('Extension*.php');

        foreach ($finder->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            preg_match('/namespace\s(.*?);/', $file->getContents(), $match);
            if (isset($match[1])) {
                $namespace = array_pop($match);
                $className = $namespace . '\\' . $file->getBasename('.php');
                $classReflection = new \ReflectionClass($className);
                $methodsProperty = $classReflection->getProperty('methods');
                $methods = ($preDefinedMethods = $methodsProperty->getValue())
                    ? array_keys($preDefinedMethods)
                    : ['Missed, please, define $methods property in an extension class'];

                $subjectProperty = $classReflection->getProperty('subject');
                $subject = ($preDefinedSubject = $subjectProperty->getValue())
                    ? $preDefinedSubject
                    : 'Missed, please, define $subject property in an extension class';

                $interfaces = $classReflection->getInterfaceNames();

                $interface = empty($interfaces)
                    ? 'Missed, please, define interface in an extension class'
                    : array_pop($interfaces);

                $config['extensions'][] = [
                    'class' => $className,
                    'interface' => $interface,
                    'subject' => $subject,
                    'methods' => $methods
                ];
            }
        }

        return $config;
    }

    /**
     * @param $config
     *
     * @return mixed
     */
    protected function extractPlugins($config)
    {
        $finder = new Finder();
        $finder->name('Plugin*.php');

        foreach ($finder->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            preg_match('/namespace\s(.*?);/', $file->getContents(), $match);
            if (isset($match[1])) {
                $namespace = array_pop($match);
                $className = $namespace . '\\' . $file->getBasename('.php');
                $classReflection = new \ReflectionClass($className);
                $stageProperty = $classReflection->getProperty('preDefinedStage');

                $stage = ($preDefinedStage = $stageProperty->getValue())
                    ? $preDefinedStage
                    : 'Missed: please, define $preDefinedStage property in a plugin class';

                $config['plugins'][] = [
                    'class' => $className,
                    'stage' => $stage
                ];
            }
        }

        return $config;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    protected function setPathToSearch($path)
    {
        $this->whereToSearch = $path;

        return $this;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    protected function setPathToPut($path)
    {
        $this->whereToPut = $path;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    protected function setConfigName($name)
    {
        $this->configName = $name;

        return $this;
    }
}
