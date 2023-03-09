<?php
namespace Prepad\PyroTestTask\Class;

use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Prepad\PyroTestTask\Enums\ValidFileTypeEnum;
use Prepad\PyroTestTask\Enums\ValidSiteMapChangeFreqEnum;
use Prepad\PyroTestTask\Exceptions\DirectoryCreateException;
use Prepad\PyroTestTask\Exceptions\EmptySavePathException;
use Prepad\PyroTestTask\Exceptions\InvalidFileTypeException;
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
        $this->validateFileType($filetype);
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
        $validator = Validator::make(
            $pageData,
            [
                'loc' => 'required|URL',
                'lastmod' => 'required|date',
                'priority' => 'required|max:1.0|min:0.1',
                'changefreq' => [
                    'required',
                    Rule::in(array_column(ValidSiteMapChangeFreqEnum::cases(), 'value')),
                ],
            ]
        );
        if ($validator->fails()) {
            throw new InvalidArgumentException('Переданы неверные данные');
        }
    }

    public function validateSavePath(string $savePath): void
    {
        if (empty($savePath)) {
            throw new EmptySavePathException('Не задан путь для сохранения файла');
        }
        if(!is_dir($savePath)) {
            try {
                mkdir($savePath, 0777, true);
            } catch (\Exception $exception) {
                throw new DirectoryCreateException('Ошибка создания директории для файла');
            };
        }
    }

    public function validateFileType(string $fileType):void
    {
        $acceptedFileType = array_column(ValidFileTypeEnum::cases(), 'value');
        if (!in_array($fileType, $acceptedFileType)) {
            throw new InvalidFileTypeException('Передан неверный тип файла');
        }
    }
}
