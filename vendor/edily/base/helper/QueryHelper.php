<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QueryHelper
 *
 * @author edily
 */
class Query {
    
    public static function removeLimitOffset($query) 
    {
        $remProx = $add = false;
        $query2 = "";
        $parts = explode(" ", $query);
        foreach ($parts as $part) {  
            $part = trim($part);
            if(!empty($part)){
                
                $add = true;
                
                if($remProx === true){
                    $add = false;
                    $remProx = false;
                }
                
                if($part === "LIMIT" || $part === "OFFSET"){
                    $remProx = true;
                    $add = false;
                }            
                
                $query2 .= $add === true ? $part . " " : "";
            }
        }
        return $query2;
    }
}