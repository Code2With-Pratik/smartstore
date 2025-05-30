<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ElfinderLoader;

class FilemanagerController extends MyAdminController
{
    protected $path_upload;
    protected $link;
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/filemanager/';
        $this->controller_name     = 'filemanager';
        $this->path_upload     = APPPATH . '../assets/uploads/';
        $this->url_upload      = rtrim(base_url('assets/uploads/'), '/') . '/';
    }

    public function index()
    {
        redirect(admin_url());
    }

    public function elfinder_init()
    {
        return view($this->path_view_controller . 'elfinder', [
            'urlConnector' => admin_url($this->controller_name . '/elfinder_connector'),
        ]);
    }

    public function elfinder_connector()
    {
        $elfinderLoader = new ElfinderLoader();
        $elfinderLoader->load([
            'roots' => [
                [
                    'driver'        => 'LocalFileSystem',
                    'path'          => $this->path_upload,
                    'URL'           => $this->url_upload ,
                    'uploadDeny'    => ['all'],
                    'uploadAllow'   => ['image', 'text/plain', 'application/pdf'],
                    'uploadOrder'   => ['deny', 'allow'],
                    'accessControl' => [$this, 'elfinderAccess'],
                    'defaults'      => [
                        'read' => true,
                        'write' => true, 
                        'locked' => APP_IS_DEMO ? true : false,
                    ],
                ],
            ],
        ]);
    }

    public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath)
    {
        $basename = basename($path);
        return $basename[0] === '.' // if file/folder begins with '.' (dot)
         && strlen($relpath) !== 1// but with out volume root
         ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
         : null; // else elFinder decide it itself
    }

}
