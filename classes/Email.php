<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Email module
 *
 * Ported from Kohana 2.2.3 Core to Kohana 3.0 module
 * 
 * Updated to use Swiftmailer 4.0.4
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Email
{
	/**
	 * Creates a SwiftMailer instance.
	 *
	 * @param   string  DSN connection string
	 * @return  object  Swift object
	 */
	public static function get_transport($config = NULL)
	{
		if ( ! class_exists('Swift_Mailer', FALSE))
		{
			require Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');
		}

		// Load default configuration
		($config === NULL) and $config = Kohana::$config->load('email');
		
		if ('smtp' === $config['driver'])
		{
			/**
			 * SMTP transport
			 */
			$port = empty($config['options']['port']) ? 25 : (int) $config['options']['port'];
			
			$transport = Swift_SmtpTransport::newInstance($config['options']['hostname'], $port);

			if ( ! empty($config['options']['encryption']))
			{
				$transport->setEncryption($config['options']['encryption']);
			}
			
			empty($config['options']['username']) or $transport->setUsername($config['options']['username']);
			empty($config['options']['password']) or $transport->setPassword($config['options']['password']);
			
			$transport->setTimeout(empty($config['options']['timeout']) ? 5 : (int) $config['options']['timeout']);
		}
		elseif ('sendmail' === $config['driver'])
		{
			/**
			 * Sendmail transport
			 */
			$transport = Swift_SendmailTransport::newInstance(empty($config['options']) ? "/usr/sbin/sendmail -bs" : $config['options']);
		}
		elseif('null' === $config['driver'])
		{
			/**
			 * Null transport
			 */
			$transport = Swift_NullTransport::newInstance();
		}
		else
		{
			/**
			 * Native transport (mail).
			 */
			$transport = Swift_MailTransport::newInstance($config['options']);
		}

		return Swift_Mailer::newInstance($transport);
	}
} // End email