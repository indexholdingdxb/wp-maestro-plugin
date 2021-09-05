<?php require_once('getToken.php');
class maestroDB{
    public function insertDB($formData){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_app_setting";
        $url = $_POST['url'];
        $access_key = $_POST['access_key'];
        $hash_key = $_POST['hash_key'];
        $event_id = $_POST['event_id'];
        $edition_id = $_POST['edition_id'];
        $app_edition_id = $_POST['app_edition_id'];

        $getToken = new guestToken($access_key, $hash_key, $app_edition_id, $url);
        
        $success = $wpdb->insert($table_name, array(
            "url" => $url,
            "access_key" => $access_key,
            "hash_key" => $hash_key,
            "event_id" => $event_id,
            "edition_id" => $edition_id,
            "app_edition_id" => $app_edition_id,
            "token" => $getToken->sendToket(),
        ));
        
    
        if($success) {
            echo ' Inserted successfully';
        } else {
            echo 'not';
        }   
    }

    public function insertSpakerRolesDB($formData){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_speaker_roles";
        $nameId = explode("***",$_POST['name']);
        $name = $nameId[1];
        $speaker_role_id = $nameId[0];
        $order_number = $_POST['order_number'];
        
        $success = $wpdb->insert($table_name, array(
            "name" => $name,
            "speaker_role_id" => $speaker_role_id,
            "order_number" => $order_number,
        ));
        
        if($success) {
            echo 'Inserted successfully';
        } else {
            echo 'Some thing went wrong, please try again';
        }   
    }

    public function showRecords(){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_speaker_roles";
        $settings = $wpdb->get_results("SELECT * FROM $table_name ORDER BY `order_number` ASC");
                
        $HTML = '<h1 class="wp-heading-inline">Settings</h1>';
        $HTML = $HTML . '<table  class="wp-list-table widefat fixed striped posts">';
        $HTML = $HTML . '<thead>';
        $HTML = $HTML . '<th scope="col" id="categories" class="manage-column column-categories">Order Number</th>';
        $HTML = $HTML . '<th scope="col" id="author" class="manage-column column-author">Name</th>';
        $HTML = $HTML . '<th scope="col" id="categories" class="manage-column column-categories">Speaker Role Id</th>';
        $HTML = $HTML . '<th scope="col" id="categories" class="manage-column column-categories">Action</th>';
        $HTML = $HTML . '</thead>';
        foreach($settings as $setting){ 
                $HTML = $HTML . '<tr>';
                $HTML = $HTML . '<td>'. $setting->order_number .'</td>';
                $HTML = $HTML . '<td>'. $setting->name .'</td>';
                $HTML = $HTML . '<td>'. $setting->speaker_role_id .'</td>';
                $HTML = $HTML . '<td><a href="?page=add-maestro-seesion-rolse&action=delete&id='.$setting->ID.'">Delete</a></td>';
                $HTML = $HTML . '</tr>';
        } 
        $HTML = $HTML . '</table>';
        return($HTML);
    }

    public function fetchRoles(){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_speaker_roles";
        $settings = $wpdb->get_results("SELECT * FROM $table_name ORDER BY `order_number` ASC");
        $rolesArray = [];
        $rolesLabel = [];
                
        foreach($settings as $setting){ 
            array_push($rolesArray,$setting->speaker_role_id);
            array_push($rolesLabel,$setting->name);
        } 
        return(array($rolesArray, $rolesLabel));
    }

    public function showSingleRecord(){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_app_setting";
        $settings = $wpdb->get_row("SELECT * FROM $table_name ORDER BY `ID`  DESC");
        
        return($settings);
    }


