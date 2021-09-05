<?php

class SpeakerComponent

{

    // Display sessions data

    public function index($data){

        

        $HTML = "";
		
       
        $HTML = "<!--speaker listing wrap open-->
		<div class='speaker-listing mt-5'>";

        for($i = 0; $i<count($data['data']); $i++){
			
			$sessions = $data['data'][$i]['sessions'];
			$lectures = $data['data'][$i]['lectures'];
			
			$img_asset_path = get_stylesheet_directory_uri(); 
            $shortbio = substr($data['data'][$i]['bio'], 0, 500);
			$speaker_id = $data['data'][$i]['speaker_id'];
            $shortbio_len = strlen($data['data'][$i]['bio']);
            if($shortbio_len > 500){
                $shortbio = $shortbio." [...]";
            }

            $HTML = $HTML ."<!--speaker listing wrap open-->
				<div class='speaker-card'>
			
						<a href='#speakerModal".$speaker_id."' data-lity>
                            <img class='speaker__img' src='".$data['data'][$i]['image']."' alt='".$data['data'][$i]['first_name']."'>
							
                            <h4 class='speaker__name'>".$data['data'][$i]['first_name']." ".$data['data'][$i]['last_name']." <img src='".plugin_dir_url( __DIR__ )."assets".$data['data'][$i]['country']['flag_image']."' alt='Flag' width='30px' style='float:right;display:none;' /></h4>
							
                            <p class='speaker__title'>".$data['data'][$i]['title']."</span> <span class='ehome_speaker_country'>| ".$data['data'][$i]['country']['country']."</p>
                        </a>
						
			<!--speaker modal-->
		
			<div id='speakerModal".$speaker_id."' class='lity-hide litymodal'>

					<div class='speaker-wrapper'>
					
					<div class ='speaker-wrapper__heading'>
					<img class='speaker-wrapper__img' src='".$data['data'][$i]['image']."' alt='".$data['data'][$i]['first_name']."'>
						
						<div class ='speaker-wrapper__subdetails'>
						<h5 class='speaker-wrapper__name'>".$data['data'][$i]['first_name']." ".$data['data'][$i]['last_name']."</h5>
						<img src='".plugin_dir_url( __DIR__ )."assets".$data['data'][$i]['country']['flag_image']."' alt='Flag' width='30px' style='margin-left:25px;display:none;' />
						<h6 class='speaker-wrapper__title'>".$data['data'][$i]['title']."</span> <span class='ehome_speaker_country' style='display:none;'> | ".$data['data'][$i]['country']['country']." </span></h6>
						</div>
					</div>
						<p class='speaker-wrapper__desc'>".$data['data'][$i]['bio']."</p>

					</div>			
					";
			//if($sessions || $lectures){
			if($sessions){
					
					$HTML = $HTML ."<div class='sessions'>
						<h5 class='sessions__title'>Sessions by this speaker</h5>
						";
				
		 
				for($j = 0; $j<count($sessions); $j++){

						$HTML = $HTML ."
						<h6 class='sessions__day'>".$this->returnDay($sessions[$j]['starttime']).", ".$this->returnDate($sessions[$j]['starttime'])."</h6>
						
						<div class='card-custom card-custom-agenda'>
							<div class='card-custom-agenda__details'>
								<h5 class='card-custom-agenda__title'>".$sessions[$j]['name']."</h5>
							</div>
							<div class='card-custom-agenda__time'>
							<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($sessions[$j]['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($sessions[$j]['endtime']))."</h4>
							</div>
						</div>";
		 
		 
	 		}
		

					$HTML = $HTML ."</div>";
					
					}
			
			if($lectures){
					
					$HTML = $HTML ."<div class='sessions'>
						<h5 class='sessions__title'>Lectures by this speaker</h5>
						";
		 
				 for($x = 0; $x<count($lectures); $x++){

						$HTML = $HTML ."
						<h6 class='sessions__day'>".$this->returnDay($lectures[$x]['starttime']).", ".$this->returnDate($lectures[$x]['starttime'])."</h6>
						
						<div class='card-custom card-custom-agenda'>
							<div class='card-custom-agenda__details'>
								<h5 class='card-custom-agenda__title'>".$lectures[$x]['name']."</h5>
							</div>
							<div class='card-custom-agenda__time'>
							<h4><i class='far fa-clock'></i>&nbsp; ".$this->convert_to_timezone($this->returnTime($lectures[$x]['starttime'])).' - '.$this->convert_to_timezone($this->returnTime($lectures[$x]['endtime']))."</h4>
							</div>
						</div>";
		 
		 
	 		}
		

					$HTML = $HTML ."</div>";
					
					}

$HTML = $HTML ."
			</div><!--speaker modal - litty closing-->
	
                            </div>
							<!--speaker card closing-->";  
        }
        $HTML =  $HTML ."</div><!--speaker listing wrap closing-->";
		
        return ($HTML);

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
		$day = date("l", strtotime($Newddate));
        return($day);
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