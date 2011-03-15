<div class="post">
	<!--SUBMIT FORM FOR  MESSAGES-->
	<form name='myMessage' method='POST'>
	<h2 class="title"><a href="#">Messages</a></h2>
		<table id="myMesg" class="tablesorter">
			<thead> 
				<tr>     
					<th>ID</th>     
					<th>NAME</th>     
					<th>EMAIL</th>     
					<th>SUBJECT</th>   
					<th>MESSAGE</th>
					<th>ACTION</th>   
				</tr> 
			</thead> 
			<tbody> 
				<?=$DMS->Messages();?>
			</tbody> 
		</table>
	<input type="hidden" name="mesgid" value="" />
	<input type="hidden" name="action" value="" />	 
	</form>
	<div id="myMesgOps" class="pager" style="display:none">
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
<?$DMS->MessagesDelete($_POST);?>