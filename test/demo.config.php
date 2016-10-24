<?php
$config = [
    'validic' => [
        'client' => [
            \Validic\ClientOptions::ORGANIZATION_ID => '',
            \Validic\ClientOptions::ACCESS_TOKEN => '',
            \Validic\ClientOptions::ERROR_LOGGER => new \Validic\Error\ErrorLogOutputter()
        ]
    ]
];