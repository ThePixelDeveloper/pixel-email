<h1>Inbox for <a href="<?php print Route::url('email-inbox', array('email' => $email)); ?>"><?php print $email; ?></a></h1>
<h2><?php print $result->subject; ?></h2>
<table lass="zebra-striped">
	<thead>
	<tr>
		<th>Address (To)</th>
		<th>Result</th>
		<th>Content-Type</th>
		<th>Date</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php print $result->address; ?></td>
			<td><?php print $result->result; ?></td>
			<td><?php print $result->type; ?></td>
			<td><?php print date(DATE_RFC3339, $result->date); ?></td>
		</tr>
	</tbody>
</table>

<h2><a href="<?php print Route::url('email-read', array('email' => $email, 'id' => $result->id, 'part' => 'body'), $request); ?>">Body</a></h2>
<p><em>In iframe</em></p>

<iframe src="<?php print Route::url('email-read', array('email' => $email, 'id' => $result->id, 'part' => 'body'), $request); ?>" 
				width="940px" 
				height="400px"
				style="border:1px solid #ddd">
<?php print $result->body; ?>
</iframe>
