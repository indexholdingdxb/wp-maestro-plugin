<?php
class AbstractComponent
{
    public function index($data){
        $HTML = "";
        $HTML = "<div class='maestro_ehome_speaker paginate-no-scroll 5'>
                    <div class='container items'>";

                        for($i = 0; $i<count($data['data']); $i++){

                            $shortbio = substr($data['data'][$i]['description'], 0, 500);
                            $abstract_id = $data['data'][$i]['abstract_id'];
                            $shortbio_len = strlen($data['data'][$i]['description']);

                            if($shortbio_len > 500){
                                $shortbio = $shortbio." [...]";
                            }

                            $HTML = $HTML ."<div class='speaker_box row'>
                                                <div class='box-left col-md-2'><img class='ehome_speaker_image' src='".$data['data'][$i]['thumbnail']."' alt='' width='150' height='150'></div>

                                                <div class='box-right col-md-10'>
                                                    <span class='ehome_speaker_title'>".$data['data'][$i]['title']."</span><br>
                                                    <p>".$data['data'][$i]['authors']."</p>
                                                    <p class='ehome_speaker_bio'>".$shortbio."</p> 
                                                    <a class='btn btn-info' href='".$data['data'][$i]['link']."' data-featherlight='#mylightbox".$abstract_id."'>Read More</a>
                                                    
                                                    <div id='mylightbox".$abstract_id."' class='modalbox row'>
                                                        <div class='container'>
                                                            <div class='row'>
                                                                <div class='box-left col-md-4'>
                                                                    <img class='ehome_speaker_image' src='".$data['data'][$i]['thumbnail']."' alt='' width='125' height='125'>
                                                                </div>

                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <p class='ehome_speaker_bio'>".$data['data'][$i]['description']."</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                        }

        $HTML =  $HTML ."</div>";
		
		$HTML =  $HTML ."<div class='pager'>
				<div class='firstPage'>&laquo;</div>
				<div class='previousPage'>&lsaquo;</div>
				<div class='pageNumbers'></div>
				<div class='nextPage'>&rsaquo;</div>
				<div class='lastPage'>&raquo;</div>
			</div>";
		
		$HTML =  $HTML ."</div>";

        return ($HTML);

    }

}