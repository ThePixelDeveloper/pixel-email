<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pixel_Email_Bcc extends ORM
{
	protected $_belongs_to = array('message' => array('model' => 'email', 'foreign_key' => 'email_id'));
}