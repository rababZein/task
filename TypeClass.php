<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'constant.php';
require_once  'ValidationInterface.php';

class Type implements ValidationInterface {

    public $type;
    public $serviceId;
    public $variationId;
    public $questionId;
    public $categoryId;
    public $subCategoryId;
    public $responseType;

    public function serviceFormatValidation($service) {
        if ($service && (substr_count($service, '.') == 0 || substr_count($service, '.') == 1))
            return true;
        
        return false;
    }


    public function serviceIdValidation($serviceId) {
        if ($serviceId <= MAX_SERVICES)
            return true;

        return false;
    }

    public function variationIdValidation($variationId = null) {
        if ($variationId <= MAX_VARIATIONS)
            return true;

        return false;
    }


    public function questionFormatValidation($question) {
        if ($question && (substr_count($question, '.') == 0 || substr_count($question, '.') == 1 || substr_count($question, '.') == 2))
            return true;
        
        return false;
    }

    public function questionIdValidation($questionId) {
        if ($questionId <= MAX_QUESTIONS_TYPE)
            return true;

        return false;
    }


    public function categoryIdValidation($categoryId) {
        if ($categoryId <= MAX_CATEGORIES)
            return true;

        return false;
    }


    public function subCategoryIdValidation($subCategoryId) {
        if ($subCategoryId <= MAX_SUB_CATEGORIES)
            return true;

        return false;
    }


    public function responseTypeValidation($responseType) {
        if ($responseType == FIRST_ANSWER || $responseType == NEXT_ANSWER)
            return true;

        return false;
    }

    public function dateFormatValidation($date = null) {
        if (! $date) {
            return true;
        }

        $dateArray  = explode('.', $date);
        if ((count($dateArray) == 3) && (checkdate($dateArray[1], $dateArray[0], $dateArray[2])))
            return true;

        return false;

    }
  }