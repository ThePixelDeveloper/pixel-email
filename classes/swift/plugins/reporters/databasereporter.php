<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This plugin automatically logs all emails to a database.
 * 
 * @author Mathew Davies <thepixeldeveloper@googlemail.com>
 * @package Swift
 * @subpackage Plugins
 */
class Swift_Plugins_Reporters_DatabaseReporter implements Swift_Plugins_Reporter
{
	/**
	 * Kohana model instance
	 * 
	 * @var Model
	 */
  private $_model = NULL;

	/**
	 * 
	 * @param Model $model 
	 */
	public function __construct(Model $model)
	{
		$this->_model = $model;
	}
	
	/**
	 * Get the kohana model instance.
	 * 
	 * @return Model
	 */
	public function get_model()
	{
		return $this->_model;
	}
	
  /**
   * Notifies this ReportNotifier that $address failed or succeeded.
	 * 
   * @param Swift_Mime_Message $message
   * @param string $address
   * @param int $result from {@link RESULT_PASS, RESULT_FAIL}
   */
  public function notify(Swift_Mime_Message $message, $address, $result)
  {
		// Cast result to bool
		$result = self::RESULT_PASS === $result;
		$this->_model->insert_email($message, $address, $result);
  }
  
}