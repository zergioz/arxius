<div class="post">
	<h2 class="title"><a href="#">Login</a></h2>
	<table align="center">
		<tr>
			<td>
				<form method="POST">
					<input type="hidden" name="login" value="1">
					<label>User:</label>
					<input type="text" name="user">
					<label>Password:</label>
					<input type="password" name="password">
					<input type="submit">
				</form>
			</td>
		</tr>
	</table>
	<?=$DMS->UserCheck($_POST['login'],$_POST['user'],$_POST['password']);?>
</div>

