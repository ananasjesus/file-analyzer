<?php

namespace File\Analyzer\sources;

use File\Analyzer\exceptions\InvalidConfigException;

class LocalFileSource implements IFileSource
{
    /**
     * @var integer Количество байт в мегабайте
     */
    const BYTES_IN_MEGABYTE = 1048576;

    /**
     * @var array Конфигурация источника файлов
     */
    protected array $config = [];

    /**
     * @var array Ошибки
     */
    protected array $errors = [];

    /**
     * LocalFileSource constructor.
     * @param array $config
     * @throws InvalidConfigException Если некорректная конфигурация источника файлов
     */
    public function __construct(array $config)
    {
        if (!array_key_exists('filePath', $config) || !is_string($config['filePath'])) {
            throw new InvalidConfigException('Не корректная конфигурация "filePath" в источнике файлов');
        }

        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function getFilePath(): string
    {
        return $this->validate() ? $this->config['filePath'] : false;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function validate(): bool
    {
        //Максимальный размер файла
        if (array_key_exists('maxFileSize', $this->config) && $this->config['maxFileSize'] > 0) {
            $fileSize = $this->getFileSize();
            if ($fileSize > $this->config['maxFileSize'] * self::BYTES_IN_MEGABYTE) {
                $this->errors['maxFileSize'] = "Размер исследуемого файла: $fileSize байт, максимальный размер "
                    . $this->config['maxFileSize'] * self::BYTES_IN_MEGABYTE . ' байт';
            }
        }

        //Разрешенный тип файла
        if (
            array_key_exists('allowedMimeTypes', $this->config)
            && is_array($this->config['allowedMimeTypes'])
            && !empty($this->config['allowedMimeTypes'])
        ) {
            $fileMimeType = $this->getFileMimeType();
            if (!in_array($fileMimeType, $this->config['allowedMimeTypes'])) {
                $this->errors['allowedMimeTypes'] = "Тип файла $fileMimeType отсутствует в списке разрешенных";
            }
        }

        return $this->errors ? false : true;
    }

    public function getFileSize(): int
    {
        return filesize($this->config['filePath']);
    }

    public function getFileMimeType(): string
    {
        return mime_content_type($this->config['filePath']);
    }
}