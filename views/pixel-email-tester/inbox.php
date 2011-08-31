<h1><a href="<?php print Route::url('email'); ?>">Inbox</a> for <?php print $email; ?></h1>

<table class="zebra-striped">
	<thead>
	<tr>
		<th>ID</th>
		<th>Subject</th>
		<th>Address</th>
		<th>Result</th>
		<th>Type</th>
		<th>Date</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($results as $row): ?>
		<tr>
			<td><?php print $row->id; ?></td>
			<td><a href="<?php print Route::url('email-read', array('email' => $row->address, 'id' => $row->id)); ?>"><?php print $row->subject; ?></a></td>
			<td><?php print $row->address; ?></td>
			<td><?php print $row->result; ?></td>
			<td><?php print $row->type; ?></td>
			<td><?php print date(DATE_RFC3339, $row->date); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
