<?php
/**
 * Created by PhpStorm.
 * User: meh
 * Date: 10/12/2018
 * Time: 12:27
 */

namespace w2w\Utils;

use Doctrine\ORM\Tools\Pagination\Paginator;

class Utils
{
    /* ****************** dump ****************** */
    public static function dump($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        exit;
    }
    /* ****************** END dump ****************** */


    /* ****************** message ****************** */
    public static function message($result, $ok, $not)
    {
        if ($result) {
            $_SESSION['message']['type'] = 'success';
            $_SESSION['message']['msg'] = $ok;
        } else {
            $_SESSION['message']['type'] = 'warning';
            $_SESSION['message']['msg'] = $not;
        }
    }

    public static function echoMessage()
    {
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
        }
        unset($_SESSION['message']);
    }

    /* ****************** END message ****************** */


    // ****************** inputValidation ******************
    /**
     *
     *
     * @param array
     * @return bool
     */
    public static function inputValidation(array $input): bool
    {
        $pwReg = ";^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$;";

        foreach ($input as $key => $value) {
            if (isset($value[1])) {
                switch ($value[0]) {
                    case 'num':
                        if (ctype_digit($value[1])) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'alpha':
                        if (ctype_alpha(str_replace(' ', '', $value[1]))) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'alphanum':
                        if (ctype_alnum(str_replace(' ', '', $value[1]))) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'alphanumsoft':
                        if (ctype_alnum(str_replace(["'", "\"", "&quot;", " "], '', $value[1]))) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'password':
                        if (filter_var($value[1], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $pwReg]])) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'email':
                        if (filter_var($value[1], FILTER_VALIDATE_EMAIL)) {
                            $input[$key][2] = true;
                        }
                        break;
                    case 'ckedit':
                        $input[$key][2] = true; // TODO : CKEDITOR input validation
                        break;
                }
            }
        }


        if (self::in_array_r(false, $input, true)) {
            return false;
        } else
            return true;
    }

    // ****************** END inputValidation ******************


    public static function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

    /* ****************** PAGINATOR ****************** */
    public static function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()->setFirstResult($limit * ($page - 1))->setMaxResults($limit);
        return $paginator;
    }
    /* ****************** END PAGINATOR ****************** */


}