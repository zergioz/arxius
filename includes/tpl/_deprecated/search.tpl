			<div class="post">
				<h2 class="title"><a href="#">Search Results</a></h2>
					<table id="myTable" class="tablesorter">
						<thead> 
							<tr>     
								<th>FILE NAME</th>     
								<th>MIME</th>     
								<th>CATEGORY</th>     
								<th>TYPE</th>
								<th>SIZE</th>     
								<th>ACTION</th>  
							</tr> 
						</thead> 
						<tbody> 
							<?=$DMS->SearchPost($_POST);?>
						</tbody> 
					</table> 
				</div>