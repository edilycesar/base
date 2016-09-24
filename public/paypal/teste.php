<?php
$postStr =  "USER=teste_api1.jeitodigital.com.br&"; 
$postStr .= "PWD=S9B7FHF7EQBSFSEB&";  
$postStr .= "SIGNATURE=AFcWxV21C7fd0v3bYYYRCpSSRl31ARSbomrArz1LRyxcFsKlwWN0cBI4&";  

$postStr .= "METHOD=SetExpressCheckout&";  
$postStr .= "VERSION=114.0&";  

$postStr .= "PAYMENTREQUEST_0_PAYMENTACTION=SALE&";  
$postStr .= "PAYMENTREQUEST_0_AMT=30&";  
$postStr .= "PAYMENTREQUEST_0_CURRENCYCODE=BRL&";  
$postStr .= "PAYMENTREQUEST_0_ITEMAMT=30&";  
$postStr .= "PAYMENTREQUEST_0_INVNUM=3935&";  

$postStr .= "L_PAYMENTREQUEST_0_NAME0=Credito&";  
$postStr .= "L_PAYMENTREQUEST_0_DESC0=oCredito&";  
$postStr .= "L_PAYMENTREQUEST_0_AMT0=30&";  
$postStr .= "L_PAYMENTREQUEST_0_QTY0=1&";  
$postStr .= "L_PAYMENTREQUEST_0_ITEMAMT=30&";

$postStr .= "RETURNURL=http://gestordecliente.com.br/psicologo&";  
$postStr .= "CANCELURL=http://gestordecliente.com.br&";  

//$postStr .= "BUTTONSOURCE=BR_C_EMRESA&";
//$postStr .= "SUBJECT=conta@ededor.com.br";

echo "<br/><hr/>Req: " . $postStr;

//Enviar
$url = "https://api-3t.sandbox.paypal.com/nvp"; 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array (        
    "Content-Type: application/x-www-form-urlencoded; charset=utf-8",
));
$return = curl_exec($ch);
curl_close($ch);

echo "<br/><hr/>Ret: " . urldecode($return);

echo "<p></p>";
