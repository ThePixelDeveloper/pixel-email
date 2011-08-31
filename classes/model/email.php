<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This plugin automatically logs all emails to a database.
 * 
 * @author Mathew Davies <thepixeldeveloper@googlemail.com>
 * @package Swift
 * @subpackage Plugins
 */
class Model_Email extends ORM implements Model_Email_Interface
{
	/**
	 * Insert the email from swiftmailer into the database.
	 * 
	 * @param  Swift_Mime_Message $message
	 * @param  string             $address
	 * @param  boolean            $result
	 * @return Model_Email
	 */
	public function insert_email(Swift_Mime_Message $message, $address, $result)
	{
		$this->values(array
		(
			'raw'     => $message,
			'body'    => $message->getBody(),
			'subject' => $message->getSubject(),
			'type'    => $message->getContentType(),
			'date'    => $message->getDate(),
			'address' => $address,
			'result'  => $result ? 'PASS' : 'FAIL',
		));
		
		return $this->save();
	}
}