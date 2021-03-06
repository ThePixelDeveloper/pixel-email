Introduction
------------

This module contains a Swiftmailer plugin that logs all emails to a database and 
a controller to access them.

Usage
-----

Where you connect to your email service you'd have something similar to this:

	if (Kohana::DEVELOPMENT === Kohana::$environment)
	{
		// Don't actually send the email
		$mailer = Swift_NullTransport::newInstance();
		
		// Email model, development only.
		$model = ORM::factory('email');
				
		// Create a new database reporter.
		$database_reporter = new Swift_Plugins_Pixel_Email_Logger_Database($model);
		$reporter          = new Swift_Plugins_ReporterPlugin($database_reporter);
				
		$mailer->registerPlugin($reporter);
	}
	else
	{
		$mailer = Swift_SendmailTransport::newInstance();
	}

The NullTransport is used because we don't want to send the email; We then attach
the database reporter so we can grab the emails out at a later date. All you need
to do to view the emails is browse to <domain.com>/emails. The main page will
show you a list of emails which have appeared in the "To" header. Clicking an email
will show you its inbox and further clicking on the subject will give you all the
details of that message. Details include:

* Subject
* Date Received
* Content-Type
* Sender
* Return-Path
* To
* From
* Cc
* Bcc
* Reply-To
* Message body

The complete raw email can be found by appending /raw when viewing a message. So

`<domain.com>/emails/me@example.com/1` -> `<domain.com>/emails/me@example.com/1/raw`

Schema
------

	CREATE TABLE emails (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		raw mediumtext NOT NULL,
		body mediumtext NOT NULL,
		`subject` mediumtext NOT NULL,
		`type` varchar(10) NOT NULL,
		`date` int(10) unsigned NOT NULL,
		headers longtext NOT NULL,
		sender text,
		return_path text,
		PRIMARY KEY (id),
		KEY `date` (`date`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

	CREATE TABLE pixel_email_bccs (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		email_id mediumint(8) unsigned NOT NULL,
		email varchar(255) NOT NULL,
		`name` varchar(255) DEFAULT NULL,
		PRIMARY KEY (id),
		KEY email (email,`name`),
		KEY email_id (email_id)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	CREATE TABLE pixel_email_ccs (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		email_id mediumint(8) unsigned NOT NULL,
		email varchar(255) NOT NULL,
		`name` varchar(255) DEFAULT NULL,
		PRIMARY KEY (id),
		KEY email (email,`name`),
		KEY email_id (email_id)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	CREATE TABLE pixel_email_froms (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		email_id mediumint(8) unsigned NOT NULL,
		email varchar(255) NOT NULL,
		`name` varchar(255) DEFAULT NULL,
		PRIMARY KEY (id),
		KEY email (email,`name`),
		KEY email_id (email_id)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

	CREATE TABLE pixel_email_reply_tos (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		email_id mediumint(8) unsigned NOT NULL,
		email varchar(255) NOT NULL,
		`name` varchar(255) DEFAULT NULL,
		PRIMARY KEY (id),
		KEY email (email,`name`),
		KEY email_id (email_id)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	CREATE TABLE pixel_email_tos (
		id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
		email_id mediumint(8) unsigned NOT NULL,
		email varchar(255) NOT NULL,
		`name` varchar(255) DEFAULT NULL,
		PRIMARY KEY (id),
		KEY email (email,`name`),
		KEY email_id (email_id)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

License
-------

Copyright (c) 2011, Mathew Davies <thepixeldeveloper@googlemail.com>
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the pixel-email-tester nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL MATHEW DAVIES BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS