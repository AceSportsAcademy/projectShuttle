<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Items extends Authenticated
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        View::renderTemplate('Items/index.html');
    }

    public function newAction()
    {

        View::renderTemplate('Items/index.html');
    }


    public function showAction()
    {

        View::renderTemplate('Items/index.html');
    }
}
