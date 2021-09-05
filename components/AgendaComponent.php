<?php
class AgendaComponent
{
    public $rolesArr;
    public $rolesLabel; 

    // Defining Roles Array
    public function __construct($rolesArr, $rolesLabel)
    {
        $this->rolesArr = $rolesArr;
        $this->rolesLabel = $rolesLabel;
    }
	
    // Display sessions data
	
    function index($data, $atts){
        
        if(isset($atts['show_session_speakers'])){
            $show_session_speakers = $atts['show_session_speakers'];
        }

        $HTML = '';
        $roles = $data['roles'];
		$New_time_zone = $data['time_zone'];
        $itemName = $data['items'][0]['name'];
        $sessions = $data['items'][0]['sessions'];
		
            
            $HTML = $HTML . '<div>';
		
        
			for ($i=0; $i < count($sessions); $i++) { 
				
				//echo "<pre>";
				//print_r($sessions);
				
				//exit();

			$HTML = $HTML . '<!-- session start -->
							<div class="card-custom card-custom-session">
							<div class="card-custom-session__heading">
							<div class="card-custom-session__wrapper">';
				
			$HTML = $HTML . '<h5 class="card-custom-session__title '.$class_bold.'">'.$sessions[$i]['name'].'</h5>';

						$HTML = $HTML . '<div class="card-custom-session__speakers">';

									if($show_session_speakers == 'yes'){
									$HTML = $HTML . $this->sessionSpeakers($sessions[$i]['speakers']);
									}

						$HTML = $HTML . '</div>';
				
				
				if($sessions[$i]['break']=='1'){
				$class_bold ="no_bold";
				$HTML = $HTML . '<div class="card-custom-session__time"><h4><i class="far fa-clock"></i>&nbsp; '.$this->returnTime($sessions[$i]['starttime']).' - '.$this->returnTime($sessions[$i]['endtime']).'</h4></div>';
				}else{
				$class_bold ="";
				}

					

					if (isset($sessions[$i]['lectures'])) {
					$HTML = $HTML . $this->getLectures($sessions[$i]['lectures']);
					}
				
				//$HTML = $HTML . '';

			$HTML = $HTML . '
			</div><!-- session__heading end -->
			</div><!-- session__heading end -->
			</div><!-- custom-session end -->';
} 

		$HTML = $HTML . '</div><!-- Extra Div end -->';
        
            return($HTML);
    }
	
	

    // Fetch lectures for session
    function getLectures($lectures){
		
		
        $HTML = '';
		
        for ($i=0; $i < count($lectures); $i++) { 

            $HTML = $HTML . '<div class="card-custom card-custom-agenda">
								<div class="card-custom-agenda__details">';
							  
            $HTML = $HTML . '<h5 class="card-custom-agenda__title">'.$lectures[$i]['name'].'</h5>';
			
			$HTML = $HTML . '<div class="card-custom-agenda__speakers">';
            
            if(isset($lectures[$i]['speakers'])){
                $HTML = $HTML . $this->getSpeakers($lectures[$i]['speakers']);
            }
			
            $HTML = $HTML . '</div></div>';
			$HTML = $HTML . '<div class="card-custom-agenda__time"><h4><i class="far fa-clock"></i>&nbsp; '.$this->returnTime($lectures[$i]['starttime']).' - '.$this->returnTime($lectures[$i]['endtime']).'</h4></div>';
			
            $HTML = $HTML . '     </div><!-- card-custom-agenda -->';
        } 

        return($HTML);
    }

