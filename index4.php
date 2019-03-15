<?php

/**
 * zcj编写
 * 以太坊开发技术交流群
 * 大家一起相互学习
 * QQ群：588927820
 * ETH 主网捐助地址：0xE573ee84bAf2939572dB0A8FA296e559d013bbE3
 */

require_once "vendor/autoload.php";
require_once "Lib/Keccak.php";
require_once "Lib/Tool.php";


use xtype\Ethereum\Client as EthereumClient;
use xtype\Ethereum\Utils;
use kornrunner\Keccak;
use Lib\Tool;
//-----------------------代币转账-----------------------

$client = new EthereumClient([
    'base_uri' => 'https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5',
    'timeout' => 30,
]);

$from = '0xa4e338dF6c6d9Eb13a6fD4B06F87E7BFD757bb1d';//发送代币地址
$address = '0xAa80c90f2b91138d1afD034D8fB63bF5FA9510d9';//接收代币地址
$contract = '0x51D4641CA5f5987Eb6FaCDb6Ac64E2Fda0fa23a1';//合约地址
$num = 1;

//print_r($client->eth_getBlockByNumber('0x' . dechex(5199525), false));
$client->addPrivateKeys(['0090C437D372DF6625FE3D1E9EE34FD3C1D94DCB9F249EC7D6705964C1C52141']);

// 2. 建立您的交易
$trans = [
    "from" => $from,
    "to" => $contract,//合约地址
    "value" => '0x0',
//    "data" => '0x',
];

//tranfer的abi名称
$str = "transfer(address,uint256)";
//SHA-3，之前名为Keccak算法，是一个加密杂凑算法。
$hash = Keccak::hash("transfer(address,uint256)",256);
$hash_sub = mb_substr($hash,0,8,'utf-8');
//接收地址
$fill_from = Tool::fill0(Utils::remove0x($address));
//转账金额
$num10 = Utils::ethToWei($num);
$num16 = Utils::decToHex($num10);
$fill_num16 = Tool::fill0(Utils::remove0x($num16));

//开始拼接
$trans['data'] = "0x" . $hash_sub . $fill_from . $fill_num16;

// 你可以设定汽油，nonce，gasprice
$trans['gas'] = dechex(hexdec($client->eth_estimateGas($trans)) * 1.5);
$trans['gasPrice'] = $client->eth_gasPrice();
$trans['nonce'] = $client->eth_getTransactionCount($from, 'pending');
//print_r($trans);
//return;
// 3. 发送您的交易
// 如果需要服务器，也可以使用eth_sendTransaction
$txid = $client->sendTransaction($trans);

// 4. 如果没有错的话
// 你会在这里看到txid。喜欢 string(66) "0x1adcb80b413bcde285f93f0274e6cf04bc016e8813c8390ff31a6ccb43e75f51"
print_r($txid);

// 5. 你会…
// https://ethereum.gitbooks.io/frontier-guide/content/rpc.html#eth_gettransactionreceipt
print_r($client->eth_getTransactionReceipt($txid));
