<?php
class Encuesta extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }
    public function encuesta(){
        $data['tag_page'] = "Encuesta";
        $data['page_title'] = "Página de Encuesta";
        $data['page_name'] = "encuenta";
       $this->views->getView($this,"encuesta",$data);
    }

}
?>