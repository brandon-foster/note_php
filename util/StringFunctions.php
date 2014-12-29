<?php
class StringFunctions {
    /*
     * Return a string with spaces replaced with dashes.
     * Example:
     * "Admin panel" becomes 'Admin-panel'
     */
    public static function spaceToDash($string) {
        $string = str_replace(' ', '-', $string);
        return $string;
    }
    
    /*
     * Return a string with spaces replaced with dashes.
    * Example:
    * "Admin-panel" becomes 'Admin panel'
    */
    public static function dashToSpace($string) {
        $string = str_replace("-", " ", $string);
        return $string;
    }
}