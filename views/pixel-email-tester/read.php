<h1>Inbox for <a href="<?php print Route::url('email-inbox', array('email' => $email)); ?>"><?php print $email; ?></a></h1>

<table>
	<tr>
		<th>Subject</th>
		<td><?php print $result->subject; ?></td>
	</tr>
	<tr>
		<th>Date received</th>
		<td><?php print date(DATE_RSS, $result->date); ?></td>
	</tr>
	<tr>
		<th>Content Type</th>
		<td><?php print $result->type; ?></td>
	</tr>
	<tr>
		<th>Sender</th>
		<td><?php print $result->sender; ?></td>
	</tr>
	<tr>
		<th>Return Path</th>
		<td><?php print $result->return_path; ?></td>
	</tr>
	<tr>
		<th>To</th>
		<td>
			<ul style="margin-bottom:0;">
				<?php foreach($result->tos->find_all() as $to): ?>
				<li><?php print $to->name; ?> &lt;<?php print $to->email; ?>&gt;</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>From</th>
		<td>
			<ul style="margin-bottom:0;">
				<?php foreach($result->froms->find_all() as $to): ?>
				<li><?php print $to->name; ?> &lt;<?php print $to->email; ?>&gt;</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>Cc</th>
		<td>
			<ul style="margin-bottom:0;">
				<?php foreach($result->ccs->find_all() as $to): ?>
				<li><?php print $to->name; ?> &lt;<?php print $to->email; ?>&gt;</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>Bcc</th>
		<td>
			<ul style="margin-bottom:0;">
				<?php foreach($result->bccs->find_all() as $to): ?>
				<li><?php print $to->name; ?> &lt;<?php print $to->email; ?>&gt;</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>Reply To</th>
		<td>
			<ul style="margin-bottom:0;">
				<?php foreach($result->reply_tos->find_all() as $to): ?>
				<li><?php print $to->name; ?> &lt;<?php print $to->email; ?>&gt;</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
</table>

<h2><a href="<?php print Route::url('email-read', array('email' => $email, 'id' => $result->id, 'part' => 'body'), $request); ?>">Body</a></h2>
<p><em>In iframe</em></p>

<iframe src="<?php print Route::url('email-read', array('email' => $email, 'id' => $result->id, 'part' => 'body'), $request); ?>" 
				width="940px" 
				height="400px"
				style="border:1px solid #ddd">
<?php print $result->body; ?>
</iframe>
