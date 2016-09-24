<?php
/**
* Observer,that who recieves news
*/
class Reader implements SplObserver{
    private $name;
   
    public function __construct($name) {
        $this->name = $name;
    }
   
    public function update(\SplSubject $subject) {
        echo $this->name.' is reading breakout news <b>'.$subject->getContent().'</b><br>';
    }
}
