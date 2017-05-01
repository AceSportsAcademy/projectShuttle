<?php

namespace App;


use Mailgun\Mailgun;
/**
 * Mailer
 *
 * PHP version 7.0
 */
class Mail
{
	/***
   * Send a mail
   * @param string $to Recipient
   * @param string $subject Subject
   * @param string $text Text-only content of the message
   * @param string $html HTML content of the message
   *
   * @return mixed
   */

	public static function send($to, $subject, $text, $html)
	{
		# First, instantiate the SDK with your API credentials
		$mg = Mailgun::create(Config::MAILGUN_API_KEY);
		$domain = Config::MAILGUN_DOMAIN;

		# Now, compose and send your message.
		$mg->messages()->send($domain, [
  			'from'    => 'your-sender@example.com', 
  			'to'      => $to, 
  			'subject' => $subject, 
  			'text'    => $text,
  			'html'    => $html
		]);
	}

}