<?php

namespace File\Analyzer\sources;

/**
 * Интерфейс источника файлов
 * @package File\Analyzer\sources
 */
interface IFileSource
{
    /**
     * @return string Путь к файлу
     */
    public function getFilePath(): string;

    /**
     * @return int Размер файла в байтах
     */
    public function getFileSize(): int;

    /**
     * @return string Mime тип файла
     */
    public function getFileMimeType(): string;

    /**
     * @return array Массив ошибок
     */
    public function getErrors(): array;
}