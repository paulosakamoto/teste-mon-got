<?php

/**
 * @param string $s
 * @return bool
 */
function isPalindrome($s)
{
    return $s === strrev($s);
}

/**
 * @param string $key
 * @throws Exception
 */
function validateKey($key)
{
    $len = strlen($key);
    if ($len < 1 || $len > 100) {
        throw new Exception('A chave deve ter comprimento entre 1 e 100 caracteres');
    }
    if (preg_match('/[^a-z]+/', $key)) {
        throw new Exception('A chave deve conter apenas letras minúsculas.');
    }
}

/**
 * @param string $key
 * @return bool
 */
function isValidKey($key)
{
    try {
        validateKey($key);
    } catch (Exception $e){
        return false;
    }

    if (isPalindrome($key)) {
        return true;
    }
    $chars = $split = str_split($key);
    $pairs = [];
    while(($char1 = current($chars))){
        $key1 = key($chars);
        $pairs[$key1] = ['char' => $char1, 'pair' => false];
        next($chars);
        unset($chars[$key1]);
        $copy = $chars;
        while(($char2 = current($copy))){
            $key2 = key($copy);
            if ($char1 === $char2) {
                $pairs[$key1]['pair'] = $char2;
                unset($chars[$key2]);
                break;
            }
            next($copy);
        }
    }
    $alone = 0;
    foreach ($pairs as $char){
        if (!$char['pair']) {
            $alone++;
        }
    }
    return $alone <= 1;
}

/**
 *
 */
function isValidKeyTest()
{
    echo 'Iniciando os testes...', PHP_EOL, PHP_EOL;

    $keys = [
        'aaabbbb' => true,
        'cdefghmnopqrstuvw' => false,
        'cdcdcdcdeeeef' => true,
    ];

    $finalCheck = true;
    foreach ($keys as $key => $result) {
        $check = isValidKey($key);
        $finalCheck = $finalCheck && $check === $result;
        echo sprintf('Testando a chave %s.%s', $key, PHP_EOL);
        echo sprintf('Resultado esperado %s.%s', $result ? 'true' : 'false', PHP_EOL);
        echo sprintf('Resultado obtido %s.%s', $check ? 'true' : 'false', PHP_EOL);
        echo sprintf('Passou? %s%s%s', $check === $result ? 'sim' : 'não', PHP_EOL, PHP_EOL);
    }

    echo sprintf('Resultado final: %s%s', $finalCheck ? 'funciona' : 'não funciona', PHP_EOL);
}

isValidKeyTest();
