<?php
class DMS{
	
	
	/*VARS*/
	public $FileList;
	
	/**
	 * CONSTRUCTOR
	 */
	public function __construct(){
				
	}
	
	/*MYSQL CONNECTION STRING*/
	function DMSMySQLConnect(){
		/*CONNECT TO DB*/
		mysql_connect(_MYSQLSERVER,_MYSQLUSER,_MYSQLPASSWORD);
	}
		
	/**
	 * MYSQL QUERY PARSER
	 **/
   	function DMSQuery($qry,$type,$query_name){
   		/*RETURN - RUN QUERY*/
   		$runqry 	= mysql_query($qry) or die("Error On Query $query_name	:".mysql_error());
   		
   		switch ($type){
   			case "_SELECT":
   				/*RUN OBJECT*/
   				while ($objectqry = mysql_fetch_object($runqry)) {
   					$result[] = $objectqry;
   				}
   				/*RETURN SELECT*/
   				return $result;
   			break;
   			case "_INSERT" || "_UPDATE":	
   				return $runqry;
   			break;
   		}
  	}
   	
	/**
	 * List Category 
	 */
	function ListCat($type){
		$this->DMSMySQLConnect();
		/*RUN QUERY*/
		$return = $this->DMSQuery("SELECT `categoryid`,`categoryname` FROM "._DATABASE.".`files_category` ORDER BY `categoryid`",'_SELECT','_ListCat');
		/*RETURN*/
		$this->ListCatHTML($return,$type);
	}
	
	/**
	 * List Category HTML
	 */
	function ListCatHTML($return,$type){
		/*Parse Value*/				
		foreach ($return as $value){
			switch ($type){
				case 'menu':
					echo "<li><a href='?screen=main&task=$value->categoryname'>$value->categoryname</a>";
					echo "<ol id='$value->categoryname' style='display:none'>";
					echo $this->ListType('submenu','?screen=main&task='.$value->categoryname);
					echo "</ol>";
					echo "</li>";
					break;
				case 'options':
					echo "<option value='$value->categoryid'>$value->categoryname</option>";
					break;	
			}
		}
	}
	
