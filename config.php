<?php

/**
 * Used to store website configuration information.
 *
 * @var string
 */
function config($key = '')
{
    $config = [
        'name' => 'Simple PHP Website',
        'baseurl' => 'http://localhost/app4/',
        'content_path' => 'content',
        'pretty_uri' => true,
        'version' => 'v2.0',
    ];

    return isset($config[$key]) ? $config[$key] : null;
}

function router($key = '')
{
    $path = [
      'login' => 'login',
      'signup' => 'signup',
      'postit' => 'postit',
      'logout' => 'logout',

    ];

    return isset($path[$key]) ? $path[$key] : null;
}
