<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'constant.php';
require_once 'QtypeClass.php';
require_once 'CtypeClass.php';

class Analysis {

    private $s;
    private $cTypeArray;
    private $qTypeArray;

    public function __construct($s, $lines){
        $this->s = $s;
        $this->qTypeArray = $this->getValidQLines($lines);
        $this->cTypeArray = $this->getValidCLines($lines);
    }

    public function validateS(){
        if ($this->s <= MAX_COUNT_S)
            return true;

        return false;
    }

    public function getValidCLines($lines){
        $validLines = [];
        foreach ($lines as $line) {
            if (substr_count($line, ' ') == 5 && strtok($line, " ") == 'C') {
                $cLine = new Ctype($line);
                if (!$cLine->validate()) {
                    continue;
                } else {
                    $validLines[] = $cLine;
                }
            }
        }

        return $validLines;
    }

    public function getValidQLines($lines){
        $validLines = [];
        foreach ($lines as $line) {
            if (substr_count($line, ' ') == 4 && strtok($line, " ") == 'D') {
                $qLine = new Qtype($line);
                if (!$qLine->validate()) {
                    continue;
                } else {
                    $validLines[] = $qLine;
                }
            }
        }

        return $validLines;
    }

    public function checkDateCBetweenQDates($cLineDate, $qLineFromDate, $qLineToDate = null){
        if ($qLineToDate && strtotime($cLineDate) >= strtotime($qLineFromDate) && strtotime($cLineDate) <= strtotime($qLineToDate)) {
            return true;
        }

        if (strtotime($cLineDate) == strtotime($qLineFromDate)) {
            return true;
        }

        return false;
    }

    public function compareServices($cLine, $qLine){
        if ($qLine->variationId && $qLine->variationId == $cLine->variationId && $cLine->serviceId == $qLine->serviceId) {
            return true;
        } elseif (!$qLine->variationId && $cLine->serviceId == $qLine->serviceId) {
            return true;
        } elseif ($qLine->service == '*') {
            return true;
        } else {
            return false;
        }
    }

    public function compareQuestions($cLine, $qLine){
        if ($qLine->categoryId && !$qLine->subCategoryId &&
            $cLine->categoryId == $qLine->categoryId &&
            $cLine->service == $qLine->service) {
            return true;
        } elseif (!$qLine->categoryId && $cLine->questionId == $qLine->questionId) {
            return true;
        } elseif ($qLine->categoryId && $qLine->subCategoryId &&
                 $cLine->categoryId == $qLine->categoryId &&
                 $cLine->service == $qLine->service &&
                 $cLine->subCategoryId == $qLine->subCategoryId) {
            return true;
        } elseif ($qLine->question == '*') {
            return true;
        } else {
            return false;
        }
    }

    public function getAverageWaitingTime($cTypeArray){
        $timeTotal = 0;
        $count = 0;
        foreach ($cTypeArray as $cLine) {
            $timeTotal += $cLine->time;
            $count ++;
        }
        if($count)
            $avg = $timeTotal/$count;
        else 
            $avg = "-";

        return $avg;
    }

    public function getMatchedCLines($qLine, $cLines){
        $matchedCLines = [];
        foreach ($cLines as $cLine) {
            if ($this->compareServices($cLine, $qLine) &&
                $this->compareQuestions($cLine, $qLine) &&
                $cLine->responseType == $qLine->responseType &&
                $this->checkDateCBetweenQDates($cLine->date, $qLine->dateFrom, $qLine->dateTo))
                $matchedCLines[] = $cLine;                
        }
        return $matchedCLines;
    }

    public function getAnalysisData($qLines, $cLines){
        $analysisData = [];
        foreach ($qLines as $qLine) {
            $matechedCLines = $this->getMatchedCLines($qLine, $cLines);
            $analysisData[] = $this->getAverageWaitingTime($matechedCLines);
        }
        
        return $analysisData;
    }

    public function generateOutPut(){
        if (! $this->validateS($this->s)){
            echo "you can't complete the process, S is more than ".MAX_COUNT_S;
        }

        return $this->getAnalysisData($this->qTypeArray, $this->cTypeArray);
    }

}