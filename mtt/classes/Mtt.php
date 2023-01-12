<?php
use Wruczek\PhpFileCache\PhpFileCache;

class Mtt{

    private $basePath = "";
    private $templatesPath = "";
    private $storagePath = "";

    public function __construct()
    {
        $currenPath =  dirname(__FILE__);
        $this->basePath = $currenPath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
        $this->templatesPath = $this->basePath."templates/";
        $this->storagePath = $this->basePath."mtt/storage/";
    }

    public function getTemplateFiles(){
        $files = glob($this->templatesPath."*.html");
        $files = str_replace($this->templatesPath,"",$files);
        return $files;
    }

    public function checkFileChanges(string $filename, int $lastmodified_time){
        $filename = str_replace(array('..','/'),"",$filename);
        $filePath = $this->templatesPath.$filename;
        if(file_exists($filePath)){
            $modified_time = filemtime($filePath);
            $modified = false;
            if($lastmodified_time < $modified_time){
                $modified = true;
            }

            return array(
                'modified_time' => $modified_time,
                'modified' => $modified
            );
        };
        return false;
    }

}