<?php
class A{
    public $name = "User name";
    function thi(){
        return"trượt";
    }
}
class B extends A{
    function thi(){
        return $this->name.'thi qua môn';
    }
}
$ngoc = new B();
$x->name= "ngọc";
$ngoc->thi();
?>