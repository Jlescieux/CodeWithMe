<?php

namespace App\Helpers;

class Sluggifier {

    // Convertit une chaîne de caractère en "slug"
    function sluggify($string, $delimiter = '-') {

            $string = strip_tags($string);
            $oldLocale = setlocale(LC_ALL, '0');
            setlocale(LC_ALL, 'en_US.UTF-8');
            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            $string = preg_replace('~[^\pL\d]+~u', $delimiter, $string);
            $string = preg_replace('/~[^-\w]+~/', '', $string);
            $string = strtolower($string);
            $string = trim($string, $delimiter);
            setlocale(LC_ALL, $oldLocale);
            return $string;
    }
}
