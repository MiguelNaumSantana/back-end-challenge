<?php 


class Conversao{

    protected $acceptedCurr = ['BRL' => 'R$', 'EUR' => '€', 'USD' => '$', ];
    public $valConvert;
    public $simbolCoin;

    public function converter($valFrom, $currFrom, $currTo, $valTo){

        if($this->checkParams($valFrom, $currFrom, $currTo, $valTo)){
            $this->simbolCoin = $this->acceptedCurr[$currTo];
            $this->valConvert = $this->calculate($valFrom,$valTo);
            return true;
        }
        else{
            return false;
        }
    }

    public function checkParams($valFrom, $currFrom, $currTo, $valTo){

         //var_dump($valFrom, $currFrom, $currTo, $valTo);
        if(!$this->checkCoin($currFrom, $currTo)){
            return false;         
        }
        elseif(!$this->checkValues($valFrom, $valTo)){           
            return false;
        }
                
        elseif(!$this->isNumeric($valFrom, $valTo)){            
            return false;
        }
        else{
            return true;
        }
        
    }

    public function checkCoin($currFrom, $currTo){

        if (array_key_exists($currFrom, $this->acceptedCurr) && array_key_exists($currTo,$this->acceptedCurr)) {
            return true;
        }
        else{
            return false;
        }
    }

    public function isNumeric($valFrom, $valTo){

        if (is_numeric($valFrom) && is_numeric($valTo)) {
            return true;
        }
        else{
            return false;
        }
    }

    public function checkValues($valFrom, $valTo){

        if ($valFrom < 0 || $valTo < 0) {
            return false;
        }
        else{
            return true;
        }
    }

    public function calculate($valFrom, $valTo){
        return $valFrom * $valTo;
    }
}