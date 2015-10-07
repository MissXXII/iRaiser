<?php

class Data {

    private $dates = array();
    private $validated = array();
    private $failed = array();
    private $waiting = array();
    private $colors = array();

    public function __construct($dates = [], $validated = [], $failed = [], $waiting = [], $colors= []) {
        $this->dates = $dates;
        $this->validated = $validated;
        $this->failed = $failed;
        $this->waiting = $waiting;
        $this->colors = $colors;
    }

    public function build() {
        $result = array(
            "labels" => $this->dates,
            "datasets" => array(
                array(
                    "label" => "failed",
                    "fillColor" => "rgb(" . $this->colors['failedColor'] . ")",
                    "highlightFill" => "rgba(" . $this->colors['failedColor'] . ",0.75)",
                    "data" => $this->failed
                ),
                array(
                    "label" => "validated",
                    "fillColor" => "rgb(" . $this->colors['validatedColor'] . ")",
                    "highlightFill" => "rgba(" . $this->colors['validatedColor'] . ",0.75)",
                    "data" => $this->validated
                ),
                array(
                    "label" => "waiting",
                    "fillColor" => "rgb(" . $this->colors['waitingColor'] . ")",
                    "highlightFill" => "rgba(" . $this->colors['waitingColor'] . ",0.75)",
                    "data" => $this->waiting
                ),
            )
        );
        return $result;
    }

    public function toString() {
        return json_encode($this->build());
    }

    public function getDates() {
        return $this->dates;
    }
    public function setDates(array $dates) {
        $this->dates = $dates;
    }

    public function getValidated() {
        return $this->validated;
    }
    public function setValidated(array $validated) {
        $this->validated = $validated;
    }

    public function getFailed() {
        return $this->failed;
    }
    public function setFailed(array $failed) {
        $this->failed = $failed;
    }

    public function getWaiting() {
        return $this->waiting;
    }
    public function setWaiting(array $waiting) {
        $this->waiting = $waiting;
    }
    
    public function getColors() {
        return $this->colors;
    }
    public function setColors(array $colors) {
        $this->colors = $colors;
    }
}
