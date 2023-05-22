<?php

use Carbon\Carbon;

function isBase64($base64)
{
    $explode = explode(',', $base64);
    $allow = ['png', 'jpg', 'svg', 'jpeg'];
    $format = str_replace(
        [
            'data:image/',
            ';',
            'base64',
        ],
        [
            '', '', '',
        ],
        $explode[0]
    );

    // check file format
    if (!in_array($format, $allow)) {
        return false;
    }

    // check base64 format
    if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
        return false;
    }

    return true;
}

if (!function_exists('carbon')) {
    /**
     * Retornar instância de \Carbon\Carbon.
     *
     * @param mixed $date
     * @return Carbon\Carbon
     */
    function carbon($date = null)
    {
        if (!empty($date)) {
            if ($date instanceof DateTime) {
                return Carbon::instance($date);
            }

            return Carbon::parse(date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date))));
        }

        return Carbon::now();
    }
}

if (!function_exists('ukDate')) {
    function ukDate($datetime = null, $timestamp = false)
    {
        $datetime = $datetime ? $datetime : Carbon::now();
        $format = $timestamp ? 'd/m/Y H:i' : 'd/m/Y';
        $timestamp = $timestamp ? 'Y-m-d H:i:s' : 'Y-m-d';
        return Carbon::createFromFormat($format, $datetime)->format($timestamp);
    }
}

if (!function_exists('brDate')) {
    /**
     * Converte data para formato brasileiro.
     *
     * @param mixed $date
     * @param mixed $timestamp
     * @return Carbon\Carbon
     */
    function brDate($datetime = null, $timestamp = false)
    {
        $datetime = $datetime ? $datetime : Carbon::now();
        $timestamp = $timestamp ? 'd/m/Y H:i' : 'd/m/Y';
        return Carbon::parse($datetime)->format($timestamp);
    }
}

if (!function_exists('floatToMoney')) {
    /**
     * Converte float em money.
     *
     * @param string $str
     * @return string
     */
    function floatToMoney(float $value)
    {
        return number_format($value, 2, ',', '.');
    }
}

if (!function_exists('moneyToFloat')) {
    /**
     * Converte money para float.
     *
     * @param string $str
     * @return string
     */
    function moneyToFloat(string $value)
    {
        if (!$value) return 0;

        $source = array('.', ',');
        $replace = array('', '.');
        return str_replace($source, $replace, $value);
    }
}

function moeda($get_valor)
{
    if (!$get_valor) return 0;

    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $get_valor);
    return $valor;
}

function money($get_valor)
{
    if ($get_valor) {
        $valor = number_format($get_valor, 2, ',', '.');
    } else {
        $valor = 0;
    }
    return $valor;
}

if (!function_exists('removeMask')) {
    /**
     * Remover máscara.
     *
     * @param string $str
     * @return string
     */
    function removeMask($str)
    {
        if (!$str) {
            return $str;
        }

        return preg_replace('/[^A-Za-z0-9]/', '', $str);
    }
}

if (!function_exists('insertMask')) {
    /**
     * Inserir máscara personalizada.
     *
     * @param string $str
     * @param string $mask
     * @return string
     */
    function insertMask(string $str, string $mask)
    {
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}

if (!function_exists('nifMask')) {
    /**
     * Inserir máscara na identidade.
     *
     * @param string $str
     * @return string
     */
    function nifMask(string $str)
    {
        $str = removeMask($str);

        if (strlen($str) == 11) {
            $mask = '###.###.###-##';
        } else {
            $mask = '##.###.###/####-##';
        }

        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}

if (!function_exists('phoneMask')) {
    /**
     * Inserir máscara no telefone.
     *
     * @param string $str
     * @return string
     */
    function phoneMask(string $str)
    {
        $str = removeMask($str);

        $mask = '(##) #####-####';

        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}

if (!function_exists('zipCodeMask')) {
    /**
     * Inserir máscara no código postal.
     *
     * @param string $str
     * @return string
     */
    function zipCodeMask(string $str)
    {
        $str = removeMask($str);

        $mask = '#####-###';

        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}
