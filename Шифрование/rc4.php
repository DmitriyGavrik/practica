<?php

/**
������� rc4_init_s($key)
�������������� S-����, ����������� ��� ������ 8-��������
��������������� rc4, � ������� ����� $key
���������� ����������������� S-����
 */
function rc4_init_s($key) {
    // ������������� ���������������� ������� $k
    $k = unpack('C*', $key);//����������� ������ �� �������� ������ � ������� (�* - ������)

    //array_unshift - ��������� ���� ��� ��������� ��������� � ������ �������
    //array_shift - ��������� ������ ������� �������
    array_unshift($k, array_shift($k));

    $n = sizeof($k);
    for ($i = $n; $i < 0x100; $i++) $k[$i] = $k[$i % $n];
    for ($i--; $i >= 0x100; $i--) $k[$i & 0xff] ^= $k[$i];
    // ��������������� ���������� S-�����
    $s = array();
    for ($i = 0; $i < 0x100; $i++) $s[$i] = $i;
    $j = 0;
    // ������������� S-�����
    for ($i = 0; $i < 0x100; $i++) {
        $j = ($j + $s[$i] + $k[$i]) & 0xff;
        // ������������ $s[$i] � $s[$j]
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;
    }
    return $s;
}

/**
������� rc4_crypt($text, $key)
��������� ����������/������������� ������/���������� $text
� ������� 8-������� ���������� ��������������� rc4, ���������
� �������� ����� ���������� ������ $key
���������� �������������/�������������� �����/���������
 */
function rc4_crypt($text1, $key) {
    $s = rc4_init_s($key); // ������������� s-�����
    $n = strlen($text1);
    $text2 = '';
    $i = $j = 0;
    for ($k = 0; $k < $n; $k++) {
        $i = ($i + 1) & 0xff;
        $j = ($j + $s[$i]) & 0xff;
        // ������������ $s[i] � $s[$j]
        $tmp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $tmp;
        // ���������/������ �����
        $text2 .= $text1{$k} ^ chr($s[$i] + $s[$j]);
    }
    return $text2;
}

/**
������� rc4_encrypt($plain_text, $password)
������������� ������ $plain_text � ������� 8-�������� ���������
���������� rc4, ��������� � �������� ������ ������ $password
���������� base64-encoded ���������
 */
function rc4_encrypt($plain_text, $password) {
    return base64_encode(rc4_crypt($plain_text, $password));
}

/**
������� rc4_decrypt($enc_text, $password)
�������������� base64-encoded ��������� $enc_text � �������
8-�������� ��������� ���������� rc4, ��������� � ��������
������ ������ $password
 */
function rc4_decrypt($enc_text, $password) {
    return rc4_crypt(base64_decode($enc_text), $password);
}