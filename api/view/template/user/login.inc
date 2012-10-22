<div id="featured" class="grid col-940">
	<div class="grid col-460">
		<form action="<?php core::constructURL("user", "login", array(), "html"); ?>" method="post" style="width:26em; padding-left: 4em;">
			<h2>Log in to MathsMix</h2>
			<?php if(isset($data['message'])) {
				echo "<div style=\"color: #f00\">".core::escapeHTML($data['message']).".</div>";
			}?>
			<table>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="user_email" value=""></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="user_password" value=""></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right">
						<a style="float:left" href="<?php echo core::constructURL("user", "google", array(''), "html"); ?>"><img src="<?php echo $config['webroot']; ?>img/google-account.jpg" /></a>
						<input type="submit" value="Log in">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>