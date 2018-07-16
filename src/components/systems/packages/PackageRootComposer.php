<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\interfaces\systems\packages\IPackageRoot;

/**
 * Class PackageRootComposer
 *
 * @package jeyroik\extas\components\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
class PackageRootComposer implements IPackageRoot
{
    protected $packageContent = [];

    /**
     * @param $packagePath
     *
     * @return $this
     */
    public function __invoke($packagePath)
    {
        if (is_file($packagePath)) {
            $packageContent = json_decode(file_get_contents($packagePath), true);
            $this->setPackageContent($packageContent);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'composer.lock';
    }

    /**
     * @return array
     */
    public function getPackages(): array
    {
        return array_column($this->packageContent['packages'], null, 'name');
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->packageContent['content-hash'];
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->packageContent);
    }

    /**
     * @param $content
     *
     * @return $this
     */
    protected function setPackageContent($content)
    {
        $this->packageContent = $content;

        return $this;
    }
}
