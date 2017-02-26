<?php

namespace Core;

/***
* View 
*
* PHP version 5.4
**/
class View
{
	/**
	* Render a view file
	*
	* @param string @view the view file
	*
	* @return void
	*/
	public static function render($view, $args = array())
	{

		extract($args, EXTR_SKIP);

		$file = "../App/Views/$view";  // Relative to core directory

		if(is_readable($file)){
			require $file;
		}	else {
			echo "$file not found";
		}
	}

	/****
	* Render view template using Twig
	*
	* @param string $template the template file
	* @param array $args Associative array of data to display in the view (optional)
	*
	* @return void
	*/

	public static function renderTemplate($template, $args = array())
	{
		static $twig = null;

		if ($twig === null){
			$loader = new \Twig_Loader_Filesystem('../App/Views');
			$twig = new \Twig_Environment($loader);	
		}
		echo $twig->render($template, $args);
	}
}