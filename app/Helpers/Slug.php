<?php
namespace App\Helpers;
 
class Slug {
    public static function create() {
        $arr = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];

        $slug = [];
        for($i = 0 ; $i < 30 ; $i++){
            $slug[] = $arr[rand(1, 50)];
        }
        
        return join("", $slug);
    }
}