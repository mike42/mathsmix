<div id="featured" class="grid col-940">
	<div id="content">
		<h1>Create new class</h1>
		<form action="<? core::constructURL('classes', 'create', array(), 'html') ?>" method="post">
			<input type="hidden" name="yl_id" value="<?php echo core::escapeHTML($data['year_level'] -> yl_id); ?>" />
			<table style="width: 35em; margin-left: 2em;">
				<tr>
					<td>Class name:</td>
					<td><input type="text" name="class_name" /></td>
				</tr>	
				<tr>
					<td>Year:</td>
					<td><input type="text" name="class_year" value="<?php echo date('Y'); ?>"/></td>
				</tr>	
				<tr>
					<td>Year level:</td>
					<td><?php echo core::escapeHTML($data['year_level'] -> yl_name); ?></td>
				</tr>
				<tr>
					<td colspan=2 style="text-align: right">
						<input type="submit" name="submit" value="Go" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>