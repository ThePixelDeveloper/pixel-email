<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This plugin automatically logs all emails to a database.
 * 
 * @author Mathew Davies <thepixeldeveloper@googlemail.com>
 * @package Swift
 * @subpackage Plugins
 */
interface Model_Email_Interface
{
	/**
	 * Insert the email from swiftmailer into the database.
	 * 
	 * @param Swift_Mime_Message $message
	 * @param string             $address
	 * @param boolean            $result
	 */
	public function insert_email(Swift_Mime_Message $message, $address, $result);
}