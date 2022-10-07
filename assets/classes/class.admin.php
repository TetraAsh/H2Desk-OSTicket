<?php
	class Admin {
		function __construct($MySQLi, $MySQLiOS ) {}

#=======================H2SELECTS===========================================================================		
		
		function TicketSelect() {
			global $MySQLi;
			$query = "SELECT * FROM `h2_ticket` WHERE id > 0 ORDER BY `id` desc LIMIT 100000";  #temp limit
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>TicketSelect");
			}
			else
			{
				#$tickets = $commit->fetch_assoc();
				$tickets = $commit;
				Return $tickets;
			}
		}	
	
		function OSTicketSelect() {
			global $MySQLiOS;
			$query = "SELECT * FROM `ost_ticket`";  #temp limit
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>OSTicketSelect");
			}
			else
			{
				#$tickets = $commit->fetch_assoc();
				$tickets = $commit;
				Return $tickets;
			}
		}	
	
		function ThreadSelect($ticket_id) {
			global $MySQLi;
			$query = "SELECT * FROM `h2_post` WHERE ticket_id = ".$ticket_id." ORDER BY `id`";  #temp limit to scda and 20 result for testing
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>ThreadSelect");
			}
			else
			{
				$thread = $commit;
				Return $thread;
			}
		}
		
		function UserSelect($user_id) {
			global $MySQLi;
			$query = "SELECT * FROM `h2_user` WHERE id = ".$user_id.""; 
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>UserSelect");
			}
			else
			{
				$user = $commit;
				Return $user;
			}
		}
		
		
