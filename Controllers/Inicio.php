<?php
class Inicio extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }
    /*LLamado de la vista y los datos para usar en la vista*/
    public function inicio(){
        $data['tag_page'] = "Inicio";
        $data['page_title'] = "Página de Inicio Correcto llamado";
        $data['page_name'] = "listo";
        
       $this->views->getView($this,"inicio",$data);
    }
}
?>