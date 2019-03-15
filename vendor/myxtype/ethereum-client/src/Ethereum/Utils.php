<?php

namespace xtype\Ethereum;

use kornrunner\Keccak;

class Utils
{
    /**
     * 移除0x
     */
    public static function remove0x($value)
    {
        if (strtolower(substr($value, 0, 2)) == '0x') {
            return substr($value, 2);
        }
        return $value;
    }

    /**
     * 添加前缀
     */
    public static function add0x($value)
    {
        return '0x' . self::remove0x($value);
    }

    /**
     * 根据公钥生成地址
     */
    public static function pubKeyToAddress($pubkey)
    {
        return '0x' . substr(Keccak::hash(substr(hex2bin($pubkey), 1), 256), 24);
    }

    /**
     * ether转wei
     */
    public static function ethToWei($value, $hex = false)
    {
        $value = bcmul($value, '1000000000000000000');
        if ($hex) {
            return self::decToHex($value, $hex);
        }
        return $value;
    }

    /**
     * wei转ether
     */
    public static function weiToEth($value, $hex = false)
    {
        if (strtolower(substr($value, 0, 2)) == '0x') {
            $value = self::hexToDec(self::remove0x($value));
        }
        $value = bcdiv($value, '1000000000000000000', 18);
        if ($hex) {
            return '0x' . self::decToHex($value);
        }
        return $value;
    }

    /**
     * 转为十六进制
     * @param  string|number  $value 十进制的数
     * @param  boolean $mark  是否加0x头
     * @return string
     */
    public static function decToHex($value, $mark = true)
    {
        $hexvalues = [
            '0','1','2','3','4','5','6','7',
            '8','9','a','b','c','d','e','f'
        ];
        $hexval = '';
        while($value != '0') {
            $hexval = $hexvalues[bcmod($value, '16')] . $hexval;
            $value = bcdiv($value, '16', 0);
        }

        return ($mark ? '0x' . $hexval : $hexval);
    }

    /**
     * 转为十进制
     * @param  string $number 十六进制的数
     * @return string
     */
    public static function hexToDec($number)
    {
        // 如果有0x去除它
        $number = self::remove0x(strtolower($number));
        $decvalues = [
            '0' => '0', '1' => '1', '2' => '2',
            '3' => '3', '4' => '4', '5' => '5',
            '6' => '6', '7' => '7', '8' => '8',
            '9' => '9', 'a' => '10', 'b' => '11',
            'c' => '12', 'd' => '13', 'e' => '14',
            'f' => '15'];
        $decval = '0';
        $number = strrev($number);
        for($i = 0; $i < strlen($number); $i++) {
            $decval = bcadd(bcmul(bcpow('16', $i, 0), $decvalues[$number{$i}]), $decval);
        }
        return $decval;
    }

}
