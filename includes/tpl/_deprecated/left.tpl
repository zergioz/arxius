<div id="sidebar">
			<ul>
				<li>
					<h2>Categories</h2>
					<ul>
						<li><a href='?screen=main'>All</a></li>
						<?=$DMS->ListCat('menu');?>
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