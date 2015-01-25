<?php namespace Champion\Utils;

trait Environment
{
    public static $localIps = array(
        '127.0.0.1',
        '::1',
    );

    public static function isLocalEnvironment()
    {
        $ipAddress = self::getIpAddress();
        return in_array($ipAddress, self::$localIps);
    }

    private static function getIpAddress()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        // Return unreliable IP address since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }
}
