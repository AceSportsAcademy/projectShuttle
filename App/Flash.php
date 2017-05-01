<?php

namespace App;

/**
 * Flash notification messsages: messages for one time display using session
 * for storage between requests
 *
 * PHP version 7.0
 */
class Flash
{

	/***
   * Success message type 
   * @var string 
   */

	const SUCCESS = 'success';

	/***
   * Information message type 
   * @var string 
   */

	const INFO = 'info';

	/***
   * Warning message type 
   * @var string 
   */

	const WARNING = 'warning';

	/***
   * Add a message 
   * @param string $message The message content 
   * @return void
   */

	public static function addMessage($message, $type = 'success')
	{
		if(! isset($_SESSION['flash_notifications'])) {
			$_SESSION['flash_notifications'] = [];
		}

		//Append messages to the array
		$_SESSION['flash_notifications'][] = [
		         'body'  => $message,
		         'type'  => $type
		         ];
	}

	/***
   * Get flash messages 
   * 
   * @return mixed An array with all the messages or null if Session var is empty
   */

	public static function getMessages()
	{
		if(isset($_SESSION['flash_notifications'])) {
			$messages = $_SESSION['flash_notifications'];
			unset($_SESSION['flash_notifications']);
			return $messages;	
		}
	}
}