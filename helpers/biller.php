<?php
class Biller {
    private $users = [];
    private static $biller = null;


    public static function getInstance(){
        if(self::$biller == null){
            self::$biller = new self();
        }
        return self::$biller;
    }

    public function setUsers($users = []){
        $this->users = $users;
    }

    public function getUsers(){
        return $this->users;
    }

    public function runApi(){
        $users = $this->getUsers();
        $result = [];
        foreach($users as $key => $user){
            sleep(20);
            $curl = curl_init();

            $amount_to_bill = $user['amount_to_bill'];
            $url = "https://simple-api-php.free.beeceptor.com?bill=$amount_to_bill";

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false
            ));
            $res = curl_exec($curl);  
            array_push($result, $res);  
            curl_close($curl);
        }
        return $result;
    }
}