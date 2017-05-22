<?php
namespace Edily\Base;

/**
 * Description of router
 *
 * @author edily
 */
class Router {
    
    protected $requestItens;
    public $controller, $action, $params;

    public function __construct() 
    {        
        $this->prepareUri();
        $this->getController();
        $this->getAction();   

	//echo "<p>Controller: " . $this->controller . "</p>";
	//echo "<p>Action: " . $this->action . "</p>"; 
	//foreach ($this->params as $key => $value) {
	//	echo "<p>Param: " . $key . " = " . $value . "</p>";
	//}    

        Register::set('route', $this);
    }
    
//    private function getRequestUrI() 
//    {
//        return $_SERVER['REQUEST_URI'];
//    }
    
    private function getController() 
    {
        $this->controller = !empty($this->requestItens[0]) ? $this->requestItens[0] : "Index";
    }
    
    private function getAction() 
    {
        $this->action = isset($this->requestItens[1]) ? $this->requestItens[1] : "index";
    }
    
    private function prepareUri() 
    {
        //$uri = $this->getRequestUrI();
        //$uriAP = $this->getAfterPublic($uri);
	$uriAP = $this->getAfterPublic();
        $this->splitRequest($uriAP);
        $this->prepareParams();
    }
    
//    private function getAfterPublic($uri) 
//    {        
//        $uriPublicPos = 7 + strpos($uri, "public/");
//        return substr($uri, $uriPublicPos);
//    }

    private function getAfterPublic($uri = null) 
    {   
	$pathArr = explode("=", $_SERVER['QUERY_STRING']);
        return $pathArr[1];
    }
    
    private function splitRequest($uriAP) 
    {
        $this->requestItens = explode("/", $uriAP);
    }
    
    private function prepareParams() 
    {        
        $var = $val = "";
        foreach ($this->requestItens as $key => $value) {
            if($key > 1){
                if(($key % 2) == 0){
                    $var = $value;
                }else{
                    $val = $value;
                }
                $this->params[$var] = $val;
            }
        }
    }
}
