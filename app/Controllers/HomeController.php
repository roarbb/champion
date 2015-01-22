<?php namespace Monoblock\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        echo "Hellou, I'm " . __CLASS__ . ".<br />Why not visit me at " . __DIR__ . "?<br /><br />See you in your IDE mate.";
    }
}
