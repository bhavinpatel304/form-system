<?php
namespace App\Http\Helpers;

use App\Client;
use App\Role;
use Illuminate\Support\Facades\Auth;

class Common
{

    /*
    Usage in controller ==> Common::$variable
    Usage in View (new \App\Http\Helpers\Common)::$variable

    Usage in controller ==> Common::funcName($params)
    Usage in View (new \App\Http\Helpers\Common)->funcName($params)
     */

    /* for status */
    static $intStatusActive   = 1;
    static $intStatusInActive = 2;

    /* for user roles */
    static $intRoleAdmin   = 1;
    static $intRolecompany = 2;
    static $intRoleUser    = 3;

    /* for form components */
    static $intPoll            = 1;
    static $intCheckboxList    = 2;
    static $intMatrix          = 3;
    static $intTextArea        = 4;
    static $intTextBox         = 5;
    static $intRadioButtonList = 6;
    static $intCheckbox        = 7;
    static $intDropDownList    = 8;

    public static function isAdmin()
    {
        return Auth::User()->role_id == self::$intRoleAdmin ? true : false;
    }
    public static function getQuery($obj)
    {
        $sql = $obj->toSql();
        foreach ($obj->getBindings() as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql   = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }
    public static function show($array, $exit = false)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if ($exit) {
            exit;
        }
    }
    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    public static function trim_text($input, $length, $ellipses = true, $strip_html = true)
    {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space   = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }
    public static function writeLogFile($log_msg = '')
    {
        $log_time     = date('Y-m-d h:i:s A');
        $log_start    = "\n************** Start Log For Day : '" . $log_time . "'**********\n";
        $log_end      = "\n************** End Log For Day : '" . $log_time . "'**********\n";
        $log_filename = env('UPLOAD_PATH') . "log";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log_start . "\n", FILE_APPEND);
        if (is_string($log_msg)) {
            file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
        } else {
            file_put_contents($log_file_data, print_r($log_msg, 1) . "\n", FILE_APPEND);
        }
        file_put_contents($log_file_data, $log_end . "\n", FILE_APPEND);
        chmod($log_file_data, 0777);
    }
    public static function r($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    public static function re($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        exit;
    }

    /*
    Usage in controller ==> Common::getRoles()
     */
    public static function getRoles($columnName = '', $orderBy = '')
    {
        if ($columnName == '') {
            $columnName = 'id';
        }

        if ($orderBy == '') {
            $orderBy = 'ASC';
        }

        $roles = Role::select(['id', 'name', 'status'])->orderBy($columnName, $orderBy)->where('status', self::$intStatusActive)->get();

        return $roles;
    }

    /*
    Usage in controller ==> Common::getClients()
     */
    public static function getClients($columnName = '', $orderBy = '',$clientId = NULL)
    {
        if ($columnName == '') {
            $columnName = 'id';
        }

        if ($orderBy == '') {
            $orderBy = 'ASC';
        }
        
        if($clientId){
            $roles = Client::orderBy($columnName, $orderBy)->where('id','=',$clientId)->get();
        }else {
            
            $roles = Client::orderBy($columnName, $orderBy)->where('status', self::$intStatusActive)->get();
        }

        

        return $roles;
    }

     /*
    Usage in controller ==> Common::getAllClients()
     */
    public static function getAllClients($columnName = '', $orderBy = '',$clientId = NULL)
    {
        if ($columnName == '') {
            $columnName = 'id';
        }

        if ($orderBy == '') {
            $orderBy = 'ASC';
        }
      
        $clients = Client::orderBy($columnName, $orderBy)->get();
        return $clients;       
    }

}
