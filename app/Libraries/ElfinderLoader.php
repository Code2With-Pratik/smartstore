<?php
namespace App\Libraries;

class ElfinderLoader
{
    public function load($options = [])
    {
        require_once(APPPATH . '/Libraries/elFinder/php/autoload.php');
        $defaultOptions = [
            'roots' => [
                [
                    'driver'        => 'LocalFileSystem',
                    'path'          => WRITEPATH . 'uploads/',
                    'URL'           => base_url('writable/uploads/'),
                    'uploadDeny'    => ['all'],
                    'uploadAllow'   => ['image', 'text/plain', 'application/pdf'],
                    'uploadOrder'   => ['deny', 'allow'],
                    'accessControl' => [$this, 'access'],
                ],
            ],
        ];

        $opts = array_merge($defaultOptions, $options);
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }

    public function access($attr, $path, $data, $volume, $isDir, $relpath)
    {
        $basename = basename($path);
        return $basename[0] === '.'
            && strlen($relpath) !== 1
            ? !($attr == 'read' || 'write')
            : null;
    }
}
