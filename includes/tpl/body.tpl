		<div class="post">
			<h2 class="title"><a href="#">Upload</a></h2>
			<div class="entry">
				<form name="myUpload" method="post" enctype="multipart/form-data">
					<input type="hidden" name="upload" value="true">
					<input type="file" name="file" id="search-text" size="10" />
						<label>Category:</label>
						<select name="category" id="option-text">
							<?=$DMS->ListCat('options');?>
						</select>
					<label>Type:</label>
						<select name="type" id="option-text">
							<?=$DMS->ListType('list');?>
						</select>
					<input type="button" onclick="javascript:submitForm();" value="Go!"/>
					<br	/>
					<input type="text" id="search-text" value="Tags" name="tags"><label></small>*REQUIRED | Separate tags with commas</small>
				</form>
			</div>
		</div>			
		