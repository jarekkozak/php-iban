<?php
/**
 * Application configuration shared by all applications functional tests
 */
return [
    'id' => 'app-console',
    'basePath'=>__DIR__,
    'components' => [
        'session' => [
            'class' => 'yii\web\Session',
        ],
        'request' => [
            // it's not recommended to run functional tests with CSRF validation enabled
            'enableCsrfValidation' => false,
        // but if you absolutely need it set cookie domain to localhost
        /*
          'csrfCookie' => [
          'domain' => 'localhost',
          ],
         */
        ],
    ],
];
