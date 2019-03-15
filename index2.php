<?php

/**
 * zcj编写
 * 以太坊开发技术交流群
 * 大家一起相互学习
 * QQ群：588927820
 * ETH 主网捐助地址：0xE573ee84bAf2939572dB0A8FA296e559d013bbE3
 */

require_once "vendor/autoload.php";

use xtype\Ethereum\Client as EthereumClient;
use xtype\Ethereum\Utils;

$client = new EthereumClient([
    'base_uri' => 'https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5',
    'timeout' => 30,
]);
echo "<pre>";
$cv = $client->web3_clientVersion();
print_r($cv);
echo "<br>";
$a = "";
print_r($a);
$nv = $client->eth_getBalance('0xa4e338dF6c6d9Eb13a6fD4B06F87E7BFD757bb1d','latest');
$nv_we = Utils::hexToDec($nv);
print_r($nv_we);
echo "<br>";
$s = Utils::weiToEth($nv_we,false);
print_r($s);
echo "<br>";