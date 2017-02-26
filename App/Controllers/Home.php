<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

		/***
        ** Before filter 
        ** @return void
        **/
        protected function before()
        {
        //	echo "(before) ";
        	//return false;
        }

        /***
        ** After filter - called after an action method
        ** @return void
        **/
        protected function after()
        {
        //	echo " (after)";
        }

    /***
     * Show the index page
     *
     *
     * @return void
     */
    /**** public function indexAction()
    {
        //echo 'Hello from the index action in the Home controller!';
        View::render('Home/index.php', array('name'=>'Dave', 'colors'=> array('red', 'green', 'blue')));
    }  ****/

    public function indexAction()
    {
        View::renderTemplate('Home/index.html', array('name'=>'Prashanth', 'colors'=> array('red', 'green', 'blue')));
    }
}
