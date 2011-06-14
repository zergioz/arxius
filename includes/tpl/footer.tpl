			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				<li>
					<h2>Categories</h2>
					<ul>
						<?=$DMS->ListCat('menu');?>
					</ul>
				</li>
				<li>
					<h2>Tag Cloud</h2>
					<ul>
						<?=$DMS->Tag();?>
					</ul>
				</li>
				<li>
					<h2>Lastest</h2>
					<ul>
						<?=$DMS->ListLastestFiles();?>
					</ul>
				</li>
			</ul>	
		</div>		
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	</div>
	<!-- end #page -->
</div>
	<div id="footer">
	</div>
	<!-- end #footer -->
</body>
</html>
<?=$DMS->UploadFiles($_POST);?>
