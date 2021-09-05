<?php 
class guestToken{
    public $data;
    public $url;

    public function __construct($access_key, $hash_key, $app_edition_id, $url){
        $this->data = array(
            'access_key' => $access_key,
            'hash_key' => $hash_key,
            'app_edition_id' => $app_edition_id,
            'device_id' => 'fc53f7643e07d8cc',
        );
        $this->url = $url;
    }

    public function sendToket(){
        $payload = json_encode($this->data);
         
        // Prepare new cURL resource
        $ch = curl_init("https://$this->url/authenticate_guest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = json_decode(curl_exec($ch));
        // Close cURL session handle
        curl_close($ch);
        
        return($result->token);
    }
}