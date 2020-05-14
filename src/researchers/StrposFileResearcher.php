<?php

namespace File\Analyzer\researchers;

use File\Analyzer\exceptions\FileNotFoundException;
use File\Analyzer\exceptions\InvalidConfigException;

/**
 * Подключаемый модуль для поиска в файле номера строки и позиции первого вхождения заданного набора символов
 */
class StrposFileResearcher implements IFileResearcher
{
    /**
     * @var string Путь к файлу
     */
    protected string $filePath = '';

    /**
     * @var array Конфиг [
     * 'searchString' => 'строка для поиска'
     * ]
     */
    protected array $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Поиск строки
     *
     * @return array Массив [
     * 'line' => номер строки,
     * 'position' => номер позиции в строке
     * ] или пустой массив в случае если строка не найдена
     * @throws FileNotFoundException Если файл не найден или его не возможно открыть
     * @throws InvalidConfigException Если некорректная конфигурация поиска
     */
    public function research(): array
    {
        if (!key_exists('searchString', $this->config)) {
            throw new InvalidConfigException('В кофигурации поиска отсутствует элемент "searchString"');
        }

        if (!$file = fopen($this->filePath, 'r')) {
            throw new FileNotFoundException('Не возможно открыть файл ' . $this->filePath);
        }

        $line = 1;
        while (!feof($file)) {
            $string = fgets($file);
            $position = strpos($string, $this->config['searchString']);
            if ($position !== false) {
                fclose($file);
                return [
                    'line' => $line,
                    'position' => $position + 1
                ];
            }
            $line++;
        }

        fclose($file);
        return [];
    }

    /**
     * @param string $filePath Путь к файлу
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }
}