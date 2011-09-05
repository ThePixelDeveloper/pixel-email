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
	protected $_has_many = array
	(
		'tos'       => array('model' => 'pixel_email_to'),
		'froms'     => array('model' => 'pixel_email_from'),
		'ccs'       => array('model' => 'pixel_email_cc'),
		'bccs'      => array('model' => 'pixel_email_bcc'),
		'reply_tos' => array('model' => 'pixel_email_reply_to'),
	);
	
	/**
	 * Insert the email from swiftmailer into the database.
	 * 
	 * @param  Swift_Mime_Message $message
	 * @return Model_Email
	 */
	public function insert_email(Swift_Mime_Message $message)
	{
		/**
		 * Only run this method once. The Swiftmailer plugin sends an event for each
		 * email in the to, cc and bcc headers. This would make sense if we actually
		 * sent the email and wanted to know the status of each. Because we're using the
		 * null transport we don't care.
		 */
		static $count = 0;
		
		if ($count > 0)
		{
			return FALSE;
		}
		
		$count++;
		
		$this->values(array
		(
			'raw'         => $message,
			'headers'     => serialize($message->getHeaders()),
			'body'        => $message->getBody(),
			'subject'     => $message->getSubject(),
			'type'        => $message->getContentType(),
			'date'        => $message->getDate(),
			'sender'      => key($message->getSender()),
			'return_path' => $message->getReturnPath(),
		));

		$this->save();
		
		$this->addTo($this,      $message->getTo());
		$this->addFrom($this,    $message->getFrom());
		$this->addCc($this,      $message->getCc());
		$this->addBcc($this,     $message->getBcc());
		$this->addReplyTo($this, $message->getReplyTo());

		return $this;
	}
	
	/**
	 *
	 * @param Model_Email $model
	 * @param type $values
	 * @return Model_Email 
	 */
	protected function addTo(Model_Email $model, $values)
	{
		return $this->addHeader($this, 'to', $values);
	}
	
	/**
	 *
	 * @param Model_Email $model
	 * @param type $values
	 * @return Model_Email 
	 */
	protected function addFrom(Model_Email $model, $values)
	{
		return $this->addHeader($this, 'from', $values);
	}
	
	/**
	 *
	 * @param Model_Email $model
	 * @param type $values
	 * @return Model_Email 
	 */
	protected function addCc(Model_Email $model, $values)
	{
		return $this->addHeader($this, 'cc', $values);
	}
	
	/**
	 *
	 * @param Model_Email $model
	 * @param type $values
	 * @return Model_Email 
	 */
	protected function addBcc(Model_Email $model, $values)
	{
		return $this->addHeader($this, 'bcc', $values);
	}
	
	/**
	 *
	 * @param Model_Email $model
	 * @param type $values
	 * @return Model_Email 
	 */
	protected function addReplyTo(Model_Email $model, $values)
	{
		return $this->addHeader($this, 'reply_to', $values);
	}
	
	/**
	 * Generic function for adding headers to the email message.
	 * 
	 * @param Model_Email $model
	 * @param string $header
	 * @param array $values
	 * @return Model_Email 
	 */
	protected function addHeader(Model_Email $model, $header, $values)
	{
		if ( ! is_array($values) OR ! $model->loaded())
		{
			return FALSE;
		}
		
		foreach($values as $email => $name)
		{
			$header_model = ORM::factory('pixel_email_'.$header);
			$header_model->email    = $email;
			$header_model->name     = $name;
			$header_model->email_id = $model->pk();
			$header_model->save();
		}
		
		return $this;
	}
}