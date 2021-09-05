<?php
class ExhibitorComponent
{
    public $exhibitor_brands_array = [];
    // Display exhibitors data
    public function index($data, $atts = null)
    {
        $brands = 0;

        if (isset($atts['brands'])) {
            $brands = $atts['brands'];
        }

        $style_sheel_uri = get_stylesheet_directory_uri();

        $HTML = "";
        $FEATURED_HTML = '';
        $NON_FEATURED_HTML = '';
        $HTML = "<div class='exhibitor-listing order-md-12 col-md'>";

        for ($i = 0; $i < count($data['data']); $i++) {
            //Commented this code to diplay the exhibitor only once (not for each brand) by abdul latif

            /*if ($brands >= 1) {
            $count_bands = 0;
            if (isset($data['data'][$i]['brand']) && count($data['data'][$i]['brand']) > 0) {

            $count_bands = count($data['data'][$i]['brand']);
            for ($j = 0; $j < $count_bands; $j++) {
            $HTML = $HTML . $this->showExhibitorData($data['data'][$i], $data['data'][$i]['brand'][$j]);
            }
            } else {
            $HTML = $HTML . $this->showExhibitorData($data['data'][$i]);
            }
            } else {
            $HTML = $HTML . $this->showExhibitorData($data['data'][$i]);
            }*/
            $HTML = $HTML . $this->showExhibitorData($data['data'][$i]);
        }

        $sorted_array = $this->array_sort($this->exhibitor_brands_array, 'main_title', SORT_ASC);

        foreach ($sorted_array as $sorted_array_rec) {
            if ($sorted_array_rec['featured'] == 1) {
                if ($sorted_array_rec['catalog_name']) {
                    $FEATURED_HTML = $FEATURED_HTML . "
		 				<div class='exhibitor'>
                             <div class='position-relative'>
                                 <img src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/" . $sorted_array_rec['logo'] . "' alt='" . $sorted_array_rec['main_title'] . "' class='exhibitor__image'>
                             </div>";

                    $FEATURED_HTML = $FEATURED_HTML . "
						<div class='exhibitor__detail'>
                                 <h4 class='exhibitor__title'>" . $sorted_array_rec['main_title'] . $sorted_array_rec['featured_span'] . "</h4>
                                 <h5 class='exhibitor__location'>" . $sorted_array_rec['country'] . " | Stand No. " . $sorted_array_rec['booth_number'] . "</h5>

                                 <p class='exhibitor__summary'>" . $sorted_array_rec['short_profile'] . "</p>
		 						<a href='#exhibitorModal" . $sorted_array_rec['exhibitor_id'] . "' data-lity>Read More</a>
                                 <div class='exhibitor__categories'>

                                </div>

                             </div>
		 				</div>";

                    $FEATURED_HTML = $FEATURED_HTML . "<!--exhibitor modal-->
                        <div id='exhibitorModal" . $sorted_array_rec['exhibitor_id'] . "' class='lity-hide litymodal'>
                                <div class='speaker-wrapper'>
                                        <div class='position-relative'>
                                            <img src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/" . $sorted_array_rec['logo'] . "' alt='" . $sorted_array_rec['main_title'] . "' class='exhibitor__image bg-white mb-3'>
                                        </div>

                                        <h4 class='exhibitor__title'>" . $sorted_array_rec['catalog_name'] . " </h4><br>
                                        <h5 class='exhibitor__location'>" . $sorted_array_rec['country'] . " | Stand No. " . $sorted_array_rec['booth_number'] . "</h5>

                                        <p class='speaker-wrapper__desc'>" . $sorted_array_rec['profile'] . "</p>
                                </div>

                        </div><!--speaker modal - litty closing-->";

                }
            } else {
                if ($sorted_array_rec['catalog_name']) {
                    $NON_FEATURED_HTML = $NON_FEATURED_HTML . "
		 				<div class='exhibitor'>
                             <div class='position-relative'>
                                 <img src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/" . $sorted_array_rec['logo'] . "' alt='" . $sorted_array_rec['main_title'] . "' class='exhibitor__image'>
                             </div>";

                    $NON_FEATURED_HTML = $NON_FEATURED_HTML . "<div class='exhibitor__detail'>
                                 <h4 class='exhibitor__title'>" . $sorted_array_rec['main_title'] . $sorted_array_rec['featured_span'] . "</h4>
                                 <h5 class='exhibitor__location'>" . $sorted_array_rec['country'] . " | Stand No. " . $sorted_array_rec['booth_number'] . "</h5>

                                 <p class='exhibitor__summary'>" . $sorted_array_rec['short_profile'] . "</p>
		 						<a href='#exhibitorModal" . $sorted_array_rec['exhibitor_id'] . "' data-lity>Read More</a>
                                 <div class='exhibitor__categories'>

                                </div>

                             </div>
		 				</div>";

                    $NON_FEATURED_HTML = $NON_FEATURED_HTML . "<!--exhibitor modal-->
                        <div id='exhibitorModal" . $sorted_array_rec['exhibitor_id'] . "' class='lity-hide litymodal'>
                                <div class='speaker-wrapper'>
                                <div class='position-relative'>
                                            <img src='https://index-s3-images-static-content.s3.eu-west-1.amazonaws.com/" . $sorted_array_rec['logo'] . "' alt='" . $sorted_array_rec['main_title'] . "' class='exhibitor__image bg-white mb-3'>
                                        </div>

                                            <h4 class='exhibitor__title'>" . $sorted_array_rec['catalog_name'] . " </h4><br>
                                            <h5 class='exhibitor__location'>" . $sorted_array_rec['country'] . " | Stand No. " . $sorted_array_rec['booth_number'] . "</h5>
                                    <p class='speaker-wrapper__desc'>" . $sorted_array_rec['profile'] . "</p>
                                </div>
                        </div><!--speaker modal - litty closing-->";

                }
            }
        }

        $HTML = $HTML . $FEATURED_HTML . $NON_FEATURED_HTML;
        $HTML = $HTML . "</div>";
        return ($HTML);
    }

