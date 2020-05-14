<?php
return [
    'researcher' => [
        'class' => \File\Analyzer\researchers\StrposFileResearcher::class,
        'config' => [
            'searchString' => 'test',
        ],
    ],
    'source' => [
        'class' => \File\Analyzer\sources\LocalFileSource::class,
        'config' => [
            'filePath' => __DIR__ . '/../test.txt',
            'maxFileSize' => 5,
            'allowedMimeTypes' => [],
        ],
    ],
];