<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\interfaces\systems\IRepository;
use jeyroik\extas\interfaces\systems\plugins\IPluginStage;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class PluginStageProducer
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStageProducer
{
    protected $rootPath = '';
    protected $stages = [];
    protected $masks = [];
    protected $alreadySavedStagesCount = 0;

    /**
     * PluginStageProducer constructor.
     *
     * @param $rootPath
     */
    public function __construct($rootPath)
    {
        $this->setRootPath($rootPath);
    }

    /**
     * @param $masks
     *
     * @return $this
     */
    public function setMasks($masks)
    {
        $this->masks = $masks;

        return $this;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function findStages(): int
    {
        if (empty($this->rootPath)) {
            throw new \Exception('Missed root path for Extas stages crawling.');
        }

        $this->loadStages();

        return count($this->stages);
    }

    /**
     * @return array
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @return int
     */
    public function getAlreadySavedStages()
    {
        return $this->alreadySavedStagesCount;
    }

    /**
     * @param IRepository $repository
     * @param array $stages
     *
     * @return int
     */
    public function saveStages(IRepository $repository, $stages): int
    {
        $saved = 0;

        foreach ($stages as $stage) {
            /**
             * @var $stage IPluginStage
             */
            $stageDb = $repository->find([IPluginStage::FIELD__NAME => $stage[IPluginStage::FIELD__NAME]])->one();
            if ($stageDb->getName() == $stage[IPluginStage::FIELD__NAME]) {
                $this->alreadySavedStagesCount++;
                continue;
            }
            $repository->create($stage);
            $saved++;
        }

        return $saved;
    }

    /**
     * @return $this
     */
    protected function loadStages()
    {
        $finder = new Finder();
        $finder->name('*.php');
        $this->stages = [];

        foreach ($finder->files()->in($this->rootPath) as $file) {
            /**
             * @var $file SplFileInfo
             */
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

                $docBlock = $classReflection->getDocComment();

                $stages = $this->grabStages($className, $docBlock);

                if (count($stages)) {
                    $this->stages = array_merge($this->stages, $stages);
                }
            }
        }

        return $this;
    }

    /**
     * @param $className
     * @param $content
     *
     * @return array|null
     * @throws \Exception
     */
    protected function grabStages($className, $content)
    {
        preg_match_all("/\@stage.name\s+(.*?)$/m", $content, $names);
        preg_match_all("/\@stage.description\s+(.*?)$/m", $content, $descriptions);
        preg_match_all("/\@stage.input\s+(.*?)$/m", $content, $inputs);
        preg_match_all("/\@stage.output\s+(.*?)$/m", $content, $outputs);

        if (!isset($names[1]) || !isset($descriptions[1]) || !isset($inputs[1]) || !isset($outputs[1])) {
            return null;
        }

        $foundCount = count($names[1]);
        if ($foundCount != ((count($names[1]) + count($descriptions[1]) + count($inputs[1]) + count($outputs[1]))/4)) {
            throw new \Exception('Missed some stage tags in "' . $className . '".');
        }

        $stages = [];

        foreach ($names[1] as $index => $name) {
            $stages[] = [
                'name' => $name,
                'description' => $descriptions[1][$index],
                'input' => $inputs[1][$index],
                'output' => $outputs[1][$index]
            ];
        }

        return $stages;
    }

    /**
     * For future needs
     *
     * @param $path
     *
     * @return bool
     */
    protected function isValidPath($path)
    {
        $skip = [];

        $restrictedArea = [];

        if (isset($skip[$path])) {
            return false;
        }

        foreach ($restrictedArea as $area) {
            if (strpos($path, $area) !== false) {
                return false;
            }
        }

        if (!empty($this->masks)) {
            foreach ($this->masks as $mask) {
                if (strpos($path, $mask) !== false) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }

    /**
     * @param $rootPath
     *
     * @return $this
     */
    protected function setRootPath($rootPath)
    {
        $this->rootPath = $rootPath;

        return $this;
    }
}
