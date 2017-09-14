<?php
/**
 * Created by PhpStorm.
 * User: trilok
 * Date: 28/11/16
 * Time: 5:29 PM
 */

function getBrowserName()
{
    if (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'MSIE') !== FALSE)
        $brawserName = 'Internet explorer';
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Trident') !== FALSE) //For Supporting IE 11
        $brawserName = 'Internet explorer';
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Firefox') !== FALSE)
        $brawserName = 'Mozilla Firefox';
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Chrome') !== FALSE)
        $brawserName = 'Google Chrome';
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Opera Mini') !== FALSE)
        $brawserName = "Opera Mini";
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Opera') !== FALSE)
        $brawserName = "Opera";
    elseif (strpos(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"", 'Safari') !== FALSE)
        $brawserName = "Safari";
    else
        $brawserName = 'Something else';
    return $brawserName;
}


function getClientIP()
{
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;


}


function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_IPV6) === false) {
        return false;
    }
    return true;
}

function getLocationUserFromIP($requestorIP)
{
    $geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $requestorIP;
    $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
    $ipinfo = array();

    $ipinfo["country"] = strtolower($addrDetailsArr['geoplugin_countryName']);
    $ipinfo["city"] = strtolower($addrDetailsArr['geoplugin_city']);
    $ipinfo["state"] = strtolower($addrDetailsArr['geoplugin_regionName']);
    $ipinfo["userIP"] = $requestorIP;
    $ipinfo["countryCode"] =  $addrDetailsArr['geoplugin_countryCode'];
    return $ipinfo;
}