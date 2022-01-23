<?php 

require __DIR__ . "/../src/ApiConversao.php";
use PHPUnit\Framework\TestCase;


class ApiConversaoTest extends TestCase
{
    protected $acceptedCurrency = ['BRL', 'USD', 'EUR'];

    public function testApiWithoutValue(){ 

        $I = new ApiConversao();        
        $I->checkUrl('/');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->checkUrl('/'));
 
    }

    public function testApiWithoutFrom()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->checkUrl('/10'));
    }

    public function testApiWithoutTo()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/EUR');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->checkUrl('/10/EUR'));
    }

    public function testApiWithoutRate()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/EUR/USD');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->checkUrl('/10/EUR/USD'));

    }

    public function testApiInvalidValue()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/a/EUR/USD/0.5');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/a/EUR/USD/0.5'));
   
    }

    public function testApiNegativeValue()
    { 
        $I = new ApiConversao(); 
        $I->checkUrl('/-10/EUR/USD/0.5');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/-10/EUR/USD/0.5'));
    }

    public function testApiInvalidFrom()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/eur/USD/0.5');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/10/eur/USD/0.5'));
    }

    public function testApiInvalidTo()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/EUR/usd/0.5');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/10/EUR/usd/0.5'));

    }

    public function testApiInvalidRate()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/EUR/USD/a');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/10/EUR/USD/a'));
    }

    public function testApiNegativeRate()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/10/EUR/USD/-0.5');
        $this->assertEquals(400, http_response_code());
        $this->assertJson($I->sendGET('/10/EUR/USD/-0.5'));

      
    }

    public function testApiBrlToUsd()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/7.8/BRL/USD/0.5');
        $this->assertEquals(200, http_response_code());
        $this->assertJsonStringEqualsJsonString(
                json_encode([
                    "valorConvertido" => 3.9,"simboloMoeda" => '$']),
                    $I->checkUrl('/7.8/BRL/USD/0.5')
            );
    }

    public function testApiUsdToBrl()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/7/USD/BRL/0.5');
        $this->assertEquals(200, http_response_code());
        $this->assertJsonStringEqualsJsonString(
                json_encode([
                    "valorConvertido" => 3.5,"simboloMoeda" => 'R$']),
                    $I->checkUrl('/7/USD/BRL/0.5')
            );

    }

    public function testApiBrlToEur()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/7/BRL/EUR/5');
        $this->assertEquals(200, http_response_code());
        $this->assertJsonStringEqualsJsonString(
                json_encode([
                    "valorConvertido" => 35,"simboloMoeda" => '€']),
                    $I->checkUrl('/7/BRL/EUR/5')
        );
    }

    public function tryApiEurToBrl()
    {
        $I = new ApiConversao(); 
        $I->checkUrl('/7/EUR/BRL/5');
        $this->assertEquals(200, http_response_code());
       // $this->assertJson($I->sendGET('/7.8/BRL/USD/0.5'));
        $this->assertJsonStringEqualsJsonString(
                json_encode([
                    "valorConvertido" => 35,"simboloMoeda" => 'R$']),
                    $I->checkUrl('/7/EUR/BRL/5')
        );        
    }
}