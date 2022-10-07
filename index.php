<?php

include('assets/init2.php');


	#	1 - Need to ensure all users are created on OSTicket
	#	2 - Need to ensure all agents are created and $admin->TranslateStaffID is setup correctly for mappings




 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $settings['system_name']; ?></title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
		/*.table > tbody > tr > td {
			border-top: none;
		}*/
	</style>
  </head>
  <body>
  
  
  
  
  	<div class="container">
    	<div class="row">
            <div class="col-md-12 text-center">
                <img src="assets/images/tetrabyte_logo_transparent.png" class="frontend-logo" />
                <h1>Ticket Transfer</h1>
                <p></p>
                <p style="font-weight: bold;">For Engineer use only.</p>
            </div>
        </div>
        
		
		<!-- TESTING AREA -->
		
		<div class="row">
		
		<?php
		
			# imported ID's 133 - 20244
			
			need to limit recent id's
		?>
		
		</div>
		<!-- /TESTING AREA -->
		
		
        <div class="row">
        	<div class="col-md-12">
            	<h3 class="page-header" style="margin-top: 20px; "><span style="font-size: 72px;"> 
				</h3>
				
				<?php
				
					
					
					$a = 1;
					$tickets = $admin->TestTicketSelect();					
					foreach ($tickets as $ticket) {


	echo "<br/><h2>Ticket $a:</h2><br/>";
						$a++;
						foreach ($ticket as $key => $val) {

							if ($key == "ticket_id") {
								$TestTicket['ticket_id'] = $val;
								echo $key." = ".$val." Setting TestTicket-ticket_id = ".$TestTicket['ticket_id']."<br/>";
								$Thread['id'] = $admin->TranslateTicketID($TestTicket['ticket_id']);
								echo "Setting Thread_id = ".$Thread['id']."<br/>";
								
								
							}elseif ($key == "user_id") {
								
								$TestTicket['uid_type'] = "U";
								echo "Setting TestTicket-uid_type = ".$TestTicket['uid_type']."<br/>";
								
								$TestTicket['uid'] = $val;
								echo $key." = ".$val."Setting TestTicket-uid = ".$TestTicket['uid']."<br/>";
			
								$TestTicket['username'] = $admin->UserSelect($val);
								echo $key." = ".$val." Setting TestTicket-username = ".$TestTicket['username']."<br/>";
									
									
							}elseif ($key == "staff_id") {
								if ( $val <= 8  ) {
									
									$TestTicket['uid_type'] = "S";
									echo "Setting TestTicket-uid_type = ".$TestTicket['uid_type']."<br/>";
									
									$TestTicket['uid'] = $val;
									echo $key." = ".$val." Setting TestTicket-uid = ".$TestTicket['uid']."<br/>";
								
									$TestTicket['username'] = $admin->StaffSelect($val);
									echo $key." = ".$val." Setting TestTicket-username = ".$TestTicket['username']."<br/>";
								}else{
									echo "Staff id not less than 8 <br/>";
								}
								$TestTicket['staff_id'] = $val;
								echo $key." = ".$val." Setting TestTicket-staff_id = ".$TestTicket['staff_id']."<br/>";
								
								
							}elseif ($key == "team_id") {
								$TestTicket['team_id'] = $val;
								echo $key." = ".$val." Setting TestTicket-team_id = ".$TestTicket['team_id']."<br/>";
								
								
							}elseif ($key == "dept_id") {
								$TestTicket['dept_id'] = $val;
								echo $key." = ".$val." Setting TestTicket-dept_id = ".$TestTicket['dept_id']."<br/>";
								
								
							}elseif ($key == "topic_id") {
								$TestTicket['topic_id'] = $val;
								echo $key." = ".$val." Setting TestTicket-topic_id = ".$TestTicket['topic_id']."<br/>";
								
								
							}elseif ($key == "created") {
								$TestTicket['created'] = $val;
								echo $key." = ".$val." Setting TestTicket-created = ".$TestTicket['created']."<br/>";
							}
							elseif ($key == "closed") {
								$TestTicket['closed'] = $val;
								echo $key." = ".$val." Setting TestTicket-closed = ".$TestTicket['closed']."<br/>";
								
								
							}elseif ($key == "reopened") {
								$TestTicket['reopened'] = $val;
								echo $key." = ".$val." Setting TestTicket-reopened = ".$TestTicket['reopened']."<br/>";
							}
							
							
							$TestTicket['annulled'] = "0";
						
						}
						
					

						if ( isset($TestTicket['created']) ) {
							echo " Inserting created <br/>";
						#Created Dates	
						$admin->InsertThreadEvent ($Thread['id'], "1", $TestTicket['staff_id'], $TestTicket['team_id'], $TestTicket['dept_id'], $TestTicket['topic_id'], "NULL", $TestTicket['username'], $TestTicket['uid'], $TestTicket['uid_type'], $TestTicket['annulled'], $TestTicket['created'])	;
						}else{
							echo "skipping created <br/>";
						}

							if ( isset($TestTicket['closed']) ) {
							echo " Inserting closed <br/>";
						#closed Dates	
						$admin->InsertThreadEvent ($Thread['id'], "2", $TestTicket['staff_id'], $TestTicket['team_id'], $TestTicket['dept_id'], $TestTicket['topic_id'], "NULL", $TestTicket['username'], $TestTicket['uid'], $TestTicket['uid_type'], $TestTicket['annulled'], $TestTicket['closed'])	;
						}else{
							echo "skipping closed <br/>";
						}
						
						if ( isset($TestTicket['reopened']) ) {
							echo " Inserting reopened <br/>";
						#reopened Dates	
						$admin->InsertThreadEvent ($Thread['id'], "3", $TestTicket['staff_id'], $TestTicket['team_id'], $TestTicket['dept_id'], $TestTicket['topic_id'], "NULL", $TestTicket['username'], $TestTicket['uid'], $TestTicket['uid_type'], $TestTicket['annulled'], $TestTicket['reopened']);
						}else{
							echo "skipping reopened <br/>";
						}
					
					}
				?>
				
				
			</div>
		</div>

		
		
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    

  </body>
</html>