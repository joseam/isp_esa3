<?php
     
    class Validierung {
        
        /**
         * @var array $patterns
         */
        public $patterns = array(
            'int'           => '[0-9]+',
            'text'          => '[a-zA-Z]+',
            'plz'           => '^[0-9]{5}$'
        );
        
        /**
         * @var array $errors
         */
        public $errors = array();
        
        /**
         * Feldname
         * 
         * @param string $name
         * @return this
         */
        public function name($name){
            
            $this->name = $name;
            return $this;
        
        }
        
        /**
         * Wert des Feldes
         * 
         * @param mixed $value
         * @return this
         */
        public function value($value){
            
            $this->value = $value;
            return $this;
        
        }    
        /**
         * Pattern (regex)
         * 
         * @param string $name
         * @return this
         */
        public function pattern($name){
            
            if($name == 'array'){
                
                if(!is_array($this->value)){
                    $this->errors[] = 'Eingabe: '.$this->name.' nicht g&uuml;ltig.';
                }
            
            }else{
            
                $regex = '/^('.$this->patterns[$name].')$/u';
                if($this->value != '' && !preg_match($regex, $this->value)){
                    $this->errors[] = 'Eingabe: '.$this->name.' nicht g&uuml;ltig.';
                }
                
            }
            return $this;
            
        }    
        /**
         * Sind alle Felder erfolgreich ausgefüllt?
         * 
         * @return boolean
         */
        public function isSuccess(){
            if(empty($this->errors)) return true;
        }
        
        /**
         * Fehler
         * 
         * @return array $this->errors
         */
        public function getErrors(){
            if(!$this->isSuccess()) return $this->errors;
        }
        
        /**
         * Gib Fehler in Html Format aus
         * 
         * @return string $html
         */
        public function displayErrors(){
            
            $html = '<ul>';
                foreach($this->getErrors() as $error){
                    $html .= '<li>'.$error.'</li>';
                }
            $html .= '</ul>';
            
            return $html;
            
        }
        
        /**
         * Gib Fehler aus
         *
         * @return booelan|string
         */
        public function result(){
            
            if(!$this->isSuccess()){
               
                foreach($this->getErrors() as $error){
                    echo "$error\n";
                }
                exit;
                
            }else{
                return true;
            }
        
        }
        
        /**
         * ueberpruft ob das Feld ein Integer enthält
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_int($value){
            if(filter_var($value, FILTER_VALIDATE_INT)) return true;
        }
    }
