<?php
// File: app/Controllers/Test.php
namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        return 'Hello! CodeIgniter 4 is working!';
    }

    public function info()
    {
        return phpinfo();
    }
}
