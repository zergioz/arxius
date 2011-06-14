<div class="post">
	<!--SUBMIT FORM FOR FILE-->
	<form name='myFile' method='POST'>
	<h2 class="title"><a href="#">Enviromental Security Uploaded Files</a></h2>
		<table id="myFilesTable" class="tablesorter">
			<thead> 
				<tr>     
					<th>NAME</th>     
					<th>MIME</th>     
					<th>CATEGORY</th>     
					<th>TYPE</th>   
					<th>SIZE</th>
					<th>ACTION</th>   
				</tr> 
			</thead> 
			<tbody> 
				<?=$DMS->TableSortUploadedFiles();?>
			</tbody> 
		</table>
	<input type="hidden" name="fileid" value="" />
	<input type="hidden" name="action" value="" />		
	</form> 
	<div id="myFilesTableOps" class="pager">
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
<?$DMS->FileActionACL($_POST);?>
