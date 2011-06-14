<?$DMS->ACLcheker();?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Files</a></li>
		<li><a href="#tabs-2">Messages</a></li>
		<li><a href="#tabs-3">Users</a></li>
		<li><a href="#tabs-4" onclick="window.location = '/DMS8/index.php?screen=main&task=LOGOUT';">Logout</a></li>
	</ul>
	<div id="tabs-1"><?include('admin/uploadedfiles.tpl');?></div>
	<div id="tabs-2"><?include('admin/messages.tpl');?></div>
	<div id="tabs-3"><?include('admin/users.tpl');?></div>
	<div id="tabs-4"></div>
	<!--END POST -->
</div>

