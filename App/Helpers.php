<?php

namespace App;


class Helpers
{
    /**
     * Отображение переменной в читаемом виде
     *
     * @param $var
     */
    public static function dump($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    /**
     * Отображение переменной в читаемом виде и прекращение выполнения скрипта
     *
     * @param $var
     */
    public static function dd($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';

        die();
    }
}
