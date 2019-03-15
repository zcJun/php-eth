<?php
/**
 * zcj编写
 * 以太坊开发技术交流群
 * 大家一起相互学习
 * QQ群：588927820
 * ETH 主网捐助地址：0xE573ee84bAf2939572dB0A8FA296e559d013bbE3
 */
namespace Lib;

class Tool{
    /**
     * 字符串长度 ‘0’左补齐
     * @param string $str   原始字符串
     * @param int $bit      字符串总长度
     * @return string       真实字符串
     */
    static function fill0($str, $bit=64){
        if(!strlen($str)) return "";
        $str_len = strlen($str);
        $zero = '';
        for($i=$str_len; $i<$bit; $i++){
            $zero .= "0";
        }
        $real_str = $zero . $str;
        return $real_str;
    }
}