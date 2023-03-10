<?php
namespace Prepad\PyroTestTask\Class;

use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Prepad\PyroTestTask\Enums\ValidFileTypeEnum;
use Prepad\PyroTestTask\Enums\ValidSiteMapChangeFreqEnum;
use Prepad\PyroTestTask\Exceptions\DirectoryCreateException;
use Prepad\PyroTestTask\Exceptions\EmptySavePathException;
use Prepad\PyroTestTask\Exceptions\FileTypeMismatchException;
use Prepad\PyroTestTask\Exceptions\InvalidFileTypeException;

class SiteMapGenerator
{
    public function __construct(
        array $sitemap,
        string $filetype,
        string $savePath
    )
    {
        $fileInfo = pathinfo($savePath);
        $this->validateSavePath($fileInfo['dirname']);
        $this->validateFileType($filetype, $fileInfo['extension']);
        $this->generateMap($sitemap, $filetype, $savePath);
    }

    private function generateMap(
        array $sitemap,
        string $filetype,
        string $savePath
    ): void
    {
        foreach ($sitemap as $page) {
            $this->validatePage($page);
        }
        $file = fopen($savePath, 'w');
        switch ($filetype) {
            case ValidFileTypeEnum::JSON->value:
                fwrite($file, json_encode($sitemap));
                break;
            case ValidFileTypeEnum::CSV->value:
                fwrite($file, 'loc;lastmod;priority;changefreq' . "\n");
                foreach ($sitemap as $page) {
                    fputcsv($file, $page, ';');
                }
                break;
            case ValidFileTypeEnum::XML->value:
                fwrite($file, '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n");
                foreach ($sitemap as $page) {
                    fwrite($file, '<url>' . "\n");
                    fwrite($file, '<loc>' . $page['loc'] . "</loc>\n");
                    fwrite($file, '<lastmod>' . $page['lastmod'] . "</lastmod>\n");
                    fwrite($file, '<priority>' . $page['priority'] . "</priority>\n");
                    fwrite($file, '<changefreq>' . $page['changefreq'] . "</changefreq>\n");
                    fwrite($file, '</url>' . "\n");
                }
                fwrite($file, '</urlset>');
                break;
        }
        fclose($file);
    }

    private function validatePage(array $pageData): void
    {
        $validator = Validator::make(
            $pageData,
            [
                'loc' => 'required|URL',
                'lastmod' => 'required|date',
                'priority' => 'required|numeric|between:0.1,1',
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

    private function validateSavePath(string $savePath): void
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

    private function validateFileType(string $funcFileType, string $fileType):void
    {
        $acceptedFileType = array_column(ValidFileTypeEnum::cases(), 'value');
        if (!in_array($funcFileType, $acceptedFileType)) {
            throw new InvalidFileTypeException('Передан неверный тип файла');
        }
        if ($fileType != $funcFileType) {
            throw new FileTypeMismatchException('Переданный тип файла и указанный тип файла в пути сохранения не совпадают');
        }
    }
}
