<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'constant.php';
require_once "TypeClass.php";

class Ctype extends Type {

    public $line;
    public $date;
    public $time;

    public function __construct($line){
        $this->line = $line;
        list($this->type, $this->service, $this->question, $this->responseType, $this->date, $this->time ) = explode(" ", $line);
        
        $serviceArray = explode(".", $this->service);
        $this->serviceId = $serviceArray[0] ?? null;
        $this->variationId = $serviceArray[1] ?? null;

        $questionArray = explode(".", $this->question);
        $this->questionId = $questionArray[0] ?? null;
        $this->categoryId = $questionArray[1] ?? null;
        $this->subCategoryId = $questionArray[2] ?? null;
    }

    public function validate(){
        if ( $this->serviceFormatValidation($this->service) &&
            $this->serviceIdValidation($this->serviceId) &&
            $this->variationIdValidation($this->variationId) &&
            $this->questionFormatValidation($this->question) &&
            $this->questionIdValidation($this->questionId) &&
            $this->categoryIdValidation($this->categoryId) &&
            $this->subCategoryIdValidation($this->subCategoryId) &&
            $this->responseTypeValidation($this->responseType) &&
            $this->dateFormatValidation($this->date) && 
            $this->timeFormatValidation($this->time))

                return true;

        return false;
    }

    public function timeFormatValidation($time){
        if (is_numeric($time))
            return true;
        return false;
    }

    public function getDate(){
        return $this->date;
    }

    public function getTime(){
        return $this->time;
    }
    
}