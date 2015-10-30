<?php
namespace Awesome;

class ArrayUtil{
    public static function find_key_by_value($needle, $haystack){
        $result = null;
        foreach ($haystack as $key => $value) {
            if(is_array($value)){
                $result = self::find_key_by_value($needle, $value);
            }
            if ($value === $needle) {
                $result =  $key;
            }
        }
        return $result;
    }

    public static function find_index_by_value($needle, $haystack){
        $keys = self::get_keys($haystack);
        $key = self::find_key_by_value($needle, $haystack);
        $result = self::find_key_by_value($key, $keys);
        return $result;
    }

    public static function get_keys($array){
        $result = false;
        $i = 0;
        foreach($array as $key => $value){
            if(is_array($value)){
                $result[$i] = self::get_keys($value);
            }else{
                $result[$i] = $key;
            }
            $i++;
        }
        return $result;
    }
}