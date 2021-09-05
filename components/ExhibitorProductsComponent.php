<?php

class ExhibitorProductsComponent
{
    // Display sessions data
    public function index($data){
		
		//print_r($data);

        $HTML = "";
        $HTML = "<!--speaker listing wrap open-->
		<div class='speaker-listing  mt-5'>";
                for($i = 0; $i<count($data['data']); $i++){
		
		$product_photo = $data['data'][$i]['product_images'][0]['path'];		
		if($product_photo){
			
			$photo = "https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/".$product_photo;
		}else{
			$photo = get_stylesheet_directory_uri().'/assets/img/product-photo.jpg';
		}
		
					
					
		$product_id =  $data['data'][$i]['exhibitor_product_id'];			
		
		$HTML = $HTML ."<!--speaker card wrap open-->
						<div class='speaker-card'>
						
							<a href='#productModal".$product_id."' data-lity>
								<img class='speaker__img' src='".$photo."' alt='".$data['data'][$i]['name']."'>
								
								<h4 class='speaker__name'>".$data['data'][$i]['name']."</h4>
								
								<p class='speaker__title'>".$data['data'][$i]['exhibitor']['catalog_name']."</p>
							</a>
					
			
			<!--speaker modal-->
		
			<div id='productModal".$product_id."' class='lity-hide litymodal'>

					<div class='speaker-wrapper'>
					
					<div class ='speaker-wrapper__heading'>
					<img class='speaker-wrapper__img' src='".$photo."' alt='".$data['data'][$i]['name']."'>
						
						<div class ='speaker-wrapper__subdetails'>
						
						<h5 class='speaker-wrapper__name'>".$data['data'][$i]['name']."</h5>

						<h6 class='speaker-wrapper__title'>".$data['data'][$i]['exhibitor']['catalog_name']."</h6>
						
						</div>
					</div>
						<p class='speaker-wrapper__desc'>".$data['data'][$i]['description']."</p>

					</div>
		
			</div><!--speaker modal - litty closing-->
			
                            </div>
							<!--speaker card closing-->"; 
		}
		$HTML =  $HTML ."</div>";
        return ($HTML);
    }
}