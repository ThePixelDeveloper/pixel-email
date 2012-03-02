<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller for accessing emails stored in a database
 * 
 * @author Mathew Davies <thepixeldeveloper@googlemail.com>
 * @package Swift
 * @subpackage Plugins
 */
class Controller_Email extends Controller_Template
{
	/**
	 * @var string Base template
	 */
	public $template = 'pixel-email-tester';
	
	/**
	 * Make the email and request object available in all templates.
	 * 
	 * @return voic
	 */
	public function before()
	{
		if (Kohana::DEVELOPMENT !== Kohana::$environment AND Kohana::TESTING !== Kohana::$environment)
		{
			throw new HTTP_Exception_404;
		}
		
		parent::before();
		
		$this->template->set_global('email', $this->request->param('email'));
		$this->template->set_global('request', $this->request);
	}
	
	/**
	 * List all the email inboxes found
	 */
	public function action_list()
	{
		$this->template->content = View::factory('pixel-email-tester/list');
		
		$this->template->content->results = ORM::factory('pixel_email_to')
						->group_by('email')
						->find_all();
		
		$this->template->title = __('Email Inboxes');
	}
	
	/**
	 * Access an email inbox.
	 * 
	 * @return void
	 */
	public function action_inbox()
	{
		$this->template->content = View::factory('pixel-email-tester/inbox');
		
		$email = $this->request->param('email');
		
		$this->template->title = __('Inbox').' - '.$email;
		
		$this->template->content->results = DB::query(Database::SELECT, '
			SELECT emails.* 
			FROM pixel_email_tos 
			JOIN emails 
				ON pixel_email_tos.email_id = emails.id 
			WHERE pixel_email_tos.email = :email 
			ORDER BY emails.date DESC
		')
			->param(':email', $email)
			->as_object()
			->execute();
	}
	
	/**
	 * Read a specific email
	 * 
	 * @return void
	 */
	public function action_read()
	{
		$this->template->content = View::factory('pixel-email-tester/read');
		
		$part = $this->request->param('part');
		
		$email = ORM::factory('email', $this->request->param('id'));
		
		if (NULL !== $part)
		{
			$this->auto_render = FALSE;
			$this->response->body($email->$part);
		}
		
		$this->template->content->result = $email;
		
		$this->template->title = __($email->subject).' - '.implode(', ', $email->tos->find_all()->as_array(NULL, 'email'));
	}

	public function action_css()
	{
		$this->auto_render = FALSE;

		$css = Kohana::find_file('css/pixel-email', $this->request->param('file'), 'css');

		$this->response->body(file_get_contents($css));
		$this->response->headers('Content-Type', 'text/css');
	}

}