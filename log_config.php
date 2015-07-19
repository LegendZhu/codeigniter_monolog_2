<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['threshold_extra'] = TRUE;//是否记录扩展信息 关闭后下边记录的扩展信息都不显示

$config['introspection_processor'] = TRUE; // 记录类名方法

$config['record_memory_info'] = FALSE;// 是否记录内存使用信息

if(ENVIRONMENT == 'production'){
    $config['handlers'] = array('file');//多处写预留
    $config['threshold'] = '6'; // 'ERROR' => '1', 'WARNING' => '2', 'NOTICE' => '3', 'INFO' => '4', 'DEBUG' => '5', 'ALL' => '6'
    $config['log_path'] = '/data/logs/site/';
}else{
    $config['handlers'] = array('file', 'chrome_logger');//多处写预留
    $config['threshold'] = '5'; // 'ERROR' => '1', 'WARNING' => '2', 'NOTICE' => '3', 'INFO' => '4', 'DEBUG' => '5', 'ALL' => '6'
    $config['log_path'] = APPPATH . 'logs/';
}

define('LOG_LEVEL', $config['threshold']);

$config['log_name'] = 'log';//日志名前缀

$config['log_cut'] = 'h';//d:按日切割,h:按小时切割

$config['exclusion_list'] = array();//过滤日志

/**
 * Error Logging Interface
 *
 * We use this as a simple mechanism to access the logging
 * class and send messages to be logged.
 *
 * @access	public
 * @return	void
 */
if ( ! function_exists('log_message'))
{
    function log_message($level = 'error', $message, $context = array(), $php_error = FALSE)
    {
        static $_log;

        if (config_item('log_threshold') == 0)
        {
            return;
        }

        if(defined('LOG_LEVEL'))
        {
            $log_level_info = array('ERROR' => '1', 'WARNING' => '2', 'NOTICE' => '3', 'INFO' => '4', 'DEBUG' => '5', 'ALL' => '6');

            if(isset($log_level_info[strtoupper($level)]) && LOG_LEVEL < (int) $log_level_info[strtoupper($level)])
            {
                return;
            }
        }

        $_log =& load_class('Log');// change to use log
        $_log->write_log($level, $message, $context, $php_error);
    }
}