<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>BOK</title>
<link href="includes/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="includes/js/jquery/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="includes/js/jquery/jquery-latest.js"></script> 
<script type="text/javascript" src="includes/js/jquery/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="includes/js/jquery/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="includes/js/jquery/tooltip/jquery.tooltip.js"></script>

<link type="text/css" href="includes/js/jquery/base/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="includes/js/jquery/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="includes/js/jquery/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="includes/js/jquery/ui/jquery.ui.tabs.js"></script>

<script type="text/javascript">
		/*TABLE SORTER*/	
		$(function() {
			/*TABS*/
			$("#tabs").tabs();

			/*GENERIC TABLES*/
			$("#myTable")
				.tablesorter({sortList:[[0,0],[0,0]], widgets: ['zebra']})
				.tablesorterPager({container: $("#pager")});
			$("#options")
				.tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
				
			
			/*FILE TABLES*/		
			$("#myFilesTable")
				.tablesorter({sortList:[[0,0],[0,0]], widgets: ['zebra']})
				.tablesorterPager({container: $("#myFilesTableOps")});
			$("#myFilesTableOps")
				.tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
			
				
			/*MESG TABLES*/	
			$("#myMesg")
				.tablesorter({sortList:[[0,0],[0,0]], widgets: ['zebra']})
				.tablesorterPager({container: $("#myMesgOps")});	
			$("#myMesgOps")
				.tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});	
			
					
			/*MESG TABLES*/	
			$("#myUsers")
				.tablesorter({sortList:[[0,0],[0,0]], widgets: ['zebra']})
				.tablesorterPager({container: $("#myUsersOps")});
			$("#myUsersOps")
				.tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});		
						
		});	
		
		/*UPLOAD FORM*/		
		function submitForm(){
	    	if(document.myUpload.file.value == ""){
	        	alert("No file selected");
	      	}else if(document.myUpload.tags.value == "Tags"){
	      		alert("Plase Insert Tags");
	      	}else{
	        	document.myUpload.submit();
	      }
	    }

		/*SEARCH FORM*/
	    function searchForm(){
	    	if(document.mySearch.search.value == ""){
	        	alert("Input a search criteria");
	        }else if(document.mySearch.search.value == "Search!"){
	      		alert("Input a search criteria");
	      	}else{
	        	document.mySearch.submit();
	      }
	    }
	    /*CLOUD TAG SEARCH*/
	    function searchTag(selectedtype){
	    	/*TAG CLOUD POST*/
	    	if(selectedtype  != ''){
	    		document.mySearch.search.value = selectedtype
	    		document.mySearch.submit() ;
	    	}
	    }
	    /*MENU EXPAND*/  
		function expand(div){ 
			
			var element = document.getElementById(div).style; 
  			if(element.display == "none"){ 
    			element.display = "block"; 
  			} else { 
    			element.display = "none"; 
  			}
		}
		
		/*FILEACL FORM*/		
		function myFileForm(id,action){
			if(id  != ''){
				document.myFile.action.value = action;
				document.myFile.fileid.value = id;		
	        	document.myFile.submit();
			}
	    }
	    
	    /*MESG FORM*/
	    function myMessageForm(mesgid,action){
			if(mesgid  != ''){
				document.myMessage.action.value	= action;
				document.myMessage.mesgid.value	= mesgid;		
	        	document.myMessage.submit();
			}
	    }
	    
	    /*USERS ACL FORM*/
	    function myUsersForm(userid,url,action){
			if(userid  != ''){
				document.myUsers.action.value	= action;
				document.myUsers.userid.value	= userid;	
				document.myUsers.url.value		= url;	
	        	document.myUsers.submit();
			}
	    }
	    
	    /*CONTACT FORM*/		
		function contactForm(){
	    	if(document.myContact.name.value == ""){
	        	alert("Name is required");
	      	}else if(document.myContact.email.value == ""){
	      		alert("E-mail is required");
	      	}else if(document.myContact.subject.value == ""){
	      		alert("Subject is required");
	      	}else if(document.myContact.message.value == ""){
	      		alert("Message is required");
	      	}else if(document.myContact.recaptcha_response_field.value == ""){
	      		alert("CAPTCHA is required");	
	      	}else{
	        	document.myContact.submit();
	      	}
	    }
		
	    /*CREATE ACCOUNT FORM*/		
		function CreateAccount(){
	    	if(document.CreateAccountForm.user.value == ""){
	        	alert("User Name is required");
	        }else if(document.CreateAccountForm.email.value == ""){
	      		alert("Email is required");
	      	}else if(document.CreateAccountForm.password.value == ""){
	      		alert("Password is required");			
	      	}else{
	        	document.CreateAccountForm.submit();
	      	}
	    }
	    
</script>
<script type="text/javascript">
/* AJAX 
function urlload(str){
		if (str.length==0){ 
			document.getElementById("txtHint").innerHTML="";
			return;
	  	}
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	xmlhttp.onreadystatechange=function()  {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    	document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","index.php?screen=main&task="+str,true);
	xmlhttp.send();
}
*/
</script>

</head>
<body onload="expand('<?=$_REQUEST['task'];?>')">
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<img src="includes/css/images/logo.png">
		</div>
		<div id="search">
			<form name="mySearch" method="POST" enctype="multipart/form-data">
				<fieldset>
					<input type="hidden" name="screen" value="main" />
					<input type="hidden" name="task" value="SEARCH" />
					<input type="text" name="search" id="search-text" size="15" value="Search!" />
					<input type="hidden" name="lookup" value="lookup" />
					<input type="button" onclick="javascript:searchForm();" value="Go!"/>
				</fieldset>
			</form>
		</div>
	</div>
	<!-- end #header -->
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="index.php?screen=main">Home</a></li>
			<li><a href="index.php?screen=main&task=CONTACT">Contact</a></li>
			<li><a href="index.php?screen=main&task=ADMIN">Admin</a></li>
			<li><a href="index.php?screen=main&task=CHANGELOG">Change Log</a></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">