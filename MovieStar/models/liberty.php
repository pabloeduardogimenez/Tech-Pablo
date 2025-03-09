<?php

    class FuncaoTexto{

        public function LowerCase($str) {
            if($str !="") { 
                for ($i = 0; $i < strlen($str); $i++) {            
                    if (preg_match('/^[a-z]+/', $str[$i])){
                        return true;            
                    }  
                }
            }  
        } 
        public function UpperCase($str) {
            if($str !="") { 
                for ($i = 0; $i < strlen($str); $i++) {            
                    if (preg_match('/^[A-Z]+/', $str[$i])){
                        return true;            
                    }  
                }
            }  
        } 

        public function SearchNumbers($str) {
            if($str !="") { 
                for ($i = 0; $i < strlen($str); $i++) {            
                    if (preg_match('/^[0-9]+/', $str[$i])){
                        return true;            
                    }  
                }
            }          
        }

        public function SearchCharacters1($str) {
            if($str !="") { 
                for ($i = 0; $i < strlen($str); $i++) {              
                    if (preg_match('/^[#-@-!-$-%-&-*-+]+/', $str[$i])){
                        return true;            
                    } 
                }        
            }
        }
        public function SearchCharacters2($texto) {
            if($str !="") { 
                $arr=['!','@','#','$','%','&','*','-','+'];
                for ($i = 0 ; $i < strlen($texto); $i++){
                    if ($texto[$i] === $arr[$i]) {                    
                        return true;
                    } else {
                    
                    }
                }
            } else { 
                return false;
            } 
        }   

    }





?>