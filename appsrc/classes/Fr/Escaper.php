<?php
namespace Fr;

class Escaper {

    public static function escapeHTML($string, $flags = false, $encoding = "utf8", $double_encode = true) {
        if ($flags === false) {
                $flags = ENT_COMPAT | ENT_HTML401;
        }
        return htmlentities($string, $flags, $encoding, $double_encode);
    }

    public static function escapeXML($string, $encoding = "UTF-8", $double_encode = true) {
        return htmlspecialchars($string, ENT_COMPAT | ENT_XML1, $encoding, $double_encode);
    }



    // c/c de \Z :


    /**
     * rédefinit appel à htmlspecialchars avec mêmes valeurs par défaut
     * sauf pour $encoding ("utf-8" par défaut à partir de PHP 5.4)
     */
    public static function htmlspecialchars($string, $flags = false,
        $encoding = "cp1252", $double_encode = true)
    {
        if ($flags === false) {
            $flags = ENT_COMPAT | ENT_HTML401;
        }
        return htmlspecialchars($string, $flags, $encoding, $double_encode);
    }

    /**
     * rédefinit appel à htmlentities avec mêmes valeurs par défaut
     * sauf pour $encoding ("utf-8" par défaut à partir de PHP 5.4)
     */
    public static function htmlentities($string, $flags = false,
        $encoding = "cp1252", $double_encode = true)
    {
        if ($flags === false) {
            $flags = ENT_COMPAT | ENT_HTML401;
        }
        return htmlentities($string, $flags, $encoding, $double_encode);
    }

}
