<?php

namespace File\Analyzer\researchers;

interface IFileResearcher
{
    /**
     * @return array Массив с результатами исследования
     */
    public function research(): array;

    /**
     * @param string $filePath Путь к файлу
     */
    public function setFilePath(string $filePath): void;
}