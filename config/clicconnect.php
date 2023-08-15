<?php

return [
    // Enable Autoload
    // If enabled, will check 'directory' for connectors
    'autoload' => env('CLIC_CONNECTOR_AUTOLOAD', true),

    // The directory where the connectors are located.
    // This will autoload all the connectors in the directory.
    'directory' => env('CLIC_CONNECTOR_DIRECTORY', app_path('Services/Connectors')),

    // Debug Mode
    'debug' => env('CLIC_CONNECTOR_DEBUG', false),

    // Optional: Throw errot if directory not exists or empty
    'throw_error' => env('CLIC_CONNECTOR_THROW_ERROR', false),
];
