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
    
    private function getQueryString() 
    {
        return $_SERVER['QUERY_STRING'];
    }
    
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
	$uriAP = $this->getAfterPublic();
        $this->splitRequest($uriAP);
        $this->prepareParams();
    }

    private function getAfterPublic() 
    {   
	$pathArr = explode("=", $this->getQueryString());
        return isset($pathArr[1]) ? $pathArr[1] : '';
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
