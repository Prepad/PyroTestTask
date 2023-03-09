<?php
namespace Prepad\PyroTestTask\Interface;

interface SiteMapGeneratorInterface
{
    /**
     * @param array $sitemap
     * @param string $filetype
     * @param string $savePath
     */
    public function __construct(
        array $sitemap,
        string $filetype,
        string $savePath
    );

    /**
     * @param array $sitemap
     * @param string $filetype
     * @param string $savePath
     */
    public function generateMap(
        array $sitemap,
        string $filetype,
        string $savePath
    ): void;

    /**
     * @param array $pageData
     */
    public function validatePage(array $pageData): void;

    /**
     * @param string $savePath
     */
    public function validateSavePath(string $savePath): void;
}
