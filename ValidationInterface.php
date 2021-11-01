<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Declare the interface 'Validation'
interface ValidationInterface {
    //1- validate service format
    public function serviceFormatValidation($service);

    //2- validate service id
    public function serviceIdValidation($serviceId);

    //3- validate variation id
    public function variationIdValidation($variationId);

    //4- validate question format
    public function questionFormatValidation($question);

    //5- validate question id
    public function questionIdValidation($questionId);

    //6- validate category id
    public function categoryIdValidation($categoryId);

    //7- validate sub category id
    public function subCategoryIdValidation($subCategoryId);

    //8- validate response type
    public function responseTypeValidation($responseType);

    //9- validate date format
    public function dateFormatValidation($date);
}