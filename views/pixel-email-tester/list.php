<h1>Inboxes</h1>

<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>Address</th>
		<th>Name</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($results as $row): ?>
		<tr>
			<td><a href="<?php print Route::url('email-inbox', array('email' => $row->email)); ?>"><?php print $row->email; ?></a></td>
			<td><?php print $row->name; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
