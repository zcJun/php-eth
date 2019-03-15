# ethereum-client
ethereum rpc client, offline sign, php

PHP版的以太坊RPC客户端，支持离线交易、生成私钥与地址。你不用专门购买一台服务器来运行以太坊客户端。

你可以使用以太坊公共节点，比如：https://infura.io 你可以将你用户的私钥加密存储在数据库中，使用的时候取出解密，直接发送交易。

这样不仅高效率且安全（如果你执意要使用服务器来运行以太坊客户端，这个项目也支持）。

# 安装
composer.json
```
{
    "require": {
        "myxtype/ethereum-client": "dev-master"
    }
}
```

然后`composer update`即可。

> 或者直接 `composer require myxtype/ethereum-client:dev-master`

# 使用
详细使用请参考`examples`文件夹

你可以在这里：https://infura.io/docs 看到更多可使用的RPC方法。

# 初始化

初始化你可以直接给一个RPC的连接地址，或者参考`GuzzleHttp Options`给出一些自定义的选项。

```php
use xtype\Ethereum\Client as EthereumClient;

$client = new EthereumClient('https://kovan.infura.io/v3/a0d810fdff64493baba47278f3ebad27');
// or
// $client = new EthereumClient('http://127.0.0.1:8545');
```

GuzzleHttp Options.
```php
$client = new EthereumClient([
    'base_uri' => 'https://kovan.infura.io/v3/a0d810fdff64493baba47278f3ebad27',
    'timeout' => 20,
]);
```

# RPC

使用RPC接口非常简单，你直接参考 https://ethereum.gitbooks.io/frontier-guide/content/rpc.html 这里列出的接口使用。

你需要根据RPC文档设置参数，注意数字一般都需要转为十六进制。
```php
// net_version
print_r($client->net_version());
// eth_getBlockByNumber
print_r($client->eth_getBlockByNumber('0x' . dechex(2), false));
```

你也可以使用额外的RPC方法，当然这需要你的私有节点，如果你用的公共节点则没有此方法。
```php
print_r($client->personal_newAccount());
```

你可以直接使用这个类提供的离节点创建地址与私钥。
```php
// You can to create an address offline
list($address, $privateKey) = $client->newAccount();
```

# 离线创建交易并用节点广播

你可以在你本地直接发送交易，而不需要私有节点，你只需要连接到公共节点就行。

```php
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
```
