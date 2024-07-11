<?php 

class Message {
    private $destiny;
    private $subject;
    private $message;

    


    public function __construct($destiny, $subject, $message)
    {
        $this->__set('destiny', $destiny);
        $this->__set('subject', $subject);
        $this->__set('message', $message);
    }

    //name = atributo privado da classe message
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function MessageValid() 
    {
        if (empty($this->__get('destiny')) || 
            empty($this->__get('subject')) || 
            empty($this->__get('message'))) 
                
            return false;

        else
        
            return true;
        
    }

}