<?php
$var = 'Apple
 Dell
 HP
 Hyundai Technology
 Kingston
 Lenovo
 Toshiba
 Western Digital';
$var = str_replace('
 ',',',$var);
$exp = explode(',',$var);
foreach ($exp as $brand) {
    echo '\''.$brand.'\',';
}