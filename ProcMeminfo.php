<?php 

namespace ProcMeminfo;
class ProcMeminfo {
    const MAP = [
        
    ];
    public static function get () {
        $fh = fopen('/proc/meminfo', 'r');
        $out = [];
        while ($line = fgets($fh)) {
            list($key, $val) = explode(':', $line, 2);
            $key = self::MAP[$key] ?? $key;
            
            $val = trim($val);
            $chunk = explode(' ', $val, 2);
            $val = intval($chunk[0]);
            if (count($chunk) > 1) {
                $suffix = strtolower($chunk[1]);
                $multipliers = ['kb' => 1024, 'mb' => 1024*1024, 'gb' => 1024*1024*1024, 'tb' => 1024*1024*1024*1024];
                $val *= $multipliers[$suffix] ?? 1;
            }
            
            $out[$key] = $val;
        }
        fclose ($fh);
        
        return $out;
    }
}