<?php
class StringFunctions {
    /*
     * Return a stringwith spaces converted to dashes, and lowercase.
     */
    public static function formatAsQueryString($text) {
        $result = StringFunctions::spaceToDash($text);
        $result = strtolower($result);
        return $result;
    }
    
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
    
    /*
     * Return a string of $word with 's' appended to it if the $quantity is not
     * equal to 1
     */
    public static function singularOrPlural($word, $quantity) {
        if ($quantity != 1) {
            return $word . 's';
        } else {
            return $word;
        }
    }
    
    /*
     * Returns the string 'is' or the string 'are', depending on the $quantity
     */
    public static function isOrAre($quantity) {
        if ($quantity == 1) {
            return 'is';
        } else {
            return 'are';
        }
    }
}
