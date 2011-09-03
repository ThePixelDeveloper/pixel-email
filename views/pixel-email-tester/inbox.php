<h1><a href="<?php print Route::url('email'); ?>">Inbox</a> for <?php print $email; ?></h1>

<table class="zebra-striped">
	<thead>
	<tr>
		<th>Subject</th>
		<th>Type</th>
		<th>Date</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($results as $row): ?>
		<tr>
			<td><a href="<?php print Route::url('email-read', array('email' => $row->email, 'id' => $row->message->id), $request); ?>"><?php print $row->message->subject; ?></a></td>
			<td><?php print $row->message->type; ?></td>
			<td><?php print date(DATE_RSS, $row->message->date); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
