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
/*
 * https://mainnet.infura.io/v3/31090cb004d34600b113fa3e4203e9b5
 *https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5
 *https://kovan.infura.io/v3/31090cb004d34600b113fa3e4203e9b5
 *https://rinkeby.infura.io/v3/31090cb004d34600b113fa3e4203e9b5
 *https://goerli.infura.io/v3/31090cb004d34600b113fa3e4203e9b5
 * */

$client = new EthereumClient([
    'base_uri' => 'https://ropsten.infura.io/v3/31090cb004d34600b113fa3e4203e9b5',
    'timeout' => 30,
]);
echo "<pre>";
//print_r($client->eth_getBlockByNumber('0x' . dechex(5199525), false));
$client->addPrivateKeys(['0090C437D372DF6625FE3D1E9EE34FD3C1D94DCB9F249EC7D6705964C1C52141']);

// 2. 建立您的交易
$trans = [
    "from" => '0xa4e338dF6c6d9Eb13a6fD4B06F87E7BFD757bb1d',
    "to" => '0xAa80c90f2b91138d1afD034D8fB63bF5FA9510d9',
    "value" => Utils::ethToWei('0.0001', true),
    "data" => '0x',
];
// 你可以设定汽油，nonce，gasprice
$trans['gas'] = dechex(hexdec($client->eth_estimateGas($trans)) * 1.5);
$trans['gasPrice'] = $client->eth_gasPrice();
$trans['nonce'] = $client->eth_getTransactionCount('0xa4e338dF6c6d9Eb13a6fD4B06F87E7BFD757bb1d', 'pending');
// 3. 发送您的交易
// 如果需要服务器，也可以使用eth_sendTransaction
$txid = $client->sendTransaction($trans);

// 4. 如果没有错的话
// 你会在这里看到txid。喜欢 string(66) "0x1adcb80b413bcde285f93f0274e6cf04bc016e8813c8390ff31a6ccb43e75f51"
print_r($txid);

// 5. 你会…
// https://ethereum.gitbooks.io/frontier-guide/content/rpc.html#eth_gettransactionreceipt
print_r($client->eth_getTransactionReceipt($txid));