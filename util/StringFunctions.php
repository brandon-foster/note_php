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
}
