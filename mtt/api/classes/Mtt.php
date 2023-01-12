<?php
class Mtt{

    private $basePath = "";
    private $templatesPath = "";

    public function __construct()
    {
        $currenPath =  getcwd();
        $this->basePath = $currenPath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
        $this->templatesPath = $this->basePath."templates/";
    }

    public function getTemplateFiles(){
        $files = glob($this->templatesPath."*.html");
        $files = str_replace($this->templatesPath,"",$files);
        return $files;
    }


}