<?php
return [
    'researcher' => [
        'class' => \File\Analyzer\researchers\StrposFileResearcher::class,
        'config' => [
            'searchString' => 'test8',
        ],
    ],
    'source' => [
        'class' => \File\Analyzer\sources\LocalFileSource::class,
        'config' => [
            'filePath' => __DIR__ . '/../test.txt',
            'maxFileSize' => 0,
            'allowedMimeTypes' => [],
        ],
    ],
];