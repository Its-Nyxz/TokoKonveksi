<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=wonogiri');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'key: 7ff8406f12c653758df1a5fa6d6bf474'
]);
$res = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $http_code . "\n";
echo "Response: \n";
echo $res . "\n";
