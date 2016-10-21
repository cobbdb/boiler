<?php

$public = $_SERVER['DOCUMENT_ROOT'];
$modules = "$public/../php_modules";
include_once("$modules/eta-php/H.php");
include_once("$modules/phplumbermill/log.php");
error_reporting(E_ALL & ~E_NOTICE);

class Boiler {
    /**
     * ## refresh(base, pages)
     * @param {string} base Path to site-wide base template.
     * @param {array<dest, array<view, [model]>>} pages
     * @example
     *  refresh('./base.html', [
     *      '../public/page.html' => [
     *          'view' => '../private/view.html',
     *          'model' => []
     *      ]
     *  ]);
     */
    public static function refresh($base, $pages = []) {
        $start = microtime(true);

        foreach ($pages as $dest => $page) {
            $model = $page['model'] ?: [];
            $view = $page['view'];
            $flatfile = H::render($base, [
                'body' => H::render($view, $model, true) or die("Missing view $src!")
            ], true) or die("Missing base template $base!");
            $template = fopen($dest, 'w') or die("Unable to open file $dest!");
            fwrite($template, $flatfile);
            fclose($template);
        }

        $end = microtime(true);
        $renderTime = round($end - $start, 6);
        log::end("render completed in $renderTime seconds");
    }
}