	/**
	 * List Type 
	 */
	function ListType($type,$url){
		$this->DMSMySQLConnect();
		/*RUN QUERY*/
		$return = $this->DMSQuery("	SELECT `typeid`,`typename`,`hashed` 
									FROM "._DATABASE.".`files_type` 
									WHERE `online` = 1 
									ORDER BY `typeid`",'_SELECT','_ListType');
		/*RETURN*/
		$this->ListTypeHTML($return,$type,$url);
	}
	
	/**
	 * List Type HTML
	 */
	function ListTypeHTML($return,$type,$url){
		switch ($type){
			case 'list':
				foreach ($return as $value){
					echo "<option value='$value->typeid'>$value->typename</option>";
				}
			case 'submenu':
				foreach ($return as $value){
					echo "<li><a href='$url&type=$value->typename'>$value->typename</a></li>";
				}	
		}
	}
	
	/**
	 * TABLE SORT UPLOADED FILES
	 */
	function TableSortUploadedFiles(){
		/*DB CONNECT*/
		$this->DMSMySQLConnect();
		
		/*RUN QUERY*/
		$return = $this->DMSQuery("	SELECT `fileid`,`cid`,`tid`,`categoryname`,`typename`,`downloads`,`filename`,`displayname`,`path`,`mime`,`size` 
									FROM "._DATABASE.".`files` AS F
									JOIN "._DATABASE.".`files_category` AS C 
									ON `F`.cid = `C`.categoryid
									JOIN "._DATABASE.".`files_type` AS T 
									ON `F`.tid = `T`.typeid
									WHERE `F`.`online` = 0
									ORDER BY `F`.`downloads`",'_SELECT','_TableSortUploadedFiles');
		
		/*RETURN*/
		return  $this->TableSortHTML($return);	
	}
	
	/**
	 * Table Sort TOP 10
	 */
	function TableSortAll(){
		/*DB CONNECT*/
		$this->DMSMySQLConnect();
		
		/*RUN QUERY*/
		$return = $this->DMSQuery("	SELECT `fileid`,`cid`,`tid`,`categoryname`,`typename`,`downloads`,`filename`,`displayname`,`path`,`mime`,`size` 
									FROM "._DATABASE.".`files` AS F
									JOIN "._DATABASE.".`files_category` AS C 
									ON `F`.cid = `C`.categoryid
									JOIN "._DATABASE.".`files_type` AS T 
									ON `F`.tid = `T`.typeid
									WHERE `F`.`online` = 1
									ORDER BY `F`.`downloads`",'_SELECT','_TableSortTop10');
		
		/*RETURN*/
		return  $this->TableSortHTML($return);	
	}
	
	/**
	 * Table Sort HTML TOP10
	 */
	function TableSortHTML($tablereturn){
		switch ($tablereturn) {
			case true:
					foreach ($tablereturn as $value){
						$return .= "<tr>";     
						$return	.= "<td><a class='tooltip' href='{$value->path}{$value->filename}' target='_blank'>".substr($value->displayname,0,30)."
									<span class='help'>
										<em>File Name:</em>$value->displayname
										<em>Tags:</em>{$this->TagList($value->fileid)}
									</span></td>";
						$return	.= "<td><img width=16 height=16 src='{$this->MimeTypesIcons($value->mime)}'></td>";     
						$return	.= "<td><a href='index.php?screen=main&task={$value->categoryname}'>{$value->categoryname}</a></td>"; 
						$return	.= "<td>{$value->typename}</td>";    
						$return	.= "<td>{$value->size}K</td>";     
						$return	.= "<td>".$this->ACLLink($_REQUEST['task'],$value->path.$value->filename,$value->fileid)."</a></td>";  
						$return	.= "</tr>"; 
					}
					break;
		}
		/*RETURN*/
		return $return;
	}
	
	/**
	 * TABLE SORT CATEGORY
	 */
	function TableSortCategory($category,$type){
		
		/*CHANGE CAPS*/
		$category	= strtoupper($category);
		$type		= strtoupper($type);
		
			
		/*FETCH TYPE IF VALID AND SQL INJECTIONS*/
		switch($type){ 
			case !empty($type) OR $type != "'" :
				/*ADD STRINGS*/
				$typeseach = "AND `F`.tid = (SELECT `typeid` FROM "._DATABASE.".`files_type` WHERE `typename` = '".mysql_escape_string($type)."')";
			break;	
			default:
				$typeseach = null;
			break;	
		}
		
		/*FETCH CATEGORY IF VALID AND SQL INJECTIONS*/
		switch ($category){ 
			case !empty($category) AND $category != "'" :
				$this->DMSMySQLConnect();
			
				/*RUN QUERY*/
				$return = $this->DMSQuery("	SELECT `fileid`,`cid`,`tid`,`downloads`,`filename`,`displayname`,`path`,`mime`,`size`,`categoryname`,`typename` 
											FROM "._DATABASE.".`files` AS F
											JOIN "._DATABASE.".`files_category` AS C 
											ON `F`.cid = `C`.`categoryid`
											inner JOIN "._DATABASE.".`files_type` AS T 
											ON `F`.tid = `T`.typeid
											WHERE `F`.`online` = 1
											AND   `F`.`cid`    = (SELECT categoryid FROM "._DATABASE.".`files_category` WHERE `categoryname` = '".mysql_escape_string($category)."') $typeseach",'_SELECT','TableSortCategory');
				
				
				/*RETURN*/
				return  $this->TableSortHTML($return);	
			break;
				
		}
	}
	
	/**
	 * List Lastest Files
	 */
	function ListLastestFiles(){
		/*DB CONNECT*/
		$this->DMSMySQLConnect();
		
		/*RUN QUERY*/
		$return = $this->DMSQuery("	SELECT `fileid`,`cid`,`tid`,`hashed`,`downloads`,`filename`,`displayname`,`path`,`mime`,`size` 
									FROM "._DATABASE.".`files` WHERE `online` = 1 
									ORDER BY `fileid` 
									DESC LIMIT 5 ",'_SELECT','_ListLastestFiles');
		
		/*RETURN*/
		return  $this->ListLastestFileHTML($return);	
		
	}
	
	/**
	 * LIST LASTEST FILE HTML
	 */
	
	function ListLastestFileHTML($tablereturn){
				switch ($tablereturn) {
					case true:
						foreach ($tablereturn as $value){
							$return .="<li><img width=16 height=16 src='{$this->MimeTypesIcons($value->mime)}'><a href='{$value->path}{$value->filename}' target='_blank'>".substr($value->displayname,0,20)."</a></li>";
						}
						break;
					case false:
						$return .= "<li>No Record Found</li>";
						break;	
				}
			/*RETURN HTML*/		
			return $return;
	}
	
	/**
	 * UP LOAD FILE
	 */
	function UploadFiles($upload){
		/*
		echo "<pre>";
		print_r($_FILES);
		print_r($upload);
		echo "</pre>";
		*/
		/*CHECK SWITCH*/		
		switch ($upload['upload']){	
			case 'true':
				/*SIMPLE VARS*/
				$path 			= $this->FilePath();
				$filename		= basename($this->FileNameCleanup($_FILES['file']['name']));
				
				/*DISPLAY NAME SCRUB*/
				$displayname 	= str_replace("\\","",$_FILES['file']['name']); 
				$displayname 	= str_replace("'","",$displayname); 
				
				/*SCRUB DISPLAY NAME TAGS*/
				$display2tag	= ereg_replace("_", " ", $_FILES['file']['name']); 
				$display2tag 	= ereg_replace("-", " ", $display2tag);
				$display2tag 	= ereg_replace("'", "", $display2tag);
				$display2tag 	= ereg_replace(",", "", $display2tag);
				
				
				/*MOVE TMP FILE*/
				switch(move_uploaded_file($_FILES['file']['tmp_name'], $path.$filename)) {
					case true:
						/*ADD RECORD TO DB*/
						$this->File2DB($upload['category'],$upload['type'],$path,$filename,$displayname,$_FILES['file']['type'],$_FILES['file']['size']);
					
						/*GET LAST ID - LAST_INSERT_ID() GIVIN AN  ERROR WITH FK*/
						$this->MysqlLastID = mysql_insert_id();
					
						/*ADD TAG REFFERANCE*/
						$this->TagHandle($upload['tags'],$lastid,1);
						$this->TagHandle($display2tag,$lastid,2);
						
						/*SHOW ALIERT*/									
    					echo "<script>alert('Done! The file has been saved as: $displayname')</script>";
    				
    					/*REDIRECT*/
    					echo "<script type='text/javascript'>window.location = '/"._SYSTEMFOLDER."/index.php?screen=main'</script>";
    					break;
					case false:
    					echo "<script>alert('Error: A problem occurred during file upload!')</script>";
    					break;
			}	
		}
	}
	
	/**
	 *  File2DB DATABASE INSERT
	 */
	function File2DB($cat,$type,$path,$filename,$displayname,$mime,$size){
		
		/*DB CONNECT*/
		$this->DMSMySQLConnect();
		
		/*CRC32*/
		$crcfilename = crc32("$filename");
		
		/*RUN QUERY*/
		$return = $this->DMSQuery("	INSERT INTO "._DATABASE.".`files` (`cid`,`tid`,`hashed`,`filename`,`displayname`,`path`,`mime`,`size`) 
									VALUES ($cat,$type,$crcfilename,'$filename','$displayname','$path','$mime',$size)",'_INSERT','_File2DB');
	}
	
	
	/**
	 * TAG HANDLER 
	 */
	function TagHandle($taglist,$lastid,$type){
		/*CHANGE CAPS*/
		$tags = strtoupper($taglist);
		switch ($type){		
			case 1:
				/*SPLIT INTO STRINGS*/
				$tags = explode(',',$tags);
				break;
			case 2:
				$tags = explode(" ",$tags);
				break;
		}
		/*ERASE DEFAULT VALUE*/
		foreach ($tags as $key=>$value){
			if($value == 'TAGS'){
				/*UNSET VALUES*/
				unset($tags[$key]);
			}else {
				$this->Tag2DB($value);
			}
		}
		return true;
	}
	
	/**
	 * TAG2DB DATABASE INSERT
	 */
	function Tag2DB($tag){
		
		/*DB CONNECT*/
		$this->DMSMySQLConnect();
		
		/*CRC32*/
		$crctag = crc32($tag);
		
		/*RUN QUERY*/
		$return = $this->DMSQuery("INSERT INTO "._DATABASE.".`files_tags` (`tagname`,`taghash`,`fileid`) values ('$tag',$crctag,$this->MysqlLastID)",'_INSERT','_Tag2DB');
	}
	
	
	/**
	 * CHECK FOR FOLDERS AND MKDIR IF NEEDED
	 */
	function FilePath(){
		/*GET DATE STAMPS*/
		$yfolder = date('Y');
		$mfolder = date('m');
		$dfolder = date('d');
		
		/*CHECK FOR FOLDER*/
		if (!is_dir(_UPLOADDIR."/".$yfolder."/")) {
			mkdir(_UPLOADDIR."/".$yfolder) or die('Error Creating: Year Folder, Please Contact Support');
		}
		if (!is_dir(_UPLOADDIR."/".$yfolder."/".$mfolder."/")) {
			mkdir(_UPLOADDIR."/".$yfolder."/".$mfolder."/") or die('Error Creating: Month Folder, Please Contact Support');
		}
		if (!is_dir(_UPLOADDIR."/".$yfolder."/".$mfolder."/".$dfolder."/")) {
			mkdir(_UPLOADDIR."/".$yfolder."/".$mfolder."/".$dfolder."/") or die('Error Creating: Day Folder, Please Contact Support');
		}
		
		/*RETURN*/
		return 	_UPLOADDIR."/".$yfolder."/".$mfolder."/".$dfolder."/";
	}
	
	/**
	 * CLEAN UP FILE NAME 
	 */
	function FileNameCleanup($string){
		$ext = pathinfo($string,PATHINFO_EXTENSION);
		$scrub = ereg_replace("[^A-Za-z0-9]", "", $string); 
		$capstring = strtoupper($scrub);
		
		/*Result*/
		$result = $capstring.".".$ext;
		
		/*RETURN*/
		return $result;
	}
	
	/**
	 * DISPLAY MIME TYPES
	 */
	function MimeTypesIcons($mime){
		switch ($mime) {
			case 'application/pdf':
				$return = 'http://www.stdicon.com/nuvola/application/pdf';
				break;
			case 'application/msword':
				$return = 'http://www.stdicon.com/nuvola/application/msword';
				break;
			case 'image/pjpeg':
				$return = 'http://www.stdicon.com/nuvola/image/x-generic';
				break;	
			case 'image/x-png':
				$return = 'http://www.stdicon.com/nuvola/image/x-generic';
				break;		
			default:
				$return = 'http://www.stdicon.com/nuvola/application/octet-stream';
				break;
			}
		return $return;	
		}
		
    
    /**
     * SEARCH TAGS
     */
    function TagSearch($tag){
    	
    	/*DB CONNECT*/
    	$this->DMSMySQLConnect();
    	
    	/*CHANGE CAPS*/
    	$tag = strtoupper($tag);
    	
    	/*CRC32*/
    	$tag = crc32($tag);
    	
    	/*RUN QUERY*/
    	$return = $this->DMSQuery("	SELECT `fileid` 
    								FROM "._DATABASE.".`files_tags` 
    								WHERE taghash = {$tag}",'_SELECT','_TagSearch');
    	
    	/*STORE IN ARRAY*/
    	switch ($return){
    	case true:
    		foreach ($return as $value) {
    			$files[] = $value;
    		}
    		break;
    	}
    	return $files;
    }
    
    /**
     * SEARCH CATEGORY
     */
    function CategorySearch($cat){
    	/*DB CONNECT*/
    	$this->DMSMySQLConnect();
    	
    	/*CHANGE CAPS*/
    	$cat = strtoupper($cat);
    	
    	/*CRC32*/
    	$cat = crc32($cat);
    	
    	/*RUN QUERY*/
    	$catreturn = $this->DMSQuery("	SELECT `categoryid` 
    									FROM "._DATABASE.".`files_category` 
    									WHERE hashed = {$cat}",'_SELECT','CategorySearch');
    	
    	/*LOOKUP FILES RELATED TO CATEGORY*/
    	switch ($catreturn){
	    	case true:
	    		foreach ($catreturn as $value) {
	    			$listfiles = $this->DMSQuery("SELECT `fileid` FROM "._DATABASE.".`files` WHERE cid ={$value->categoryid}",'_SELECT','CategorySearch :: LOOKUP FILES RELATED TO CATEGORY');
	    		}
	    		break;
	    	}
	    /*LOOKUP FILES RELATED TO CATEGORY*/
    	switch ($listfiles){
	    	case true:
	    		foreach ($listfiles as $value) {
	    			$files[] = $value;
	    		}
	    		break;
	    	}	
	    	
    	return $files;
    }
    
     /**
     * SEARCH TYPE
     */
    function TypeSearch($type){
    	/*DB CONNECT*/
    	$this->DMSMySQLConnect();
    	
    	/*CHANGE CAPS*/
    	$type = strtoupper($type);
    	
    	/*CRC32*/
    	$type = crc32($type);
    	    	   	    	
    	/*RUN QUERY*/
    	$typereturn = $this->DMSQuery("SELECT `typeid` FROM "._DATABASE.".`files_type` WHERE hashed = {$type}",'_SELECT','TypeSearch');
    	
    	/*LOOKUP FILES RELATED TO TYPE*/
    	switch ($typereturn){
	    	case true:
	    		foreach ($typereturn as $value) {
	    			$listfiles = $this->DMSQuery("SELECT `fileid` FROM "._DATABASE.".`files` WHERE tid ={$value->typeid}",'_SELECT','TypeSearch :: LOOKUP FILES RELATED TO TYPE');
	    		}
	    		break;
	    	}
	    /*LOOKUP FILES RELATED TO CATEGORY*/
    	switch ($listfiles){
	    	case true:
	    		foreach ($listfiles as $value) {
	    			$files[] = $value;
	    		}
	    		break;
	    	}	
    	return $files;
    }
    
    /**
     * MANAGE SEARCH POST
     */
    function SearchPost($search){
        
    	   		
   		/*SWITCH*/
      	switch ($search['lookup']) {
     		case true:
     			/*EXPLOID*/
    			$searchlist = explode(" ",$search['search']);
				foreach ($searchlist as $value) {
					$files[] = $this->TagSearch($value);
    				$files[] = $this->CategorySearch($value);
    				$files[] = $this->TypeSearch($value);				
				}
     			
    			/*RETURN*/
    			return $this->SearchParse($files);
    			break;
    	}
	}
    
    /**
     * PASRSE RESULTS
     */
    function SearchParse($data){
    	/*COUNT*/
    	$count = count($data);
 		
    	/*LOOP RESULTS*/
    	for ($x = 0 ;$x < $count;$x++){
    		switch ($data[$x]){
    		case true:	
    			foreach ($data[$x] as $value){
    				$fileids[] = $value->fileid;
    			}
    			break;
    		}
    	}
    	
    	/*GET VALUES TO IMPLODE*/ 
    	switch ($fileids){
    		case true:
    			/*FILE LISTING*/
    			$filelist =  implode(",", $fileids);
    			break;	
    	}
    	
    	/*PASER RESULTS*/	
		switch ($filelist){
			case true:		
		
    			/*DB CONNECT*/
    			$this->DMSMySQLConnect(); 
    	
		    	/*QUERY*/
		    	$return = $this->DMSQuery("	SELECT `fileid`,`cid`,`tid`,`categoryname`,`typename`,`downloads`,`filename`,`displayname`,`path`,`mime`,`size` 
											FROM "._DATABASE.".`files` AS F
											JOIN "._DATABASE.".`files_category` AS C 
											ON `F`.cid = `C`.categoryid
											JOIN "._DATABASE.".`files_type` AS T 
											ON `F`.tid = `T`.typeid
											WHERE `F`.`online` = 1 
											AND `F`.`fileid` IN ($filelist)",'_SELECT','_SearchParse');
		    	/*RETURN*/
		    	return $this->TableSortHTML($return);
		    	break;
       	}
    }
    
    /**
     * TAG CLOUD
     **/
    function Tag(){
		/*DB CONNECT*/
    	$this->DMSMySQLConnect(); 

    	/*QUERY*/
		$return = $this->DMSQuery("SELECT SQL_CACHE count(`tagid`) AS myCount ,`tagname` 
								   FROM "._DATABASE.".`files_tags` 
								   WHERE `taghash` 	!= -1845434627 
								   AND `taghash` 	!=  1524198645  
								   AND `taghash` 	!= -1428017300  
								   AND `taghash` 	!= -1450728048
								   GROUP BY `taghash` ORDER BY myCount DESC",'_SELECT','_Tag');
		
		/*RETURN*/
		return $this->TagHTML($return);
    }
    
    /**
     * TAG HTML
     **/
    function TagHTML($tagcloud){
    	
    	$revert = 1;
    	$amont	= 0;
    	
    	
    	foreach ($tagcloud as $value) {
    		if ($amont < 20){
    			$return .= "<span class='word size$revert'> &nbsp; <a href='#' onclick=\"javascript:searchTag('$value->tagname');\">$value->tagname</a>&nbsp; </span>";
    		}
    		$revert++;
    		$amont++; 
    	}
    	
    	
    	/*RETURN*/
    	return $return;
    }
    
    /**
     * TAG LIST
     **/
    function TagList($fileid){
    	/*DB CONNECT*/
    	$this->DMSMySQLConnect(); 

    	/*QUERY*/
		$return = $this->DMSQuery("SELECT `tagname` FROM "._DATABASE.".`files_tags` WHERE fileid ={$fileid}",'_SELECT','_TagList');
    	
		/*RETURN*/
		return $this->TagListHTML($return);
    }
    
    /**
     * TAG LIST HTML
     **/
    function TagListHTML($tagitems){
		foreach ($tagitems as $value) {
			$return .= $value->tagname.";";
		}
		/*RETURN*/
		return  $return;    
    }
    
    /**
     * CAPTCHA
     **/
    function myCaptcha($_POST){
			
		/*THE RESPONSE FROM RECAPTCHA*/
		$resp = null;
		
		/*THE ERROR CODE FROM RECAPTCHA, IF ANY*/
		$error = null;
		
		/*WAS THERE A RECAPTCHA RESPONSE*/
		if ($_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer (_CAPTCHAKEYPRIVATE,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		        		if ($_POST['email'] AND $_POST['message']) {
		        			/*SEND EMAIL*/
		        			mail(_POC,_BOKCONTACTFORMNAME,$_POST['message']);
		        			
		        			/*INSERT TO DB*/
		        			$this->Messages2DB($_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']);
		        			
		        			/*RETURN*/
		        			$return = "<script>alert('Your message was sent to the administrators')</script>";
		        		}
		        } else {
		                # set the error code so that we can display it
		                $error = $resp->error;
		                $return = false;
		        
		        }
		}
		/*RETURN TO SCREEN*/
		print recaptcha_get_html(_CAPTCHAKEYPUBLIC, $error);
		
		/*RETURN RESULT*/
		return $return;
    }
    
    /**
     * SAVE MESG
     **/
    function Messages2DB($name,$email,$subject,$mesg){
    	
    	/*DB CONNECT*/
		$this->DMSMySQLConnect();
				
		/*RUN QUERY*/
		$return = $this->DMSQuery("INSERT INTO "._DATABASE.".`messages` (`name`,`email`,`subject`,`mesg`) values ('$name','$email','$subject','$mesg')",'_INSERT','_Messages2DB');	
		
    }

	/**
	 * MESG LIST
	 **/
	function Messages(){
		/*DB CONNECT*/
    	$this->DMSMySQLConnect(); 

    	/*QUERY*/
		$return = $this->DMSQuery("SELECT `mesgid`,`name`,`email`,`subject`,`mesg` FROM "._DATABASE.".`messages` WHERE online = 1 ",'_SELECT','_Messages');
    	
		/*RETURN*/
		return $this->MessagesHTML($return);	
	}
	
	/**
	 * MESG LIST HTML
	 **/
	function MessagesHTML($mesgdata){
		switch ($mesgdata) {
			case true:
					foreach ($mesgdata as $value){
						$return .= "<tr>";      
						$return	.= "<td>$value->mesgid</td>";
						$return	.= "<td>$value->name</td>";    
						$return	.= "<td>$value->email</td>";   
						$return	.= "<td>$value->subject</td>";
						$return	.= "<td>$value->mesg</td>"; 
						$return	.= "<td>".$this->ACLLink('MESG',false,$value->mesgid)."</td>";  
						$return	.= "</tr>"; 
					}
					break;
		}
		/*RETURN*/
		return $return;
	}
	
	/**
	 * CHECKS FOR ACL
	 **/
	function ACLcheker(){
		switch ($_SESSION['ROLL']){
			case 1 || 2 :
				return true;
			break;

			default:
				/* JS REDIRECT*/
				echo "<script type='text/javascript'>window.location = '/"._SYSTEMFOLDER."/index.php?screen=main&task=LOGIN'</script>";
				
				/*AVOID RENDERING*/
				exit();
			break;
		}
	}
	
	/**
	 * USER CHECK
	 **/
	function UserCheck($login,$username,$password){
		
		switch ($login){
			case true;
				/*DB CONNECT*/
	    		$this->DMSMySQLConnect(); 
				
	    		
	    		/*QUERY*/
				$return = $this->DMSQuery("SELECT `userid`,`userroll`,`username`,`email` FROM "._DATABASE.".`users` WHERE username = '".mysql_real_escape_string($username)."' AND passwd = md5('".mysql_real_escape_string($password)."') AND online = 1","_SELECT",'_UserCheck');
				
				/*VALIDATION*/
				$this->UserValidate($return);
			break;
			
			default:
				return null;
			break;			
		}
	}
	
	/**
	 * USER CHECK PARSE
	 **/
	function UserValidate($validation){
	
		switch ($validation){
			case true:
				/*SET SESSION*/
				$_SESSION['AUTHENTICATED'] 	= true;
				$_SESSION['ROLL'] 			= $validation[0]->userroll;
				
				/*HEADER REDIRECT*/
				echo "<script type='text/javascript'>window.location = '/"._SYSTEMFOLDER."/index.php?screen=main&task=ADMIN'</script>";
			break;	
		}
	}
	
	/**
	 * USER LOGOUT - INVAIDATE TOKEN
	 **/
	function UserInvalidate($invalidate = true){
		switch ($invalidate){
			case true:
				/*DESTROY SESSION*/
				session_destroy();

				/*HEADER REDIRECT*/
				echo "<script type='text/javascript'>window.location = '/"._SYSTEMFOLDER."/index.php?screen=main'</script>";
			break;	
		}
	}
	
	/**
	 * ACL LINKS
	 **/
	function ACLLink($type,$url,$id){
		/*LINK BY ACL*/
		switch ($_SESSION['ROLL']){
				case 1:
					switch ($type){
						case 'ADMIN':	
							$return  = "<a href='#' onclick='myFileForm($id,\"PUBLISH\");'> PUBLISH </a> |"; 
							$return .= "<a href='#' onclick='myFileForm($id,\"DELETE\");'> DELETE</a>";
							break;
						case 'MESG':	
							$return .= "<a href='#' onclick='myMessageForm($id,\"DELETE\");'> DELETE</a>";
							break;
						case 'USER':	
							$return .= "<a href='#' onclick='myUsersForm($id,false,\"DELETE\");'> DELETE |</a>";
							$return .= "<a href='#' onclick='myUsersForm($id,\"$url\",\"RESETPASSWORD\");'> RESET PASSWORD</a>";
							break;	
						default:
							$return  = "<a href='#' onclick='myFileForm($id,\"UNPUBLISH\");'> UNPUBLISH </a> |"; 
							$return .= "<a href='#' onclick='myFileForm($id,\"DELETE\");'> DELETE</a>";
							break;		
					}
					break;
				case 2:
					switch ($type){
						case 'ADMIN':
							$return  = "<a href='#' onclick='myFileForm($id,\"PUBLISH\");'>PUBLISH</a>"; 
							break;
						case 'MESG':	
							$return .= "<a href='#' onclick='myFileForm($id,\"DELETE\");'> DELETE</a>";
							break;
						default:
							$return  = "<a href='#' onclick='myFileForm($id,\"UNPUBLISH\");'>UNPUBLISH</a>"; 
							break;		
					}
					break;
				default:
					$return  = "<a href='$url' target='_blank'> VIEW </a>"; 
					break;			
			}
			
		return  $return;
	}
	
	/**
	 * FILE ACTIONS BY ACL
	 **/
	function FileActionACL($_POST){
			
		/*DB CONNECT*/
		$this->DMSMySQLConnect(); 
		/*CHECK FOR RIGHT USER TO ALLOW CHANAGES*/
		switch ($_SESSION['ROLL']){
			case 1:
				/*CHECK FOR POST TO BE TRUE*/
				switch ($_POST['fileid'] > 0){
					case true:
						switch ($_POST['action']) {
							case 'UNPUBLISH':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".files SET online = 0 WHERE fileid = ".mysql_real_escape_string($_POST['fileid'])." ","_UPDATE",'_FileAction - UNPUBLISH ');
							break;
							case 'PUBLISH':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".files SET online = 1 WHERE fileid = ".mysql_real_escape_string($_POST['fileid'])." ","_UPDATE",'_FileAction - PUBLISH ');
							break;
							case 'DELETED':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".files SET deleted = 1 WHERE fileid = ".mysql_real_escape_string($_POST['fileid'])." ","_UPDATE",'_FileAction - DELETED ');
							break;
						}
					/*HEADER REDIRECT*/
					print  "<script type='text/javascript'>window.location = '".$_SERVER['REQUEST_URI']."'</script>";
					break;	
				}
			case 2:
				/*CHECK FOR POST TO BE TRUE*/
				switch ($_POST['fileid'] > 0){
					case true:
						switch ($_POST['action']) {
							case 'UNPUBLISH':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".files SET online = 0 WHERE fileid = ".mysql_real_escape_string($_POST['fileid'])." ","_UPDATE",'_FileAction - UNPUBLISH ');
							break;
							case 'PUBLISH':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".files SET online = 1 WHERE fileid = ".mysql_real_escape_string($_POST['fileid'])." ","_UPDATE",'_FileAction - PUBLISH ');
							break;
						}
					/*HEADER REDIRECT*/
					print  "<script type='text/javascript'>window.location = '".$_SERVER['REQUEST_URI']."'</script>";
					break;	
				}
			default:
				return null;	
					
		}
	}
	
	/** 
	 * FUNCTION DELETE MESSAGES
	 **/
	function MessagesDelete($_POST){
		switch ($_SESSION['ROLL']){
			case 1:
				/*CHECK FOR POST TO BE TRUE*/
				switch ($_POST['mesgid'] > 0){
					case true:
						switch ($_POST['action']) {
							case 'DELETE':
								/*QUERY*/
								$this->DMSQuery("UPDATE "._DATABASE.".`messages` SET online = 0 WHERE mesgid = ".mysql_real_escape_string($_POST['mesgid'])." ","_UPDATE",'_MessagesDelete - DELETE ');
						}
					/*HEADER REDIRECT*/
					print  "<script type='text/javascript'>window.location = '".$_SERVER['REQUEST_URI']."'</script>";
					break;	
				}
			break;	
		}
	}
	
	/**
	 * SHOWUSERS
	 */
	function ShowUsers(){
		/*DB CONNECT*/
		$this->DMSMySQLConnect(); 
		
		/*QUERY*/
		$return = $this->DMSQuery("	SELECT `U`.`userid`,`U`.`userroll`,`U`.`username`,`U`.`email`,`U`.`online`,`UR`.rolltype
									FROM "._DATABASE.".`users` AS U
									JOIN "._DATABASE.".`users_roll` AS UR  ON `U`.`userroll` = `UR`.`rollid`
									WHERE `U`.`online` = 1 
									GROUP BY userid,online",'_SELECT','_ShowUsers');
		/*RETURN*/
		return $this->ShowUsersHTML($return);
		
	}
	
	/**
	 * SHOWUSERS LIST HTML
	 */
	function ShowUsersHTML($userslist){
		switch ($userslist) {
			case true:
					foreach ($userslist as $value){
						$return .= "<tr>";      
						$return	.= "<td>$value->username</td>";
						$return	.= "<td>$value->email</td>";    
						$return	.= "<td>$value->rolltype</td>";   
						$return	.= "<td>$value->online</td>"; 
						$return	.= "<td>".$this->ACLLink('USER',$value->email,$value->userid)."</td>";  
						$return	.= "</tr>"; 
					}
					break;
		}
		/*RETURN*/
		return $return;
	}
		
	/**
	 * USER ACCOUNTS
	 */
	function UserAccounts($_POST,$Account){
		
		//print_r($_POST);
		/*DB CONNECT*/
		$this->DMSMySQLConnect(); 
		/*CASE*/
		switch ($_SESSION['ROLL']){
			case 1:
				switch ($Account){
					case 'CREATEACCOUNT':	
						/*QUERY*/
						$this->DMSQuery("	INSERT INTO "._DATABASE.".users (`userroll`,`username`,`passwd`,`email`)  
											VALUES(".mysql_real_escape_string($_POST['roll']).",
												   '".mysql_real_escape_string($_POST['user'])."',
												   md5('".mysql_real_escape_string($_POST['password'])."'),
												   '".mysql_real_escape_string($_POST['email'])."')","_INSERT","UserAccounts - CREATE");	
						/*HEADER REDIRECT*/
						print  "<script type='text/javascript'>window.location = '".$_SERVER['REQUEST_URI']."'</script>";
						break;
					case 'DELETE':	
						/*QUERY*/
						$this->DMSQuery("UPDATE "._DATABASE.".users SET online = 0 WHERE userid = ".mysql_real_escape_string($_POST['userid']),"_SELECT","UserAccounts - DELETE ACCOUNT");	
						
						/*HEADER REDIRECT*/
						print  "<script type='text/javascript'>window.location = '".$_SERVER['REQUEST_URI']."'</script>";
						break;
					case 'RESETPASSWORD':	
							$this->UserAccountReset(mysql_real_escape_string($_POST['url']),mysql_real_escape_string($_POST['userid']));
						break;					
				}
			default:
				return null;
				break;	
		}
	}
	
	
	/**
	 * RESET PASSWORD
	 */
	function UserAccountReset($url,$id){
		/*DB CONNECT*/
		$this->DMSMySQLConnect(); 
		
		$password = $this->CreateRandomPassword();
		/*QUERY*/
		$this->DMSQuery("UPDATE "._DATABASE.".users SET passwd = md5('$password') WHERE userid = $id","_UPDATE","_UserAccountReset");
		
		/*SEND EMAIL*/
		mail($url,"BOK Password Generator",$password);
		
		/*ALERT*/
		echo "<script>alert('A new password has been sent to your email')</script>";
		
	} 
	
	/**
	 * Create Random Password
	 */
	
	function CreateRandomPassword() { 
	    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
	    srand((double)microtime()*1000000); 
	    $i = 0; 
	    $pass = '' ; 
	
	    while ($i <= 7) { 
	        $num = rand() % 33; 
	        $tmp = substr($chars, $num, 1); 
	        $pass = $pass . $tmp; 
	        $i++; 
	    } 
	
	    return $pass; 
	} 
	
			
	/**
	 * LIST ROLLS
	 */
	function UserRollList(){
		/*DB CONNECT*/
		$this->DMSMySQLConnect(); 
		
		/*QUERY*/
		$return = $this->DMSQuery("SELECT `rollid`,`rolltype` FROM "._DATABASE.".users_roll","_SELECT","UserRollList");
		
		return $this->UserRollListHTML($return);
	}
	
	/**
	 * LIST ROLLS HTML
	 */
	function UserRollListHTML($rolllist){
		switch ($rolllist) {
			case true:
					foreach ($rolllist as $value){
						echo "<option value='$value->rollid'>$value->rolltype</option>";
					}
					break;
		}
		/*RETURN*/
		return $return;
	}
	
}
?>