#====================INSERTS================================================================================		
		
		
		function TicketInsert( $number, $user_id, $user_email_id, $status_id, $dept_id, $sla_id, $topic_id, $staff_id, $team_id, $email_id, $lock_id, $flags, $ip_address, $source, $source_extra, $isoverdue, $isanswered, $duedate, $est_duedate, $reopened, $closed, $lastupdate, $created, $updated) {
			global $MySQLiOS;
			
			$query = "Insert into ost_ticket ( number, user_id, user_email_id, status_id, dept_id, sla_id, topic_id, staff_id, team_id, email_id, lock_id, flags, ip_address, source, source_extra, isoverdue, isanswered, duedate, est_duedate, reopened, closed, lastupdate, created, updated ) VALUES ( '$number', $user_id, $user_email_id, $status_id, $dept_id, $sla_id, $topic_id, $staff_id, $team_id, $email_id, $lock_id, $flags, '$ip_address', '$source', $source_extra, $isoverdue, $isanswered, $duedate, $est_duedate, $reopened, '$closed', '$lastupdate', '$created', '$updated' )";
			
			echo "<br/>".$query."<br/>";
		
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>TicketInsert.");
			}
			else
			{
				Return true;
			}
		}

		function TicketCdataInsert($ticket_id, $subject, $priority) {
			global $MySQLiOS;	
			
			#$subject = str_replace ( "-", ":", $subject );
			$subject = mysqli_real_escape_string ( $MySQLiOS, $subject );

			$query = "Insert into ost_ticket__cdata ( ticket_id, subject, priority ) VALUES ( $ticket_id, '$subject', $priority )";
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>TicketCdataInsert.");
			}
			else
			{
				Return true;
			}
		}
		
		function ThreadInsert($object_id, $object_type, $extra, $lastresponse, $lastmessage, $created) {
			global $MySQLiOS;
			$query = "Insert into ost_thread ( object_id, object_type, extra, lastresponse, lastmessage, created ) VALUES ( $object_id, '$object_type', $extra, $lastresponse, '$lastmessage', '$created' )";
		
			echo "<br/>".$query."<br/>";
		
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>ThreadInsert.");
			}
			else
			{
				Return true;
			}
		}
	
		function ThreadCollaboratorInsert($flags, $thread_id, $user_id, $role, $created, $updated) {
			global $MySQLiOS;
			$query = "Insert into ost_thread_collaborator ( flags, thread_id, user_id, role, created, updated ) VALUES ( $flags, $thread_id, $user_id, '$role', '$created', '$updated' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>ThreadCollaboratorInsert.");
			}
			else
			{
				Return true;
			}
		}
		
		function ThreadEntryInsert($pid, $thread_id, $staff_id, $user_id, $type, $flags, $poster, $editor, $editor_type, $source, $title, $body, $format, $ip_address, $recipients, $created, $updated) {
			global $MySQLiOS;
			
		#	$title = str_replace ( "-", ":", $title );
		#	$body = str_replace ( "-", ":", $body );
			$title = mysqli_real_escape_string ( $MySQLiOS, $title );
			$body = mysqli_real_escape_string ( $MySQLiOS, $body );
			
			$query = "Insert into ost_thread_entry ( thread_id, staff_id, user_id, type, flags, poster, editor, editor_type, source, title, body, format, ip_address, recipients, created, updated ) VALUES ( '$thread_id', '$staff_id', '$user_id', '$type', '$flags', '$poster', $editor, $editor_type, '$source', '$title', '$body', '$format', '$ip_address', $recipients, '$created', '$updated' )";
			
			echo "<br/>".$query."<br/>";
			
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>ThreadEntryInsert.");
			}
			else
			{
				Return true;
			}
		}	
	
		function UserInsert( $org_id, $default_email_id, $status, $name, $created, $updated ) {
			global $MySQLiOS;	

			$query = "Insert into ost_user ( org_id, default_email_id, status, name, created, updated ) VALUES ( $org_id, $default_email_id, '$status', '$name', '$created', '$updated' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>UserInsert-1.");
			}
			else
			{
				$query2 = "SELECT `id` from `ost_user` ORDER BY `id` desc LIMIT 1";
				
				echo "<br/>".$query2."<br/>";
				
				$commit2 = $MySQLiOS->query($query2);
				if($commit2 === false) {
					die("Error Occurred - Admin>UserInsert-2.");
				}
				else
				{
					$id = $commit2->fetch_assoc();
					$id =  $id['id'];
					return $id;
					
				}
			}
		}	
	
		function UserInsertUpdate( $user_id, $email_id ) {
			global $MySQLiOS;	

			$query = "UPDATE ost_user SET default_email_id = $email_id WHERE id = $user_id";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>UserInsertUpdate.");
			}
			else
			{
				Return true; 
			}
		}
		
		function UserCdataInsert( $email, $name, $phone, $notes ) {
			global $MySQLiOS;	
			

			$query = "Insert into ost_user__cdata ( email, name, phone, notes ) VALUES ( '$email', '$name', '$phone', '$notes' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>UserCdataInsert.");
			}
			else
			{
				Return true;
			}
		}
			
		function UserEmailInsert( $user_id, $flags, $address ) {
			global $MySQLiOS;	
			
			#$subject = str_replace ( "-", ":", $subject );
			$subject = mysqli_real_escape_string ( $MySQLiOS, $subject );

			$query = "Insert into ost_user_email ( user_id, flags, address ) VALUES ( '$user_id', $flags, '$address' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>UserEmailInsert-1.");
			}
			else
			{
				$query2 = "SELECT `id` from ost_user_email ORDER BY id desc LIMIT 1";
				echo "<br/>".$query2."<br/>";
				
				$commit2 = $MySQLiOS->query($query2);
				if($commit2 === false) {
					die("Error Occurred - Admin>UserEmailInsert-2.");
				}
				else
				{
					$id = $commit2->fetch_assoc();
					$id =  $id['id'];
					return $id;
					
				}
			}
		}			
	
		function FormEntryInsert( $form_id, $object_id, $object_type, $sort, $extra, $created, $updated ) {
			global $MySQLiOS;	

			$query = "Insert into ost_form_entry ( form_id, object_id, object_type, sort, extra, created, updated ) VALUES ( '$form_id', '$object_id', '$object_type', '$sort', '$extra', '$created', '$updated' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>FormEntryInsert-1.");
			}
			else
			{
				$query2 = "SELECT * from ost_form_entry ORDER BY id desc LIMIT 1";
				$commit2 = $MySQLiOS->query($query2);
				if($commit2 === false) {
					die("Error Occurred - Admin>FormEntryInsert-2.");
				}
				else
				{
				 $last_row = $commit2->fetch_assoc();
				 return  $last_row['id'];
				}
			}
		}

		function FormEntryValueInsert( $entry_id, $field_id, $value, $value_id  ) {
			global $MySQLiOS;	
			
			if ( $value == 'NULL' ) {
				
				$query = "Insert into ost_form_entry_values ( entry_id, field_id, value, value_id ) VALUES ( $entry_id, $field_id, $value, '$value_id' )";
				
			} else {
				
				$value = mysqli_real_escape_string ( $MySQLiOS, $value );
				$query = "Insert into ost_form_entry_values ( entry_id, field_id, value, value_id ) VALUES ( $entry_id, $field_id, '$value', $value_id )";
			}
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>FormEntryValueInsert-1.");
			}
			else
			{
				 return true ;
			}
		}
		
