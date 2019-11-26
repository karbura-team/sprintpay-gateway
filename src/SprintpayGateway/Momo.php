<?php

   namespace SprintpayGateway;

   class Momo {

    public function buildDateHeader() {
        date_default_timezone_set('UTC');
        return date('Y-m-d\TH:i:s\Z', time());
    }

    public function buildAuthorizationHeader($apiKey, $apiSecret, $date) {
        //Concat your keys and DateTime in the following order : APISecret + APIKey + DateTime
        $toSign = $apiSecret . $apiKey . $date;

        //Sign using SHA1.
        $messageBytes = utf8_encode($toSign);
        $secretBytes = utf8_encode($apiSecret);
        $result = hash_hmac('sha1', $messageBytes, $secretBytes);

        //Encode the result in base 64.
        $signature = base64_encode($result);

        //Concat all results like this: SP:APIKey:signature
        return "SP:" . $apiKey . ':' . $signature;
    }

    public static function makePaiement($numero,$montant,$description,$nom,$prenom,$email,$produit,$pays,$apikey,$apisecret) {

            $curl = curl_init(); $today = date("Y-m-d H:i:s");

            $datetime = buildDateHeader(); 

            $autorisation = buildAuthorizationHeader($apikey,$apisecret,$datetime);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.sprint-pay.com/sprintpayapi/payment/mobilemoney/request",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"phone\": \"".$numero."\",\r\n\"amount\": \"".$montant."\",\r\n\"description\": \"".$description."\",\r\n\"firstName\": \"".$nom."\",\r\n\"lastName\": \"".$prenom."\",\r\n\"emailId\": \"".$email."\",\r\n\"spMerchandRef1\": \"".$produit."\",\r\n\"spMerchandRef2\": \"".$produit."\",\r\n\"country\": \"".$pays."\"}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: ".$autorisation."",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "datetime: ".$datetime."",
                ),
            ));
                
            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

                $retour =  '{   "transactionID": "00000",
                                "statusDesc": "'.$err.'",
                                "amount": "'.$montant.'",
                                "recieverNumber": null,
                                "senderNumber": "'.$numero.'",
                                "operationType": "MoMoRequestPayment",
                                "statusCode": "00",
                                "opComment": null,
                                "processingNumber": "00000",
                                "operationDate": "'.$today.'",
                                "idSpMarchand": 0}';

            } else {

                $retour = $response;
            }

             return $retour;   

        }

    public static function makePaiementTest($numero,$montant,$description,$nom,$prenom,$email,$produit,$pays,$apikey,$apisecret) {

            $curl = curl_init(); $today = date("Y-m-d H:i:s");

            $datetime = buildDateHeader(); 

            $autorisation = buildAuthorizationHeader($apikey,$apisecret,$datetime);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://test-api.sprint-pay.com/sprintpayapi/payment/mobilemoney/request",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"phone\": \"".$numero."\",\r\n\"amount\": \"".$montant."\",\r\n\"description\": \"".$description."\",\r\n\"firstName\": \"".$nom."\",\r\n\"lastName\": \"".$prenom."\",\r\n\"emailId\": \"".$email."\",\r\n\"spMerchandRef1\": \"".$produit."\",\r\n\"spMerchandRef2\": \"".$produit."\",\r\n\"country\": \"".$pays."\"}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: ".$autorisation."",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "datetime: ".$datetime."",
                ),
            ));
                
            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

                $retour =  '{   "transactionID": "00000",
                                "statusDesc": "'.$err.'",
                                "amount": "'.$montant.'",
                                "recieverNumber": null,
                                "senderNumber": "'.$numero.'",
                                "operationType": "MoMoRequestPayment",
                                "statusCode": "00",
                                "opComment": null,
                                "processingNumber": "00000",
                                "operationDate": "'.$today.'",
                                "idSpMarchand": 0}';

            } else {

                $retour = $response;
            }

             return $retour;   

        }
    
   }    

?>