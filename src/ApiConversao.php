<?php

require __DIR__ . "/Conversao.php";

class ApiConversao{
      
    public function checkUrl($url){
        
        $url = explode('/',$url);        
        if(isset($url[1]) && isset($url[2]) && isset($url[3]) && isset($url[4]) ){ 
            if ($url[1] != 'exchange') {
                http_response_code(400);
                return json_encode(["message" => "Page not Found"]);
            }
            return self::sendGet($url);           
        }
        else{
                 
            http_response_code(400);
            return json_encode(["message" => "Not Found"]);            
        }
    }

    public function sendGet($url){
                
        $convert = new Conversao();
        $valFrom = $url[2];
        $currFrom = $url[3];
        $currTo= $url[4];
        $valTo=$url[5];
        $data = $convert->converter($valFrom,$currFrom,$currTo,$valTo);             
        if($data){
            
            http_response_code(200);            
            return json_encode([
                "valorConvertido" => $convert->valConvert ,
                "simboloMoeda" => $convert->simbolCoin
            ]);
        }
        else{
           // http_response_code(400);  
            return json_encode(["message" => "Erro nos parâmetros"]);
        }               
    }                                                    
}