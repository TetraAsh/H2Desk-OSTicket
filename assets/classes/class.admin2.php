<?php
	class Admin {
		function __construct($MySQLiTest) {}

#=======================OSTicketEvents===========================================================================

		function TestTicketSelect() {
			global $MySQLiTest;
			$query = "SELECT * FROM `ost_ticket` ORDER BY `ticket_id` asc LIMIT 100000";  #temp limit
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiTest->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>TestTicketSelect");
			}
			else
			{
				#$tickets = $commit->fetch_assoc();
				$tickets = $commit;
				Return $tickets;
			}
		}	
	
		function UserSelect($user_id) {
			global $MySQLiTest;
			$query = "SELECT * FROM `ost_user` WHERE id = ".$user_id." LIMIT 1"; 
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiTest->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>UserSelect");
			}
			else
			{
				$user = $commit->fetch_assoc();
				$user_name = $user['name'];
				return $user_name;
			}
		}	
	
		function StaffSelect($staff_id) {
			global $MySQLiTest;
			$query = "SELECT * FROM `ost_staff` WHERE staff_id = ".$staff_id." LIMIT 1"; 
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiTest->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>StaffSelect");
			}
			else
			{
				$staff = $commit->fetch_assoc();
				$staff_name = $staff['firstname'];
				return $staff_name;
			}
		}

		function TranslateEvent() {
			
			#	1	created
			#	2	closed
			#	3	reopened
			#	9	edited
			#	14	deleted

		}

		function TranslateStaffUser($staff_id) {
			
			#	user 	staff 	name
			#	2		1		ashley
			#	17		8		support
			#	34		3		callum
			#	84		2		steve
			#	192		6		james
			#	884		4		frank
			
			switch ($staff_id) {
				case 1:
					Return 2;
					break;				
				case 8:
					Return 17;
					break;		
				case 3:
					Return 34;
					break;
				case 2:
					Return 84;
					break;
				case 6:
					Return 192;
					break;
				case 4:
					Return 884;
					break;
				default:
					Return 0;
			}
			
			
		}

		function TranslateTicketID($ticket_id) {
			global $MySQLiTest;
			$query = "SELECT * FROM `ost_thread` WHERE object_id = ".$ticket_id." LIMIT 1";  #temp limit
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiTest->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>TranslateTicketID");
			}
			else
			{
				$row = $commit->fetch_assoc();
				$thread_id = $row['id'];
				Return $thread_id;
			}
			
			
			
		}

		function InsertThreadEvent ($thread_id, $event_id, $staff_id, $team_id, $dept_id, $topic_id, $data, $username, $uid, $uid_type, $annulled, $timestamp) {
			global $MySQLiTest;
			
			#Insert into ost_thread_event ( thread_id, event_id, staff_id, team_id, dept_id, topic_id, data, username, uid, uid_type, annulled, timestamp ) VALUES ( 1, 1, 1, 0, 1, 10, NULL, Jason Perry, 3, U, 0, 2019-11-19 16:55:37 )
			
			
			$query = "Insert into ost_thread_event ( thread_id, event_id, staff_id, team_id, dept_id, topic_id, data, username, uid, uid_type, annulled, timestamp ) VALUES ( '$thread_id', '$event_id', '$staff_id', '$team_id', '$dept_id', '$topic_id', $data, '$username', '$uid', '$uid_type', '$annulled', '$timestamp' )";
			
			echo "<br/>".$query."<br/>";
			
			$commit = $MySQLiTest->query($query);
			if($commit === false) {
				die("Error Occurred. - Admin>InsertThreadEvent");
			}
			else
			{
				Return true;
			}
		}
	}
	