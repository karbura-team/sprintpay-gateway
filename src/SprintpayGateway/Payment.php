<?php

namespace SprintpayGateway;

class Payment {

    public static function initialize($privatekey,$baseurl,$clientid,$clientoken,$phone,$orderid,$amount,$currency,$description,$companyname,$success,$failure,$notification) {

        $value = $privatekey."".$amount."".$clientid."".$clientoken."".$companyname."".$currency."".$description."".$failure."".$notification."".$orderid."".$phone."".$success;

        $token = md5($value);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "".$baseurl."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"amount\": \"".$amount."\",\"clientId\": \"".$clientid."\",\r\n\"clientToken\": \"".$clientoken."\",\r\n\"companyName\": \"".$companyname."\",\r\n\"currency\": \"".$currency."\",\r\n\"description\": \"".$description."\",\r\n\"failureUrl\": \"".$failure."\",\r\n\"notificationUrl\": \"".$notification."\",\r\n\"orderId\": \"".$orderid."\",\r\n\"phone\": \"".$phone."\",\r\n\"successUrl\": \"".$success."\"}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$token."",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {

            $retour =  '{   
                            
                            "transaction_id": "00000",
                            "status_desc": "Failed",
                            "amount": "'.$montant.'",
                            "payment_url": null,
                            "status_code": 400,
                            "description": "'.$err.'",
                            "order_id": "00"
                        
                        }';

        } else {

            $retour = $response;
        }

        return $retour; 
        
    }

    public static function initialize_card($privatekey,$baseurl,$clientid,$clientoken,$phone,$orderid,$amount,$currency,$description,$companyname,$success,$failure,$notification) {

        $ipadress = $_SERVER['SERVER_ADDR'];

        $value = $privatekey."".$amount."".$clientid."".$clientoken."".$companyname."".$currency."".$description."".$failure."".$notification."".$orderid."".$phone."".$success."".$ipadress;

        $token = md5($value);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "".$baseurl."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"amount\": \"".$amount."\",\"clientId\": \"".$clientid."\",\r\n\"clientToken\": \"".$clientoken."\",\r\n\"companyName\": \"".$companyname."\",\r\n\"currency\": \"".$currency."\",\r\n\"description\": \"".$description."\",\r\n\"failureUrl\": \"".$failure."\",\r\n\"notificationUrl\": \"".$notification."\",\r\n\"orderId\": \"".$orderid."\",\r\n\"phone\": \"".$phone."\",\r\n\"successUrl\": \"".$success."\",\r\n\"ipAddress\": \"".$ipadress."\"}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$token."",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {

            $retour =  '{   
                            
                            "transaction_id": "00000",
                            "status_desc": "Failed",
                            "amount": "'.$montant.'",
                            "payment_url": null,
                            "status_code": 400,
                            "description": "'.$err.'",
                            "order_id": "00"
                        
                        }';

        } else {

            $retour = $response;
        }

        return $retour; 
        
    }

    public static function initialize_demo($baseurl,$clientid,$clientoken,$phone,$orderid,$amount,$currency,$description,$companyname,$success,$failure,$notification) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "".$baseurl."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"clientId\": \"".$clientid."\",\r\n\"clientToken\": \"".$clientoken."\",\r\n\"phone\": \"".$phone."\",\r\n\"orderId\": \"".$orderid."\",\r\n\"amount\": \"".$amount."\",\r\n\"currency\": \"".$currency."\",\r\n\"description\": \"".$description."\",\r\n\"companyName\": \"".$companyname."\",\r\n\"successUrl\": \"".$success."\",\r\n\"failureUrl\": \"".$failure."\",\r\n\"notificationUrl\": \"".$notification."\"}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {

            $retour =  '{   
                            
                            "transaction_id": "00000",
                            "status_desc": "Failed",
                            "amount": "'.$montant.'",
                            "payment_url": null,
                            "status_code": 400,
                            "description": "'.$err.'",
                            "order_id": "00"
                        
                        }';

        } else {

            $retour = $response;
        }

        return $retour; 
        
    }


    public static function checkstatus($baseurl,$clientid,$clientoken,$orderid){

        $curl = curl_init();

        $baseurl = $baseurl.'?clientId='.$clientid.'&clientToken='.$clientoken.'&orderId='.$orderid;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "".$baseurl."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {

            $retour =  '{   
                            
                            "transaction_id": "00000",
                            "status_desc": "Failed",
                            "amount": "'.$montant.'",
                            "payment_url": null,
                            "status_code": 400,
                            "description": "'.$err.'",
                            "order_id": "00"
                        
                        }';

        } else {

            $retour = $response;
        }

        return $retour; 

    }
   

}

?>