<?php
function get_data($url)
{
    $ch = curl_init();
    $timeout = 0;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$litecoin_url='https://btc-e.com/api/2/ltc_usd/ticker';
$bitcoin_url='https://coinbase.com/api/v1/prices/spot_rate';
$doge_url='http://pubapi.cryptsy.com/api.php?method=singlemarketdata&marketid=132';



$litecoin = json_decode(get_data($litecoin_url));
$bitcoin = json_decode(get_data($bitcoin_url));
$doge = json_decode(get_data($doge_url));

$ltc_price = round(floatval($litecoin->ticker->avg),2);
$btc_price = $bitcoin->amount;
$dogeprice = $doge->return->markets->DOGE->lasttradeprice;

$dogefloat = round(floatval($dogeprice)*floatval($btc_price),5);

$response['content'] = "LTC:  $".$ltc_price."\nBTC:  $".$btc_price."\nDOGE: $".strval($dogefloat);
$response['refresh_frequency'] = 15;
print json_encode($response);
