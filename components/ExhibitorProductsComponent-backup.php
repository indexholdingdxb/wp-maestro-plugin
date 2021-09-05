<?php

class ExhibitorProductsComponent
{
    // Display sessions data
    public function index($data){
		
		print_r($data);
		
		
		$product_id = $data['data'][$i]['exhibitor_product_id'];

        $HTML = "";
        $HTML = "<div class='speaker-listing mt-5'>";

                for($i = 0; $i<count($data['data']); $i++){
		
		$HTML = $HTML ."
						<div class='speaker-card'> 
						
							<a href='#speakerModal".$speaker_id."' data-lity>
								<img class='speaker__img' src='".$data['data'][$i]['image']."' alt='".$data['data'][$i]['name']."'>

								<h4 class='speaker__name'>".$data['data'][$i]['name']."</h4>

								<p class='speaker__title'>".$data['data'][$i]['title']."</span> <span class='ehome_speaker_country'>| ".$data['data'][$i]['country']['country']."</p>
							</a>
                            
							";
			
			
			$HTML = $HTML ."<div class='exhibitor__detail'>
                                <h4 class='exhibitor__title'></h4>
                                <h5 class='exhibitor__location'>".$data['country']." | Stand No. ".$data['booth_number']."</h5> 

                                <p class='exhibitor__summary'>".$data['data'][$i]['name']."</p>
								<a href='#exhibitorModal".$product_id."' data-lity>Read More</a>
                                <div class='exhibitor__categories'>
                                    <span>Machinery</span>
                                    <span>Machinery</span>
                                </div>

                            </div>
						</div>";
					
					
					
					$HTML = $HTML ."<!--exhibitor modal-->
		
			<!--speaker modal-->
		
			<div id='speakerModal".$speaker_id."' class='lity-hide speakermodal'>

					<div class='speaker-wrapper'>
					
					<div class ='speaker-wrapper__heading'>
					<img class='speaker-wrapper__img' src='".$data['data'][$i]['image']."' alt='".$data['data'][$i]['first_name']."'>
						
						<div class ='speaker-wrapper__subdetails'>
						<h5 class='speaker-wrapper__name'>".$data['data'][$i]['salutation']." ".$data['data'][$i]['first_name']." ".$data['data'][$i]['last_name']."</h5>
						<img src='".plugin_dir_url( __DIR__ )."assets".$data['data'][$i]['country']['flag_image']."' alt='Flag' width='30px' style='margin-left:25px;' />
						<h6 class='speaker-wrapper__title'>".$data['data'][$i]['title']."</span> <span class='ehome_speaker_country' style='display:none;'> | ".$data['data'][$i]['country']['country']." </span></h6>
						</div>
					</div>
						<p class='speaker-wrapper__desc'>".$data['data'][$i]['bio']."</p>

					</div>			
					";
		
		 }
		
		
		$HTML =  $HTML ."</div></div>";
        return ($HTML);
    }
}