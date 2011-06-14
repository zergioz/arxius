<html>
	<head>
		<!--CSS-->
		<link href="includes/js/jquery/css/hot/jquery-ui-1.8.6.custom.css" rel="stylesheet"/>
		<link rel="stylesheet" href="includes/js/jquery/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
		<!--JS-->
		<script type="text/javascript" src="includes/js/jquery/jquery-latest.js"></script> 
		<script type="text/javascript" src="includes/js/jquery/jquery-ui-1.8.6.custom.min.js"></script>
		<script type="text/javascript" src="includes/js/jquery/tablesorter/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			$(function() {		
				$("#myTable").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
				$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
			});	
		</script>
		<script type="text/javascript">
			$(function(){
 
				// Accordion
				$("#accordion").accordion({ header: "h5" });
	
				// Tabs
				$('#tabs').tabs();
	
 
				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});
 
				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
	</head>
<body>	
	<div class=" ui-widget ui-widget-overlay ui-corner-all">
		<!-- Accordion -->
		<div id="accordion" style="width:15%;float:left;">
		<div class="ui-widget ui-widget-header ui-corner-all">MENU</div>
			<div>
				<h5><a href="#">LATEST</a></h5>
				<ul>
					<li>one</li>
					<li>two</li>
					<li>three</li>
					<li>four</li>
				</ul>
			</div>
			<div>
				<h5><a href="#">WATER</a></h5>
				<ul>
					<li>one</li>
					<li>two</li>
					<li>three</li>
					<li>four</li>
				</ul>
			</div>
			<div>
				<h5><a href="#">ENERGY</a></h5>
				<ul>
					<li>one</li>
					<li>two</li>
					<li>three</li>
					<li>four</li>
				</ul>
			</div>
			<div>
				<h5><a href="#">FOOD</a></h5>
				<ul>
					<li>one</li>
					<li>two</li>
					<li>three</li>
					<li>four</li>
				</ul>
			</div>
			<div>
				<h5><a href="#">CLIMATE</a></h5>
				<ul>
					<li>one</li>
					<li>two</li>
					<li>three</li>
					<li>four</li>
				</ul>
			</div>
		</div>
		<div class="ui-widget ui-widget-content ui-corner-all" style="width:84%;float:right;">
			<div class="ui-widget ui-widget-header ui-corner-all" style="float:right">
				<form>
					<input class="input" type="text" class="ui-widget input ui-corner-all">
					<input class="ui-button" type="submit" value="search">
				</form>
			</div>
			<div class="ui-widget ui-widget-header ui-corner-all" style="float:left;">
				TOP
			</div>
		<!--TABLE-->
			<table id="myTable" class="tablesorter">
				<thead> 
					<tr>     
						<th>NAME</th>     
						<th>TYPE</th>     
						<th>SIZE</th>     
						<th>SUBJECT</th>     
						<th>AUTHOR</th>
						<th>ACTION</th>  
					</tr> 
				</thead> 
				<tbody> 
					<tr>     
						<td>Smith</td>     
						<td>John</td>     
						<td>jsmith@gmail.com</td>     
						<td>$50.00</td> 
						<td>ME</td>    
						<td><a href="#" class="ui-widget-content a">DOWNLOAD</a></td>  
					</tr> 
					<tr>     
						<td>Bach</td>     
						<td>Frank</td>     
						<td>fbach@yahoo.com</td>     
						<td>$50.00</td>    
						<td>ME</td>  
						<td><a href="#" class="ui-widget-content a">DOWNLOAD</a></td> 
					</tr> <tr>     
						<td>Doe</td>     
						<td>Jason</td>     
						<td>jdoe@hotmail.com</td>     
						<td>$100.00</td>
						<td>ME</td>      
						<td><a href="#" class="ui-widget-content a">DOWNLOAD</a></td> 
					</tr> 
					<tr>     
						<td>Conway</td>     
						<td>Tim</td>     
						<td>tconway@earthlink.net</td>     
						<td>$50.00</td> 
						<td>ME</td>     
						<td><a href="#" class="ui-widget-content a">DOWNLOAD</a></td> 
					</tr> 
				</tbody>
				</ul> 
			</table> 
			
		</div>
	</div>
</div>
</body>	
</html>

