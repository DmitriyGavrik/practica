<?php

/**
функция rc4_init_s($key)
инициализирует S-блок, необходимый для работы 8-битового
криптоалгоритма rc4, с помощью ключа $key
Возвращает инициализированнй S-блок
 */
function rc4_init_s($key) {
    // инициализация вспомогательного массива $k
    $k = unpack('C*', $key);//Распаковать данные из бинарной строки в массивб (С* - формат)

    //array_unshift - Добавляет один или несколько элементов в начало массива
    //array_shift - извлекает первый элемент массива
    array_unshift($k, array_shift($k));

    $n = sizeof($k);
    for ($i = $n; $i < 0x100; $i++) $k[$i] = $k[$i % $n];
    for ($i--; $i >= 0x100; $i--) $k[$i & 0xff] ^= $k[$i];
    // предварительное заполнение S-блока
    $s = array();
    for ($i = 0; $i < 0x100; $i++) $s[$i] = $i;
    $j = 0;
    // инициализация S-блока
    for ($i = 0; $i < 0x100; $i++) {
        $j = ($j + $s[$i] + $k[$i]) & 0xff;
        // перестановка $s[$i] и $s[$j]
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;
    }
    return $s;
}

/**
функция rc4_crypt($text, $key)
выполняет шифрование/расшифрование текста/шифртекста $text
с помощью 8-битного потокового криптоалгоритма rc4, используя
в качестве ключа шифрования строку $key
Возвращает зашифрованный/расшифрованный текст/шифртекст
 */
function rc4_crypt($text1, $key) {
    $s = rc4_init_s($key); // инициализация s-блока
    $n = strlen($text1);
    $text2 = '';
    $i = $j = 0;
    for ($k = 0; $k < $n; $k++) {
        $i = ($i + 1) & 0xff;
        $j = ($j + $s[$i]) & 0xff;
        // перестановка $s[i] и $s[$j]
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;
        // наложение/снятие гаммы
        $text2 .= $text1{$k} ^ chr($s[$i] + $s[$j]);
    }
    return $text2;
}

/**
функция rc4_encrypt($plain_text, $password)
зашифровывает строку $plain_text с помощью 8-битового алгоритма
шифрования rc4, используя в качестве пароля строку $password
Возвращает base64-encoded шифртекст
 */
function rc4_encrypt($plain_text, $password) {
    return base64_encode(rc4_crypt($plain_text, $password));
}

/**
функция rc4_decrypt($enc_text, $password)
расшифровывает base64-encoded шифртекст $enc_text с помощью
8-битового алгоритма шифрования rc4, используя в качестве
пароля строку $password
 */
function rc4_decrypt($enc_text, $password) {
    return rc4_crypt(base64_decode($enc_text), $password);
}