<?php

include_once('node_modules/eta-php/H.php');
include_once('node_modules/phplumbermill/log.php');
error_reporting(E_ALL & ~E_NOTICE);

class Boiler {
    public static function refresh($pages = []) {
        $start = microtime(true);

        foreach ($pages as $dest => $page) {
            $model = $page['model'] ?: [];
            $src = $page['src'];
            $flatfile = H::render($src, $model, true) or die("Missing view $src!");
            $template = fopen($dest, 'w') or die("Unable to open file $dest!");
            fwrite($template, $flatfile);
            fclose($template);
        }

        $end = microtime(true);
        $renderTime = round($end - $start, 6);
        log::end("render completed in $renderTime seconds");
    }
}
