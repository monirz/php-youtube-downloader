<?php

Class Validator
{
    private $errors = array();
    
    
    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function validate()
    {
        if(!function_exists("curl_init")){
            
            $this->errors = "curl not found";
            return false;
        }
        
        return true;
    }
   
    
    
    public function getErrors()
    {
        return $this->errors;
    }
    
}

