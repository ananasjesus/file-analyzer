<?php
//Шаблон конфигурации исследования
return [
    'researcher' => [
        'class' => \File\Analyzer\researchers\StrposFileResearcher::class,
        'config' => [
            'searchString' => '',
        ],
    ],
    'source' => [
        'class' => \File\Analyzer\sources\LocalFileSource::class,
        'config' => [
            'filePath' => '',
            //Размер файла в мегабайтах
            'maxFileSize' => 0,
            //Разрешенные типы файлов
            'allowedMimeTypes' => [],
        ],
    ],
];