    public function getDefultCredentials($atts = ''){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_app_setting";
        $settings = $wpdb->get_row("SELECT * FROM $table_name ORDER BY `ID`  DESC");
        
        if(isset($atts['event_id'])){
            $event_id = $atts['event_id'];
        }else{
            $event_id = $settings->event_id;
        }

        if(isset($atts['edition_id'])){
            $edition_id = $atts['edition_id'];
        }else{
            $edition_id = $settings->edition_id;
        }

        return(['apiCredentials' => $settings, 'event_id' => $event_id, 'edition_id' => $edition_id]);
    }

   

    public function showSpeakers($atts){
        $curl = curl_init();
        $defultCredentials = $this->getDefultCredentials($atts);
        $apiCredentials = $defultCredentials['apiCredentials'];
        $event_id = $defultCredentials['event_id'];
        $edition_id = $defultCredentials['edition_id'];

        $url = "https://$apiCredentials->url/speakers?event=$event_id&edition=$edition_id&token=$apiCredentials->token";

        if(isset($atts['item_id'])){
            $item_id = $atts['item_id'];
            $url = $url."&item_id=$item_id";
        }

        if(isset($atts['session_location_id'])){
            $session_location_id = $atts['session_location_id'];
            $url = $url."&session_location_id=$session_location_id";
        }

        if(isset($atts['role_id'])){
            $role_id = $atts['role_id'];
            $url = $url."&role_id=$role_id";
        }

        if(isset($atts['featured'])){
            $featured = $atts['featured'];
            $url = $url."&featured=$featured";
        }

        if(isset($atts['limit'])){
            $limit = $atts['limit'];
            $url = $url."&limit=$limit";
        }
		
		  if(isset($atts['order_by'])){
            $order_by = $atts['order_by'];
            $url = $url."&order_by=$order_by";
        }


        $response = $this->curl($curl, $url, $apiCredentials->url, $apiCredentials->token);

        $data =  json_decode($response, true);
        
        if($data['status_code'] == 401){
            $token = $this->update();            
            $response = $this->curl($curl, $url, $apiCredentials->url, $token);
            $data =  json_decode($response, true);
        } 
        
        curl_close($curl);     
            
        return($data);
    }

       public function showExhibitorProducts($atts){
        $curl = curl_init();
        $defultCredentials = $this->getDefultCredentials($atts);
        $apiCredentials = $defultCredentials['apiCredentials'];
        $event_id = $defultCredentials['event_id'];
        $edition_id = $defultCredentials['edition_id'];

        $url = "https://$apiCredentials->url/products?event=$event_id&edition=$edition_id&token=$apiCredentials->token";

        if(isset($atts['featured'])){
            $featured = $atts['featured'];
            $url = $url."&featured=$featured";
        }

        if(isset($atts['limit'])){
            $limit = $atts['limit'];
            $url = $url."&limit=$limit";
        }

        $response = $this->curl($curl, $url, $apiCredentials->url, $apiCredentials->token);

        $data =  json_decode($response, true);
        
        if($data['status_code'] == 401){
            $token = $this->update();            
            $response = $this->curl($curl, $url, $apiCredentials->url, $token);
            $data =  json_decode($response, true);
        } 
        
        curl_close($curl); 
        
        return($data);
    }
	
	
	
	
	public function showAbstracts($atts){
        
        $curl = curl_init();
        $defultCredentials = $this->getDefultCredentials($atts);
        $apiCredentials = $defultCredentials['apiCredentials'];
        $event_id = $defultCredentials['event_id'];
        $edition_id = $defultCredentials['edition_id'];

        $url = "https://$apiCredentials->url/abstracts?event=$event_id&edition=$edition_id&token=$apiCredentials->token";
        if(isset($atts['item_id'])){
            $abstract_type_id = $atts['item_id'];
            $url = $url."&abstract_type_id=$abstract_type_id";
        }


        // if(isset($atts['session_location_id'])){
        //     $session_location_id = $atts['session_location_id'];
        //     $url = $url."&session_location_id=$session_location_id";
        // }

        // if(isset($atts['role_id'])){
        //     $role_id = $atts['role_id'];
        //     $url = $url."&role_id=$role_id";
        // }

        $response = $this->curl($curl, $url, $apiCredentials->url, $apiCredentials->token);

        $data =  json_decode($response, true);
        
        if($data['status_code'] == 401){
            $token = $this->update();            
            $response = $this->curl($curl, $url, $apiCredentials->url, $token);
            $data =  json_decode($response, true);
        } 
        
        curl_close($curl);     
            
        return($data);
    }

