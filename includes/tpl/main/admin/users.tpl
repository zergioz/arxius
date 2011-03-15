<div class="post">
	<!--SUBMIT FORM FOR  USERS-->
	<form method='POST' name='myUsers'>
	<h2 class="title"><a href="#">User List</a></h2>
		<table id="myUsers" class="tablesorter">
			<thead> 
				<tr>     
					<th>USERNAME</th>     
					<th>EMAIL</th>     
					<th>ROLL</th>   
					<th>ONLINE</th>
					<th>ACTION</th>
				</tr> 
			</thead> 
			<tbody> 
				<?=$DMS->ShowUsers();?>
			</tbody> 
		</table>
	<input type="hidden" name="userid" value="" />
	<input type="hidden" name="action" value="" />
	<input type="hidden" name="url"    value="" />	 
	</form>
	<div id="myUsersOps" class="pager" style="display:none">
		<form>
			<img src="includes/js/jquery/tablesorter/addons/pager/icons/first.png" class="first"/>
			<img src="includes/js/jquery/tablesorter/addons/pager/icons/prev.png" class="prev"/>
			<input type="text" class="pagedisplay"  id="search-text" />
			<img src="includes/js/jquery/tablesorter/addons/pager/icons/next.png" class="next"/>
			<img src="includes/js/jquery/tablesorter/addons/pager/icons/last.png" class="last"/>
			<select class="pagesize" id="option-text">
				<option selected="selected"   value="20">20</option>
				<option value="30">30</option>
				<option  value="40">40</option>
			</select>
		</form>
	</div>		
</div>	
<div class="post">
	<h2 class="title"><a href="#">Create New Account</a></h2>
	<table align="center">
		<tr>
			<td>
				<form method="POST" name="CreateAccountForm">
					<input type="hidden" name="action" value="CREATEACCOUNT">
					<label>Roll:</label>
					<select name="roll"><?=$DMS->UserRollList();?></select>
					<label>User Name:</label>
					<input type="text" size="10" name="user">
					<label>Email:</label>
					<input type="text" size="10" name="email">
					<label>Password:</label>
					<input type="password" size="10" name="password">
					<input type="button" onclick="javascript:CreateAccount();" value="Go!"/>
				</form>
			</td>
		</tr>
	</table>
</div>
<?=$DMS->UserAccounts($_POST,$_POST['action']);?>