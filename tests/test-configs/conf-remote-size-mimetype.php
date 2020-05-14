<?php
return [
    'researcher' => [
        'class' => \File\Analyzer\researchers\StrposFileResearcher::class,
        'config' => [
            'searchString' => 'contain',
        ],
    ],
    'source' => [
        'class' => \File\Analyzer\sources\HttpFileSource::class,
        'config' => [
            'filePath' => 'https://www.kernel.org/doc/Documentation/kselftest.txt',
            'maxFileSize' => 2,
            'allowedMimeTypes' => ['text/plain'],
        ],
    ],
];