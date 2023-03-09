<?php
namespace Prepad\PyroTestTask\Class;

use Illuminate\Support\Facades\Validator;
use Prepad\PyroTestTask\Exceptions\DirectoryCreateException;
use Prepad\PyroTestTask\Exceptions\EmptySavePathException;
use Prepad\PyroTestTask\Interface\SiteMapGeneratorInterface;

class SiteMapGenerator implements SiteMapGeneratorInterface
{
    public function __construct(
        array $sitemap,
        string $filetype,
        string $savePath
    )
    {
        $this->validateSavePath($savePath);
        $this->generateMap($sitemap, $filetype, $savePath);
    }

    public function generateMap(
        array $sitemap,
        string $filetype,
        string $savePath
    ): void
    {
        // TODO: Implement generateMap() method.
    }

    public function validatePage(array $pageData): void
    {
        // TODO: Implement validatePage() method.
    }

    public function validateSavePath(string $savePath): void
    {
        if (empty($savePath)) {
            throw new EmptySavePathException('Не задан путь для сохранения файла');
        }
        if(!is_dir($savePath)) {
            if (!mkdir($savePath, 0777, true)) {
                throw new DirectoryCreateException('Ошибка создания директории для файла');
            };
        }
    }
}
