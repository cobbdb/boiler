<?php

class log {
    private static $log = '';
    private static $indent = 0;
    private static function spacing() {
        $spacing = '';
        for ($i = 0; $i < self::$indent; $i += 1) {
            $spacing .= "\t";
        }
        return $spacing;
    }

    public static function title($msg) {
        self::$log .= self::spacing() . $msg . " ...\n";
        self::$indent += 1;
    }
    public static function write($msg) {
        self::$log .= self::spacing() . '... ' . $msg . "\n";
    }
    public static function end($msg) {
        self::write($msg);
        self::$indent -= 1;
        if (self::$indent == 0) {
            self::close();
        }
    }

    public static function close() {
        $stream = fopen('event.log', 'w') or die('Unable to open file!');
        fwrite($stream, self::$log);
        fclose($stream);
    }
}
