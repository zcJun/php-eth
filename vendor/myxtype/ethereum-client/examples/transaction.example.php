<?php
require_once __DIR__ . '/../vendor/autoload.php';

use xtype\Ethereum\Client;
use xtype\Ethereum\Utils;

$client = new Client('https://kovan.infura.io/v3/a0d810fdff64493baba47278f3ebad27');

// 1. Fill in the private key you want to use
// Like 'C34ADB7969999FE9FF327ED73E8A7CD58BF712CA12CC489DD533839229E567EB'
$client->addPrivateKeys(['C34ADB79691CBFE9FF327ED73E8A7CD58BF712C012CC489DD533839119E567EB']);
// 2. Build Your Transaction
$trans = [
    "from" => '0x69A34E519D9944CA7E3B55278a4EaF744769198C',
    "to" => '0x69A34E519D9944CA7E3B55278a4EaF744769198C',
    "value" => Utils::ethToWei('0.01', true),
    "data" => '0x',
];
// And you can set gas, nonce, gasPrice
$trans['gas'] = dechex(hexdec($client->eth_estimateGas($trans)) * 1.5);
$trans['gasPrice'] = $client->eth_gasPrice();
$trans['nonce'] = $client->eth_getTransactionCount('0x69A34E519D9944CA7E3B55278a4EaF744769198C', 'pending');

// 3. Send Your Transaction
// or use eth_sendTransaction if you need your server.
$txid = $client->sendTransaction($trans);

// 4. If there is no mistake
// you will see txid here. Like string(66) "0x1adcb80b413bcde285f93f0274e6cf04bc016e8813c8390ff31a6ccb43e75f51"
var_dump($txid);

// 5. And you will ...
// https://ethereum.gitbooks.io/frontier-guide/content/rpc.html#eth_gettransactionreceipt
var_dump($client->eth_getTransactionReceipt($txid));