#==================TRANSLATES====================================================================================	
		
		
		function TranslateOSEmailtoID($email, $name) {
			
			#find the id in OSTicket
			global $MySQLiOS;
			$query = "select * from ost_user_email WHERE address = '$email'";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				#die("Error Occurred - Admin>GetUserID-os.");
				# NEED TO write in a create user statment when user is not found
			}
			else
			{
				if($commit->num_rows === 0)
				{
					$UserInsert['org_id'] = "0";
					$UserInsert['default_email_id'] = "1";
					$UserInsert['status'] = "0";
					$UserInsert['name'] = $name;
					$UserInsert['created'] = "2019-11-11 11:11:11";
					$UserInsert['updated'] = "2019-11-11 11:11:11";
					
					$UserEmailInsert['user_id'] = $this->UserInsert( $UserInsert['org_id'], $UserInsert['default_email_id'], $UserInsert['status'], $UserInsert['name'], $UserInsert['created'], $UserInsert['updated'] );
					$UserEmailInsert['flags'] = "0";
					$UserEmailInsert['address'] = $email;
					
					$UserInsert['email_id'] = $this->UserEmailInsert( $UserEmailInsert['user_id'], $UserEmailInsert['flags'], $UserEmailInsert['address'] );
					$this->UserInsertUpdate( $UserEmailInsert['user_id'], $UserInsert['email_id'] );
					return $UserEmailInsert['user_id'];
				}
				else
				{
					$email_row = $commit->fetch_assoc();
					return  $email_row['user_id'];
				}
			}
		}		
				
		function TranslateUserID($user_id) {
			global $MySQLi;
			#Find the users email in h2Desk
			$query = "select * from h2_user WHERE id = '$user_id'";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>GetUserID-h2.");
			}
			else
			{
				$user = $commit->fetch_assoc();
				#echo "<br/>".print_r($user)."<br/>";
			}
			if ($user['email'] == "") { $user['email'] = "support@tetrabyte.com"; };
			#echo "<br/>".$user['email'].",". $user['name']."<br/>";
			
			$id = $this->TranslateOSEmailtoID( $user['email'], $user['name'] );		
			return $id;
		}	

		function TranslateStatus($status) {
				
			# 	From - H2Desk			#	To - OSTICKET
			#	0 - Open				#	1 - Open - Open
			# 	1 - Closed 				#	3 - Closed - Closed		
			#	2 - Hold 				#	6 - Hold - Open
			#	3 - Trash 				#	5 - Deleted - Deleted
			#	4 - Awaiting Customer	#	7 - Awaiting Customer	
			#	5 - New					#	1 - Open - Open	
			#	6 - Open				#	1 - Open - Open
			
			#	To - OSTICKET
			#	4 - Archived - Archived	
			#	2 - Resolved - Closed

			switch ($status) {
				case 0:
					Return 1;
					break;
				case 1:
					Return 3;
					break;		
				case 2:
					Return 6;
					break;
				case 3:
					Return 5;
					break;
				case 4:
					Return 7;
					break;
				case 5:
					Return 1;
					break;
				case 6:
					Return 1;
					break;					
				default:
					Return false;
			}			
		}
		
		function TranslatePriority($priority) {

			# 	From - H2Desk		#	To - OSTICKET
			#	1 - Low				#	1 - low
			# 	2 - Medium			#	2 - normal
			#	3 - High			#	3 - high	
			#	4 - As and When		#	1 - low	
			#	5 - Urgent			#	4 - emergency
			#	6 - Job from James	#	3 - high
						
			switch ($priority) {
				case 1:
					Return 1;
					break;		
				case 2:
					Return 2;
					break;
				case 3:
					Return 3;
					break;
				case 4:
					Return 1;
					break;
				case 5:
					Return 4;
					break;
				case 6:
					Return 3;
					break;
				default:
					Return false;
			}			
		}
	
		function TranslateStaffID($staff_id) {

			# 	From - H2Desk				#	To - OSTICKET-AgentID
			#	0 - NONE						
			#	1 - James					#	6 - James
			#	3 - Ashley					#	1 - Ashley
			# 	33 - Steve					# 	2 - Steve
			#	40 - Martyn					#	7 - Martyn
			#	55 - Support				#	8 - Support
			#	52 - Peter - no tickets		#	8 - Peter no tickets	
			#	77 - Callum					#	3 - Callum	
			#	108 - Liam					#	8 - Liam make Support
			#	110 - Frank - no tickets	#	4 - Frank	
			#	111 - Dan - no tickets		#	5 - Dan
			
			switch ($staff_id) {
				case 0:
					Return 0;
					break;				
				case 1:
					Return 6;
					break;		
				case 3:
					Return 1;
					break;
				case 33:
					Return 2;
					break;
				case 40:
					Return 7;
					break;
				case 55:
					Return 8;
					break;
				case 52:
					Return 8;
					break;
				case 77:
					Return 3;
					break;
				case 108:
					Return 8;
					break;
				case 110:
					Return 4;
					break;
				case 111:
					Return 5;
					break;
				default:
					Return 0;
			}			
		}
		
		function TranslatePostUser($user_id) {
			# 	From - H2Desk				#	To - OSTICKET-AgentID
			#	0 - NONE						
			#	1 - James					#	6 - James
			#	3 - Ashley					#	1 - Ashley
			# 	33 - Steve					# 	2 - Steve
			#	40 - Martyn					#	7 - Martyn
			#	55 - Support				#	8 - Support
			#	52 - Peter - no tickets		#	8 - Peter no tickets	
			#	77 - Callum					#	3 - Callum	
			#	108 - Liam					#	8 - Liam make Support
			#	110 - Frank - no tickets	#	4 - Frank	
			#	111 - Dan - no tickets		#	5 - Dan
			
			switch ($user_id) {
				case 0:
					$id = array("none",0);
					Return 0;
					break;				
				case 1:
					$id = array("agent",6);
					Return $id;
					break;		
				case 3:
					$id = array("agent",1);
					Return $id;
					break;
				case 33:
					$id = array("agent",2);
					Return $id;
					break;
				case 40:
					$id = array("agent",7);
					Return $id;
					break;
				case 55:
					$id = array("agent",8);
					Return $id;
					break;
				case 77:
					$id = array("agent",3);
					Return $id;
					break;
				case 108:
					$id = array("agent",8);
					Return $id;
					break;
				case 110:
				$id = array("agent",4);
					Return $id;
					break;
				case 111:
					$id = array("agent",5);
					Return $id;
					break;
				default:
					$OSuser_id = $this->TranslateUserID($user_id);
					$id = array("user", $OSuser_id);
					return $id;
			}			
		}
		
