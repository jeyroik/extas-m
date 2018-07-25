<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\extensions\ExtensionRepository;
use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\plugins\PluginCrawler;
use jeyroik\extas\components\systems\plugins\PluginRepository;
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

        return file_put_contents($this->configName, json_encode($config, JSON_PRETTY_PRINT));
    }

    /**
     * @param $config
     *
     * @return mixed
     */
    protected function extractExtensions($config)
    {
        $finder = new Finder();
        $finder->name('*xtension*.php');

        foreach ($finder->in($this->whereToSearch)->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            preg_match('/namespace\s(.*?);/', $file->getContents(), $match);
            if (isset($match[1])) {
                $namespace = array_pop($match);
                $className = $namespace . '\\' . $file->getBasename('.php');

                if (!$this->isValidPath($className) || !$this->isValidPath($file->getRealPath())) {
                    continue;
                }

                require_once $file->getRealPath();
                $classReflection = new \ReflectionClass($className);

                $config['extensions'][] = [
                    'class' => $className,
                    'interface' => $this->extractExtensionInterface($classReflection),
                    'subject' => $this->extractExtensionSubject($classReflection),
                    'methods' => $this->extractExtensionMethods($classReflection)
                ];
            }
        }

        return $config;
    }

    /**
     * @param \ReflectionClass $classReflection
     *
     * @return array
     */
    protected function extractExtensionMethods($classReflection)
    {
        $interface = $this->extractExtensionInterface($classReflection);
        $methods = ['Missed, please, define methods in the extension interface'];

        try {
            $interfaceReflection = new \ReflectionClass($interface);
            $interfaceMethods = $interfaceReflection->getMethods();

            if (!empty($interfaceMethods)) {
                $methods = [];
                foreach ($interfaceMethods as $interfaceMethod) {
                    $methods[] = $interfaceMethod->getName();
                }
            }
        } catch (\Exception $e) {
            // nothing to do, just skip this case
        }

        return $methods;
    }

    /**
     * @param \ReflectionClass $classReflection
     *
     * @return string
     */
    protected function extractExtensionSubject($classReflection)
    {
        $subject = 'Missed, please, define $subject property in an extension class';
        $properties = $classReflection->getDefaultProperties();

        if (isset($properties['subject'])) {
            $subject = ($preDefinedSubject = $properties['subject'])
                ? $preDefinedSubject
                : $subject;
        }

        return $subject;
    }

    /**
     * @param \ReflectionClass $classReflection
     *
     * @return string
     */
    protected function extractExtensionInterface($classReflection)
    {
        $interfaces = $classReflection->getInterfaceNames();

        $interface = empty($interfaces)
            ? 'Missed, please, define interface in an extension class'
            : array_pop($interfaces);

        return $interface;
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

        foreach ($finder->in($this->whereToSearch)->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            preg_match('/namespace\s(.*?);/', $file->getContents(), $match);
            if (isset($match[1])) {
                $namespace = array_pop($match);
                $className = $namespace . '\\' . $file->getBasename('.php');

                if (!$this->isValidPath($className) || !$this->isValidPath($file->getRealPath())) {
                    continue;
                }

                require_once $file->getRealPath();

                $classReflection = new \ReflectionClass($className);

                $config['plugins'][] = [
                    'class' => $className,
                    'stage' => $this->extractPluginStage($classReflection)
                ];
            }
        }

        return $config;
    }

    /**
     * @param $path
     *
     * @return bool
     */
    protected function isValidPath($path)
    {
        $skip = [
            Plugin::class => true,
            PluginRepository::class => true,
            PluginCrawler::class => true,
            Extension::class => true,
            ExtensionRepository::class => true
        ];

        $restrictedArea = [
            'vendor/'
        ];

        if (isset($skip[$path])) {
            return false;
        }

        foreach ($restrictedArea as $area) {
            if (strpos($path, $area) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \ReflectionClass $classReflection
     *
     * @return string
     */
    protected function extractPluginStage($classReflection)
    {
        $properties = $classReflection->getDefaultProperties();

        if (isset($properties['preDefinedStage'])) {
            $stage = ($preDefinedStage = $properties['preDefinedStage'])
                ? $preDefinedStage
                : 'Missed: please, define $preDefinedStage property in a plugin class';
        } else {
            $stage = 'Missed: please, define $preDefinedStage property in a plugin class';
        }

        return $stage;
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