    public function getSessions($atts = ''){
        $curl = curl_init();

        $defultCredentials = $this->getDefultCredentials($atts);
        $apiCredentials = $defultCredentials['apiCredentials'];
        $event_id = $defultCredentials['event_id'];
        $edition_id = $defultCredentials['edition_id'];

        $url = "https://$apiCredentials->url/item_sessions?event=$event_id&edition=$edition_id";

        if(isset($atts['item_id'])){
            $item_id = $atts['item_id'];
            $url = $url."&item_id=$item_id";
        }

        if(isset($atts['session_location_id'])){
            $session_location_id = $atts['session_location_id'];
            $url = $url."&lecture_location_id=$session_location_id";
        }

        if(isset($atts['date_from'])){
            $date_from = $atts['date_from'];
            $date_to = $atts['date_to'];
            $url = $url."&date_from=$date_from&date_to=$date_to";
        }

        if(isset($atts['featured'])){
            $featured = $atts['featured'];
            $url = $url."&featured=$featured";
        }

        $response = $this->curl($curl, $url, $apiCredentials->url, $apiCredentials->token);

        $data =  json_decode($response, true);
        
        if($data['status_code'] == 401){
            $token = $this->update();            
            $response = $this->curl($curl, $url, $apiCredentials->url, $token);
            $data =  json_decode($response, true);
        } 
        
        curl_close($curl);     
            
        return($data);
    }

    public function getExhibitors($atts = ''){
        $curl = curl_init();
        $apiCredentials = $this->showSingleRecord();

        $url = "https://$apiCredentials->url/exhibitors?event=$apiCredentials->event_id&edition=$apiCredentials->edition_id&token=$apiCredentials->token";
        
        if(isset($atts['featured'])){
            $featured = $atts['featured'];
            $url = $url."&featured=$featured";
        }

        if(isset($atts['limit'])){
            $limit = $atts['limit'];
            $url = $url."&limit=$limit";
        }

        if(isset($atts['brands'])){
            $brands = $atts['brands'];
            $url = $url."&brands=$brands";
        }

        $response = $this->curl($curl, $url, $apiCredentials->url, $apiCredentials->token);

        $data =  json_decode($response, true);
        
        if($data['status_code'] == 401){
            $token = $this->update();            
            $response = $this->curl($curl, $url, $apiCredentials->url, $token);
            $data =  json_decode($response, true);
        } 
        
        curl_close($curl);     
            
        return($data);
    }

    public function update(){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_app_setting";
        $apiCredentials = $this->showSingleRecord();
        $getToken = new guestToken($apiCredentials->access_key, $apiCredentials->hash_key, $apiCredentials->app_edition_id, $apiCredentials->url);
        $data = array("token" => $getToken->sendToket());
        if($wpdb->update( $table_name, $data, array( 'ID' => $apiCredentials->ID ), $format = null, $where_format = null ));
            return($getToken->sendToket());
    }

    public function deleteRec($id){
        global $wpdb;
        $table_name = $wpdb->prefix . "maestro_speaker_roles";

        if($wpdb->query("DELETE  FROM $table_name WHERE id = $id "))
            echo "Record Delete Successfully";
        else
            echo "Some thing went wrong, please try again";
    }

    public function curl($curl, $url, $apiUrl, $token){
        if(isset($token)){
            $url = $url."&token=$token";
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Content-Type: application/json",
                    "Host: $apiUrl",
                    "accept-encoding: gzip, deflate",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            return($response);
    }
}