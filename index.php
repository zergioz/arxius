<?php
/**
 * DEBUG
 */
ini_set('error_reporting',E_ALL^E_NOTICE); 

/**
 * LOAD CLASS, LIBS AND CONFIG
 */
include("includes/config.php");
include("includes/class/dms.php");
include("includes/libs/recaptchalib.php");
/**
 * START SESSION
 */
session_start();

/**
 * START OBJECTS
 */
$DMS = new DMS();

/**
 * REQ AS NEEDED
 */
switch ($_REQUEST['screen']){
			
	/*MAIN SCREEN*/	
	case 'main':
		/*HEADER*/
		include_once('includes/tpl/header.tpl');
						
		/*SORT*/
		switch ($_REQUEST['task']){	
				
			
			/*HANDLE CASES*/
			
			case 'LOGIN':
				include_once('includes/tpl/login.tpl');
			break;
						
			case 'LOGOUT':
				include_once('includes/tpl/logout.tpl');
			break;	
			
			case 'CHANGELOG':
				include_once('includes/tpl/main/changelog.tpl');
			break;
				
			case 'CONTACT':
				include_once('includes/tpl/main/contact.tpl');
			break;
			
			case 'ADMIN' :
				include_once('includes/tpl/main/admin.tpl');
			break;		
				
			/*HANDLE CASES*/
			case 'WATER' || 'ENGERGY' || 'CLIMATE' || 'FOOD' || 'SEARCH':
				
				/*BODY*/
				include_once('includes/tpl/body.tpl');
				
				/*TYPES*/
				include_once('includes/tpl/main/sort.tpl');
			break;

										
			/*DEFAULT*/
			default:
				/*BODY*/
				include_once('includes/tpl/body.tpl');
				
				/*FILE LIST*/
				include_once('includes/tpl/main/allfileslist.tpl');
			break;
		}
		
		/*FOOTER*/
		include_once('includes/tpl/footer.tpl');
	break;		
			
	/*DEFAULT - LOGIN*/	
	default:
		include_once('includes/tpl/login.tpl');
	break;
}

?>