    // Show data of speaker
    function getSpeakers($speakers, $roles = ''){
        $HTML = '';

        for ($i=0; $i < count($speakers); $i++) {
            $speaker_id = $speakers[$i]['speaker_id'];
            $speaker_role_id = $speakers[$i]['speaker_role_id'];
			
			
			$speaker_sessions = $speakers[$i]['sessions'];
			$speaker_lectures = $speakers[$i]['lectures'];
            
			
            if($i>0){
                $seperator = ",";
            }else{
                $seperator ="";
            }
            
            if(!empty($roles)){
                $roleName = $this->speakerRole($speaker_role_id, $roles);
            }
            
            $HTML = $HTML. "<span>".$roleName."</span>";
            $HTML = $HTML. "<p class='card-custom-agenda__speaker'>
			<a href='#speakerModal".$speaker_id."' data-lity>".$speakers[$i]['first_name']." ".$speakers[$i]['last_name']."&nbsp;|&nbsp;<small>".$speakers[$i]['title']."</small></a></p>";	
           
			$HTML = $HTML ."<!--speaker modal-->
			<div id='speakerModal".$speaker_id."' class='lity-hide litymodal'>

					<div class='speaker-wrapper'>
					
					<div class ='speaker-wrapper__heading'>
					<img class='speaker-wrapper__img' src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/".$speakers[$i]['image']."' alt='".$speakers[$i]['first_name']."'>
						
						<div class ='speaker-wrapper__subdetails'>
						<h5 class='speaker-wrapper__name'>".$speakers[$i]['first_name']." ".$speakers[$i]['last_name']."</h5>
						<h6 class='speaker-wrapper__title'>".$speakers[$i]['title']."</span> <span class='ehome_speaker_country' style='display:none;'>| ".$speakers[$i]['country']['country']."</h6>
						</div>
					</div>
						<p class='speaker-wrapper__desc'>".$speakers[$i]['bio']."</p>
					</div>";
					
			if($speaker_sessions){
					
					$HTML = $HTML ."<div class='sessions'>
						<h5 class='sessions__title'>Sessions by this speaker</h5>
						";
				
		 
				for($j = 0; $j<count($speaker_sessions); $j++){

			$HTML = $HTML ."
			<h6 class='sessions__day'>".$this->returnDay($speaker_sessions[$j]['starttime']).", ".$this->returnDate($speaker_sessions[$j]['starttime'])."</h6>

			<div class='card-custom card-custom-agenda'>
				<div class='card-custom-agenda__details'>
					<h5 class='card-custom-agenda__title'>".$speaker_sessions[$j]['name']."</h5>
				</div>
				
				<div class='card-custom-agenda__time'>
				<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($speaker_sessions[$j]['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($speaker_sessions[$j]['endtime']))."</h4>
				</div>
			</div>";
		 
	 		}
		

					$HTML = $HTML ."</div>";
					
					}
			
			if($speaker_lectures){
					
					$HTML = $HTML ."<div class='sessions'>
						<h5 class='sessions__title'>Lectures by this speaker</h5>
						";
		 
				 for($x = 0; $x<count($speaker_lectures); $x++){

					
					 
					

						$HTML = $HTML ."
						<h6 class='sessions__day'>".$this->returnDay($speaker_lectures[$x]['starttime']).", ".$this->returnDate($speaker_lectures[$x]['starttime'])."</h6>
						
						<div class='card-custom card-custom-agenda'>
							<div class='card-custom-agenda__details'>
								<h5 class='card-custom-agenda__title'>".$speaker_lectures[$x]['name']."</h5>
							</div>
							<div class='card-custom-agenda__time'>
							<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($speaker_lectures[$x]['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($speaker_lectures[$x]['endtime']))."</h4>
							</div>
						</div>";
		 
						
	 		}
		

					$HTML = $HTML ."</div>";
					
					}
			
				$HTML = $HTML ."</div><!--speaker modal - litty closing-->";
		}
        return($HTML);
    }
	

    // // Show data of speaker from session
    function sessionSpeakers($speakers){
        $HTML = '';
        $rolesArray = $this->rolesArr;
        $rolesLabel = $this->rolesLabel;
		
			
		
		
        for ($j=0; $j < count($rolesArray); $j++) { 
            

            if(!empty($speakers)){
                usort($speakers, function($a, $b) {
                    return $a['first_name'] - $b['first_name'];
                });
            }
			
                
            for ($i=0; $i < count($speakers); $i++) {
				$SpeakerHTML = '';
				
				$speaker_sessions = $speakers[$i]['sessions'];
				$speaker_lectures = $speakers[$i]['lectures'];
				
				if($i>0){
					$seperator = ",";
				}else{
					$seperator ="";
				}
                
                $speaker_id = $speakers[$i]['speaker_id'];
                $speaker_role_id = $speakers[$i]['speaker_role_id'];
				$role_value = $rolesArray[$j];
				

                if($role_value == $speaker_role_id){
                    $SpeakerHTML = $SpeakerHTML. "<p class='card-custom-session__speaker'><a href='#speakerModal".$speaker_id."' data-lity>".$speakers[$i]['first_name']." ".$speakers[$i]['last_name']."&nbsp;|&nbsp;<small>".$speakers[$i]['title']."</small></a></p>";
					
					
					
					$SpeakerHTML = $SpeakerHTML ."<!--speaker modal-->
												<div id='speakerModal".$speaker_id."' class='lity-hide litymodal'>

														<div class='speaker-wrapper'>
														
														<div class ='speaker-wrapper__heading'>
														<img class='speaker-wrapper__img' src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/".$speakers[$i]['image']."' alt='".$speakers[$i]['first_name']."'>
															
															<div class ='speaker-wrapper__subdetails'>
																<h5 class='speaker-wrapper__name'>".$speakers[$i]['first_name']." ".$speakers[$i]['last_name']."</h5>
																<h6 class='speaker-wrapper__title'>".$speakers[$i]['title']."</span> <span class='ehome_speaker_country'>| ".$speakers[$i]['country']['country']."</h6>
															</div>
														</div>
															<p class='speaker-wrapper__desc'>".$speakers[$i]['bio']."</p>

														</div>";

					
							if($speaker_sessions){
									
									$SpeakerHTML = $SpeakerHTML ."<div class='sessions'>
										<h5 class='sessions__title'>Sessions by this speaker</h5>
										";
								for($k = 0; $k<count($speaker_sessions); $k++){
										$SpeakerHTML = $SpeakerHTML ."
										<h6 class='sessions__day'>".$this->returnDay($speaker_sessions['starttime']).", ".$this->returnDate($speaker_sessions['starttime'])."</h6>
										
										<div class='card-custom card-custom-agenda'>
											<div class='card-custom-agenda__details'>
												<h5 class='card-custom-agenda__title'>".$speaker_sessions['name']."</h5>
											</div>
											<div class='card-custom-agenda__time'>

											

											<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($speaker_sessions['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($speaker_sessions['endtime']))."</h4>
											</div>
										</div>";
						
								}
									$SpeakerHTML = $SpeakerHTML ."</div>";
									
									}


						
							if($speaker_lectures){
									
									$SpeakerHTML = $SpeakerHTML ."<div class='sessions'>
										<h5 class='sessions__title'>Lectures by this speaker</h5>
										";
						
								for($x = 0; $x<count($speaker_lectures); $x++){

										$SpeakerHTML = $SpeakerHTML ."
										<h6 class='sessions__day'>".$this->returnDay($speaker_lectures['starttime']).", ".$this->returnDate($speaker_lectures['starttime'])."</h6>
										
										<div class='card-custom card-custom-agenda'>
											<div class='card-custom-agenda__details'>
												<h5 class='card-custom-agenda__title'>".$speaker_lectures['name']."</h5>
											</div>

											
											<div class='card-custom-agenda__time'>
											<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($speaker_lectures['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($speaker_lectures['endtime']))."</h4>
											</div>
										</div>";
						
						
									}
						

									$SpeakerHTML = $SpeakerHTML ."</div>";
									
									}
									

						$SpeakerHTML = $SpeakerHTML ."	</div><!--speaker modal - litty closing-->

							";	
	
                }

				if($SpeakerHTML != ''){
					$HTML = $HTML."<span>".$speakers[$i]['role'].": </span>";
					$HTML = $HTML.$SpeakerHTML."<br />";
				}
            }
//			echo "++";
        }

        return($HTML);
    }

    // Return time from date
    function returnTime($date){
        $time = explode(" ",$date);
        $time = substr($time[1],0, -3);
        return($time);
    }
	
	// Return Date from date
	function returnDate($date){
        $Newdate = explode(" ",$date);
        $Newdate = substr($Newdate[0],0, 10);
        return($Newdate);
    }
	
	// Return Day from date
	function returnDay($date){
		$Newddate = explode(" ",$date);
        $Newddate = substr($Newddate[0],0, 10);
		//$day = date('l', $Newdate);
		$day = date("l", strtotime($Newddate));
        return($day);
    }

    // Return Speaker Role
    public function speakerRole($speakerRoleId, $roles){
        for ($i=0; $i < count($roles); $i++) { 
            if($roles[$i]['id'] == $speakerRoleId){
                return($roles[$i]['name']);
            }
        }
    }


    // Sort Speaker Alphabetically
    function compareByName($a, $b) {
        return strcmp($a["first_name"], $b["first_name"]);
    }


	function convert_to_timezone($ssn_time)
	{
		$converted_time = new DateTime($ssn_time, new DateTimeZone('Asia/Dubai'));

		
		//$converted_time->setTimezone(new DateTimeZone($New_time_zone));
		$converted_time->setTimezone(new DateTimeZone('Asia/Singapore'));
		$final_time = $converted_time->format('H:i');
		return ($final_time);
	}
}