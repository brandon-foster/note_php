<?php 

class PageData {
    private $css = "";
    private $title = "";
    private $bodyClass = "";
    private $nav = "";
    private $content = "";
    private $footer = "";
    private $js = "";
    private $jsHead = "";
    private $scriptCode = "";
    private $scriptCodeHead = "";
    
    public function addCss($href, $attrValuePairs=NULL) {
        $this->css .= "<link rel='stylesheet' type='text/css' href='{$href}' {$attrValuePairs} />";
    }
    public function getCss() {
        return $this->css;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setBodyClass($class) {
        $this->bodyClass = $class;
    }
    public function getBodyClass() {
        return $this->bodyClass;
    }
    
    public function setNav($nav) {
        $this->nav = $nav;
    }
    public function getNav() {
        return $this->nav;
    }
    
    public function addRowHead() {
        $this->content .= "<div class='row'>";
    }
    
    public function addRowTail() {
        $this->content .= "</div>";
    }

    public function addContent($content) {
        $this->content .= $content;
    }
    public function getContent() {
        return $this->content;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
    }
    public function getFooter() {
        return $this->footer;
    }

    public function addJs($src) {
        $this->js .= "<script type='text/javascript' src='{$src}'></script>";
    }
    public function addJsHead($src) {
        $this->jsHead .= "<script type='text/javascript' src='{$src}'></script>";
    }
    public function getJs() {
        return $this->js;
    }
    public function getJsHead() {
        return $this->jsHead;
    }

    public function addScriptCode($code) {
        $this->scriptCode .= "<script type='text/javascript'>\$(document).ready(function() { {$code} });</script>";
    }
    public function getScriptCode() {
        return $this->scriptCode;
    }
    
    public function addScriptCodeHead($code) {
        $this->scriptCodeHead .= "<script type='text/javascript'>{$code}</script>";
    }
    public function getScriptCodeHead() {
        return $this->scriptCodeHead;
    }

}
