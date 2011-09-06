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
			<td><a href="<?php print Route::url('email-read', array('email' => $email, 'id' => $row->id), $request); ?>"><?php print $row->subject; ?></a></td>
			<td><?php print $row->type; ?></td>
			<td><?php print date(DATE_RSS, $row->date); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
