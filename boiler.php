<?php

include_once("$MODULES/eta/H.php");
include_once("$MODULES/lumbermill/log.php");
error_reporting(E_ALL & ~E_NOTICE);

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
function BOIL($base, $pages = []) {
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