    public function showExhibitorData($data, $brand_data = null)
    {
        $exhibitor_data = [];
        $exhibitor_data['catalog_name'] = $data['catalog_name'];

        if ($brand_data) {
            //removed brand name & displaying only catalog name
            //$exhibitor_data['main_title'] = ucwords($brand_data['name']) . "/" . $data['catalog_name'];
            $exhibitor_data['main_title'] = ucwords($data['catalog_name']);
            $exhibitor_data['exhibitor_id'] = $data['exhibitor_id'] . $brand_data['id'];
        } else {
            $exhibitor_data['main_title'] = ucwords($data['catalog_name']);
            $exhibitor_data['exhibitor_id'] = $data['exhibitor_id'];
        }

        $exhibitor_data['logo'] = $data['logo'];
        $exhibitor_data['booth_number'] = $data['booth_number'];
        $exhibitor_data['country'] = $data['country'];

        $exhibitor_data['profile'] = $data['profile'];
        $exhibitor_data['short_profile'] = substr($data['profile'], 0, 300);
        $shortprofile_len = strlen($data['profile']);

        if ($shortprofile_len > 300) {
            $exhibitor_data['short_profile'] = $exhibitor_data['short_profile'] . " [...]";
        }

        if ($data['featured'] == 1) {
            $exhibitor_data['featured_span'] = '<span>Featured</span>';
        }

        $exhibitor_data['featured'] = $data['featured'];

        //commented to display exhibitor logo instead of brand logo
        /*if ($brand_data) {
        $brand_image = $brand_data['image'];
        $pathinfo = pathinfo($brand_image);
        $brand_image_ext = $pathinfo['extension'];

        if ($brand_image) {
        if ($brand_image_ext !== 'pdf') {
        $exhibitor_data['logo'] = $brand_image;
        } else {
        $exhibitor_data['logo'] = $data['logo'];
        }
        } else {
        $exhibitor_data['logo'] = $data['logo'];
        }
        } else {
        $exhibitor_data['logo'] = $data['logo'];
        }*/

        $this->exhibitor_brands_array[] = $exhibitor_data;
    }

    public function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}