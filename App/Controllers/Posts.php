<?php

/**
**
* Namespace
**/

namespace App\Controllers;
/**
 * Posts controller
 *
 * PHP version 5.4
 */
class Posts extends \Core\Controller
{

    /***
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
        echo 'Hello from the index action in the Posts controller!';
        echo '<p>Query string parameters: <pre>' .
            htmlspecialchars(print_r($_GET, true)). '</pre></p>';
    }

    /***
     * Show the add new page
     *
     * @return void
     */
    public function addNew()
    {
        echo 'Hello from the addNew action in the Posts controller!';
    }


    /***
    * Show the edit page
    *
    * @return void
    **/
    public function edit()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
              htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}