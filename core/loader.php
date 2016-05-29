<?php
$folders = [ /* Load Folders */
    '',
    '/../app/helpers',
    '/../app/models',
    '/../app/controllers/front',
    '/../app/controllers/admin'
];

require_once 'vendor/autoload.php'; /* Load Vendor*/

foreach($folders as $f) /* Load CMS */
{
    foreach (glob(__DIR__ . "$f/*.php") as $filename)
    {
        if($f !== 'core' && $filename !== 'loader.php'){
            require_once $filename;            
        }
    }
}