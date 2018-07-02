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
     * PackageRootComposer constructor.
     *
     * @param $packageContent
     */
    public function __construct($packageContent)
    {
        $this->setPackageContent($packageContent);
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
