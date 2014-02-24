<?php 
/**
 * Redis Cache Helper
 *
 * @modify 2014/01/09
 */

// 加载配置文件
include_once('rconfig.php');




class Rcache {
    /**
     * 连接
     *
     * @var object|null
     */
    protected static $_conn = array();

    /**
     * 本地环境配置
     *
     * @var array
     */
    protected static $_dev_host = array('host'=>'192.168.2.245', 'port'=>'6379');

    /**
     * 生产环境配置
     *
     * @var array
     */
    protected static $_main_host = array('host'=>'10.182.52.58',   'port'=>'6379');


    function __call($name, $arguments) {
        $hash       = md5($arguments[0]);
        $dbpre      = hexdec(substr($hash, 0, 1));

        // 检查redis key是否已经配置
        $is_configed = 0;
        $all_constants = get_defined_constants(true);
        $all_constants = $all_constants['user'];
        $all_redis_key = array();

        foreach ($all_constants as $key => $item) {
            if (strstr($key, 'REDISC') && strncasecmp($item, $arguments[0], count($arguments[0])) == 0) {
                $is_configed = 1;
                break;
            }
        }

        if ($is_configed == 0) {
            throw new Exception('please config you redis key first.');
        }


        self::init($dbpre);

        $redis = self::$_conn[$dbpre];
        switch (count($arguments)) {
            case 1 :
                return $redis->$name($arguments[0]);
            case 2 :
                return $redis->$name($arguments[0], $arguments[1]);
            case 3 :
                return $redis->$name($arguments[0], $arguments[1], $arguments[2]);
            case 4 :
                return $redis->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
        }

     }



    /**
     * 初始化
     *
     * @return object
     */
    public static function init($dbpre = 0)
    {
        if(isset(self::$_conn[$dbpre])) return self::$_conn[$dbpre];

        $server = ENVIRONMENT == 'development' ? self::$_dev_host : self::$_main_host;

        self::$_conn[$dbpre] = new Redis();

        $conn_status = self::$_conn[$dbpre]->connect($server['host'], $server['port']);
        if(!$conn_status) {
            self::$_conn[$dbpre]->connect($server['host'], $server['port']);
        }

        self::$_conn[$dbpre]->select($dbpre);
        return self::$_conn[$dbpre];
    }

}
