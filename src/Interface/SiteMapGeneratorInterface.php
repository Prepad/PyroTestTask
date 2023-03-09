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
     * @return void
     */
    public function generateMap(
        array $sitemap,
        string $filetype,
        string $savePath
    ): void;

    /**
     * @param array $pageData
     * @return void
     */
    public function validatePage(array $pageData): void;

    /**
     * @param string $savePath
     * @return void
     */
    public function validateSavePath(string $savePath): void;

    /**
     * @param string $funcFileType
     * @param string $fileType
     * @return void
     */
    public function validateFileType(string $funcFileType, string $fileType): void;
}
