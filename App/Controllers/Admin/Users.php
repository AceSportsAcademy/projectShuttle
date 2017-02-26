<?php

namespace App\Controllers\Admin;

/***
* User Admin controller
* 
* PHP version 5.4
*/
class Users extends \Core\Controller
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
     * Show the User index action page
     *
     * @return void
     */
    public function indexAction()
    {
        echo 'User admin Index page';
    }
}