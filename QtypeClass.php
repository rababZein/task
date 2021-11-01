<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "TypeClass.php";

class Qtype extends Type {

    public $line;
    public $dateFromToString;
    public $dateFrom;
    public $dateTo;

    public function __construct($line){
        $this->line = $line;
        list( $this->type, $this->service, $this->question, $this->responseType, $this->dateFromToString) = explode(" ", $line);

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
            $this->dateFromToStringFormatValidation($this->dateFromToString))

                return true;

        return false;
    }

    public function dateFromToStringFormatValidation($dateFromToString) {
        $dateArray  = explode('-', $dateFromToString);

        if (count($dateArray) != 1 && count($dateArray) != 2){
            return false;
        }

        if ($this->dateFormatValidation($dateArray[0]) && $this->dateFormatValidation($dateArray[1] ?? null)) {
            $this->dateFrom = $dateArray[0];
            $this->dateTo = $dateArray[1] ?? null;
        } else {
            return false;
        }

        return true;
    }

    public function getDateFrom() {
        return $this->dateFrom;
    }

    public function getDateTo() {
        return $this->dateTo;
    }
    

}