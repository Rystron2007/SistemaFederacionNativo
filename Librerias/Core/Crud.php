<?php 
    //Creacion de una Interface para los metodos general del CRUD
    interface Crud{

        public function getIndividual(int $id);
        public function getAll();
        public function setRegistro();
        public function editRegistro();
        public function delRegistro();

    }
?>