#==================GETS=====================================================================================
		
		
		function GetOSTicketID($number) {

			global $MySQLiOS;
			$query = "select ticket_id from ost_ticket WHERE number = '$number'";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>GetTicketID.");
			}
			else
			{
				$ticket_id = $commit->fetch_assoc();
				$ticket_id =  $ticket_id['ticket_id'];
				return $ticket_id;
			}
		}	
		
		function GetOSThreadID($ticket_id) {

			global $MySQLiOS;
			$query = "select id from ost_thread WHERE object_type = 'T' AND object_id = $ticket_id";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiOS->query($query);
			if($commit === false) {
				die("Error Occurred - Admin>GetThreadID.");
			}
			else
			{
				$thread_id = $commit->fetch_assoc();
				$thread_id =  $thread_id['id'];
				echo "<br/>Returning threadid = ".$thread_id."<br/>";
				return $thread_id;
			}
		}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		function companySelect($company = '0') {
			global $MySQLi;
			$query = "SELECT * FROM `companynames` WHERE companynames.suspend = 0 ORDER BY `companyname`";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred.");
			}
			else
			{
				echo '<option value="ALL">All Companies</option>';
				while($row = $commit->fetch_assoc()) {
					if($row['companynum'] == $company) {
						echo '<option value="'.$row['companynum'].'" selected="selected">'.$row['companyname'].'</option>';
					}
					else
					{
						echo '<option value="'.$row['companynum'].'">'.$row['companyname'].'</option>';
					}
				}
			}
		}
		
		function tablePopulate($companynum, $info, $showSuspend, $edit, $lastseen = '0') {
			global $MySQLi, $security, $frontend;
			if($companynum == 'ALL') {
				if($showSuspend == 1) {
					$query = "SELECT * FROM `computers`";
				}
				else
				{
					$query = "SELECT * FROM `computers` WHERE `suspend` = '0'";
				}
			}
			else
			{
				if($showSuspend == 1) {
					$query = "SELECT * FROM `computers` WHERE `companynum` = '".$companynum."'";
				}
				else
				{
					$query = "SELECT * FROM `computers` WHERE `companynum` = '".$companynum."' AND `suspend` = '0'";
				}
			}
			if($lastseen == 1) {
				$query = $query." ORDER BY `sqllastseendatetime` DESC";
			}
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred.");
			}
			else
			{
				$array = array();
				while($row = $commit->fetch_assoc()) {
					if($row['suspend'] != '0' && in_array($row['computername'], $array)) {
						echo '<tr class="warning">';
					}
					elseif($row['suspend'] != '0') {
						$array[] = $row['computername'];
						echo '<tr class="danger">';
					}
					elseif(in_array($row['computername'], $array)) {
						echo '<tr class="info">';
					}
					else
					{
						$array[] = $row['computername'];
						echo '<tr>';
					}
					foreach($info as $null => $key) {
						if($key == 'cpu') {
							echo '<td class="vert-align"><a href="https://www.google.co.uk/#q=site:cpubenchmark.net+'.urlencode($row[$key]).'" target="_blank">'.$row[$key].'</a></td>';
						}
						elseif($key == 'memory') {
							echo '<td class="vert-align"><a href="https://www.google.co.uk/#q=site:mrmemory.co.uk+'.urlencode($row['make'].' '.$row['model']).'" target="_blank">'.$row[$key].'</a></td>';
						}
						elseif($key == 'homeuse') {
							if($row[$key] == '0') {
								echo '<td class="vert-align">Work-Use</td>';
							}
							elseif($row[$key] == '1')
							{
								echo '<td class="vert-align">Home-Use</td>';
							}
						}
						elseif($key == 'office') {
							if($row[$key] == '0') {
								echo '<td class="vert-align">Not Installed</td>';
							}
							else
							{
								echo '<td class="vert-align">'.$row[$security->EscapeString($key)].'</td>';
							}
						}
						elseif($key == 'av') {
							if($row[$key] == '0') {
								echo '<td class="vert-align">No-AV</td>';
							}
							else
							{
								echo '<td class="vert-align">'.$row[$security->EscapeString($key)].'</td>';
							}
						}
						elseif($key == 'username') {
							$userhistory = $frontend->userHistory($row['id']);
							if($row[$key] == '' || $row[$key] == NULL) {
								echo '<td class="vert-align" id="edit-uname" data-pcid="'.$row['id'].'"><span data-toggle="tooltip" data-placement="right" title="'.$userhistory.'">None Set</span></td>';
							}
							else
							{
								echo '<td class="vert-align" id="edit-uname" data-pcid="'.$row['id'].'"><span data-toggle="tooltip" data-placement="right" title="'.$userhistory.'">'.$row[$security->EscapeString($key)].'</span></td>';
							}
						}
						elseif($key == 'department') {
								echo '<td class="vert-align" id="edit-department" data-pcid="'.$row['id'].'">'.$row[$security->EscapeString($key)].'</td>';
						}
						elseif($key == 'computername') {
							if ($_GET['editingmode'] == 1) {
								echo '<td class="vert-align" id="edit-computername" data-pcid="'.$row['id'].'">'.$row[$security->EscapeString($key)].'</td>';
							} else {
								echo '<td class="vert-align" id="noedit-computername" data-pcid="'.$row['id'].'">'.$row[$security->EscapeString($key)].'</td>';
							}
						}
						elseif($key == 'companynum') {
								echo '<td class="vert-align" id="edit-companyid" data-pcid="'.$row['id'].'">'.$row[$security->EscapeString($key)].'</td>';
						}
						else
						{
							echo '<td class="vert-align">'.$row[$security->EscapeString($key)].'</td>';
						}
					}
					if($edit == 1) {
						echo '<td class="vert-align">';
						if($row['suspend'] == '0') {
							echo '<button type="button" class="btn btn-danger btn-block" data-toggle="modal" id="suspendBtn" data-id="'.$row['id'].'" data-target="#suspendModal">Suspend</button>';
						}
						else
						{
							echo '<div data-toggle="tooltip" data-placement="top" title="'.$row['suspend'].'"><button style="margin-bottom: 5px;" type="button" class="btn btn-success btn-block" data-toggle="modal" id="unsuspendBtn" data-id="'.$row['id'].'" data-target="#unsuspendModal" data-reason="'.$row['suspend'].'">Unsuspend</button></div>';
						}
						 if ($_GET['editingmode'] == 1) {echo ' <button type="button" id="delete-btn" data-pcid="'.$row['id'].'" class="btn btn-default btn-block">Delete</a>';}
						 if ($_GET['editingmode'] == 1) {echo ' <button type="button" id="update-btn" data-pcid="'.$row['id'].'" class="btn btn-default btn-block">Update LastSeen</a>';}
						 if ($_GET['editingmode'] == 1) {echo ' <button type="button" id="home-btn" data-pcid="'.$row['id'].'" class="btn btn-default btn-block">Home Use</a>';}
						echo '</td>';
					}
					echo '</tr>';
				}
			}
		}
		
		function pcInfo($id) {
			global $MySQLi;
			$query = "SELECT * FROM `computers` WHERE `id` = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred.");
			}
			else
			{
				return $commit->fetch_assoc();
			}
		}
		
		function companyByID($id) {
			global $MySQLi;
			$query = "SELECT * FROM `companynames` WHERE `companynum` = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred.");
			}
			else
			{
				return $commit->fetch_assoc();
			}
		}
		
		function suspendPC($pcid, $reason) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `suspend` = '".$reason."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}
		
		function unsuspendPC($pcid) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `suspend` = '0' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}
		
		function report() {
			global $MySQLi;
			$query = "SELECT * FROM `companynames` WHERE companynames.suspend = 0 ORDER BY `companyname` ASC";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				while($row = $commit->fetch_assoc()) {
					$countQuery = "SELECT `id` FROM `computers` WHERE `companynum` = '".$row['companynum']."' AND `suspend` = '0'";
					$commit1 = $MySQLi->query($countQuery);
					if($commit1 === false) {
						return false;
					}
					else
					{
						$row1 = $commit1->fetch_assoc();
						$count = $commit1->num_rows;
						if($row['max'] >= $count) {
							echo '<tr class="success">';
							$status = 'Within Subscription';
						}
						else
						{
							echo '<tr class="danger">';
							$status = 'Over-Subscribed';
						}
						echo '<td>'.$row['companyname'].'</td>';
						echo '<td>'.$row['max'].'</td>';
						echo '<td>'.$count.'</td>';
						echo '<td>'.$status.'</td>';
						echo '</tr>';
					}
				}
			}
		}
		
		function companiesTable() {
			global $MySQLi;
			$query = "SELECT * FROM `companynames` ORDER BY `companyname` ASC";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				while($row = $commit->fetch_assoc()) {
					if($row['suspend'] == '1') {
						echo '<tr class="danger">';
					}
					else
					{
						echo '<tr>';
					}
					echo '<td>'.$row['companynum'].'</td>';
					echo '<td>'.$row['companyname'].'</td>';
					echo '<td>'.$row['max'].'</td>';
					echo '<td><button type="button" id="edit" data-id="'.$row['id'].'" class="btn btn-info btn-block">Edit</button></td>';
					echo '</tr>';
				}
			}
		}
		
		function usersTable() {
			global $MySQLi;
			$query = "SELECT * FROM `users` ORDER BY `id` ASC";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				while($row = $commit->fetch_assoc()) {
					if($row['suspend'] == '1') {
						echo '<tr class="danger">';
					}
					else
					{
						echo '<tr>';
					}
					echo '<td>'.$row['id'].'</td>';
					echo '<td>'.$row['username'].'</td>';
					echo '<td>'.$row['email'].'</td>';
					echo '<td><button type="button" id="edit" data-id="'.$row['id'].'" class="btn btn-info btn-block">Edit</button></td>';
					echo '</tr>';
				}
			}
		}
		
		function getCompanyInfo($cid) {
			global $MySQLi;
			$query = "SELECT * FROM `companynames` WHERE `id` = '".$cid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return $commit->fetch_assoc();
			}
		}
		
		function getUserInfo($id) {
			global $MySQLi;
			$query = "SELECT * FROM `users` WHERE `id` = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return $commit->fetch_assoc();
			}
		}
	
		function editCompany($id, $companyName, $companyNum, $maxPC, $suspend) {
			global $MySQLi;
			$query = "UPDATE `companynames` SET `companyname` = '".$companyName."', `companynum` = '".$companyNum."', `max` = '".$maxPC."', `suspend` = '".$suspend."' WHERE `id` = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}
		
		function editUser($id, $userame, $email, $suspend) {
			global $MySQLi;
			$query = "UPDATE `users` SET `username` = '".$userame."', `email` = '".$email."', `suspend` = '".$suspend."' WHERE `id` = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}
		
		function deletePC($pcid) {
			global $MySQLi;
			$query = "DELETE FROM `computers` WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}

		function updatedatetimePC($pcid) {
			global $MySQLi;
			$datetime = DATE("Y-m-d H:m:s");
			$query = "UPDATE `computers` SET `sqllastseendatetime` = '".$datetime."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return $query;
			}
			else
			{
				return true;
			}
		}

		function togglehomeusePC($pcid) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `homeuse` = 1 WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return $query;
			}
			else
			{
				return true;
			}
		}

		function updateUser($pcid, $name) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `username` = '".$name."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}

		function updateDepartment($pcid, $name) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `department` = '".$name."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}

		function updateComputername($pcid, $name) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `computername` = '".$name."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}

		function updateCompanyid($pcid, $name) {
			global $MySQLi;
			$query = "UPDATE `computers` SET `companynum` = '".$name."' WHERE `id` = '".$pcid."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				return false;
			}
			else
			{
				return true;
			}
		}

		function updatecpuadv($cpu) {
			global $MySQLi, $security;
			
			$cpuq = 'Select `Score` from `cpuscores` WHERE `CPU`="'.$cpu.'"';
			$cpucommit = $MySQLi->query($cpuq);		
			$cpuscore = $cpucommit->fetch_assoc();


			echo $cpu.",".$cpuscore['Score']."<br/>";		
			$query = "UPDATE `computers` SET `cpuscore` = '".$cpuscore['Score']."' WHERE `cpu` = '".$cpu."'";
			$commit = $MySQLi->query($query);
			if($commit === false) {
				die("Error Occurred - SQL update failed in admin-updatecpuscore");
			}
			else
			{
				return true;
			}
		}

		function updateCPUScores () {
			global $MySQLi;
			$query = "SELECT * from `computers`";
			$commit = $MySQLi->query($query);
			
				while($row = $commit->fetch_assoc()) {
					//echo $row['cpu']."<br/>";
					$this->updatecpuadv($row['cpu']);				
				
				}
		}
	
	}
	