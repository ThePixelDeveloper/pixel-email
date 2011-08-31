<h1>Email Inboxes</h1>

<table class="zebra-striped">
	<thead>
	<tr>
		<th>Address</th>
		<th>Emails</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($results as $row): ?>
		<tr>
			<td><a href="<?php print Route::url('email-inbox', array('email' => $row->address)); ?>"><?php print $row->address; ?></a></td>
			<td><?php print $row->email_count; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
