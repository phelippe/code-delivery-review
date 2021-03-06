<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    #'allowedMethods' => ['GET','POST','PATCH','DELETE', 'PUT'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => ['*'],
];

