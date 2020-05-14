<?php

namespace File\Analyzer;

use File\Analyzer\exceptions\InvalidConfigException;
use File\Analyzer\researchers\IFileResearcher;
use File\Analyzer\sources\IFileSource;

/**
 * Анализотор файлов
 * @package File\Analyzer
 */
class Analyzer
{
    /**
     * @var array Конфигурация анализатора
     */
    protected array $config;

    /**
     * @var IFileSource Источник файлов
     */
    protected IFileSource $source;

    /**
     * @var IFileResearcher Исследователь файлов
     */
    protected IFileResearcher $researcher;

    /**
     * Analyzer constructor.
     * @param array $config Конфигурация исследования
     * @throws InvalidConfigException Выкидывается если не найден класс источника или исследователя
     */
    public function __construct(array $config = [])
    {
        $defaultConfig = require __DIR__ . '/defaults.php';
        $this->config = array_merge($defaultConfig, $config);

        if(
            !array_key_exists('source', $this->config)
            || !array_key_exists('researcher', $this->config)
            || !class_exists($this->config['source']['class'])
            || !class_exists($this->config['researcher']['class'])
        ) {
            throw new InvalidConfigException('Некорректная конфигурация анализатора');
        }

        $this->source = new $this->config['source']['class']($this->config['source']['config']);
        $this->researcher = new $this->config['researcher']['class']($this->config['researcher']['config']);
    }

    public function analyze()
    {
        $filePath = $this->source->getFilePath();
        if ($errors = $this->source->getErrors()) {
            return ['errors' => $errors];
        }

        $this->researcher->setFilePath($filePath);
        return $this->researcher->research();
    }

}
