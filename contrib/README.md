Behat Integration
=================

One step is added for convenience to access the email and a hook is provided to
empty the database tables after scenarios with the `@emptyinboxes` hook.

	/**
	 * @Given /^I access the inbox for "(?P<email>[^"]*)"$/
	 */
	public function accessInbox($email)
	{
		return array
		(
			new Behat\Behat\Context\Step\Given('I am on "'.Route::url('email').'"'),
			new Behat\Behat\Context\Step\When('I follow "'.$email.'"'),
			new Behat\Behat\Context\Step\Then('I should see "Inbox - '.$email.'" in the "title" element'),
		);
	}
		
	/**
	 * @AfterScenario @emptyinboxes
	 */
	public function cleanEmailInboxes()
	{
		// Tables to truncate
		$tables = array
		(
			'emails', 
			'pixel_email_bccs', 
			'pixel_email_ccs', 
			'pixel_email_froms'.
			'pixel_email_reply_tos', 
			'pixel_email_tos'
		);
		
		foreach($tables as $table)
		{
			DB::query(NULL, 'TRUNCATE '.$table)->execute();
		}
	}

Usage
-----

	Feature: Test email steps

		Scenario: Browse to inbox
			Given I access the inbox for "me@example.com"
			When I follow "Contact Form Submission"
			Then I should see "Mr Cool" in the "#from" element

		Scenario: Following a link in the email body
			Given I access the inbox for "me@example.com"
			When I follow "Contact Form Submission"
				And I follow "Body"
				And I follow "Reset my password"
			Then I should be on "/account/reset-password"