<?php

include_once("$MODULES/eta/H.php");
include_once("$MODULES/lumbermill/log.php");

// Set the default views directory.
H::setHome("$VIEWS/", true);

/**
 * ## BOILER(base, pages)
 * @param {string} base Path to site-wide base template.
 * @param {array<dest, array<view, [model]>>} pages
 * @example
 *  BOILER('./base.html', [
 *      '../public/page.html' => [
 *          'view' => '../private/view.html',
 *          'model' => []
 *      ]
 *  ]);
 */
class Boiler {
    public static function render($base, $pages = []) {
        echo 'Beginning render...';
        foreach ($pages as $dest => $page) {
            $model = $page['model'] ?: [];
            $view = $page['view'];
            $content = H::render($view, $model) or die("Missing view $src!");
            echo $content;
            $flatfile = H::render($base, [
                'body' => $content
            ]) or die("Missing base template $base!");
            $template = fopen($dest, 'w') or die("Unable to open file $dest!");
            fwrite($template, $flatfile);
            fclose($template);
        }
        echo '... done!';
    }

    public static function copy($files = []) {
        echo 'Beginning copy...';
        foreach ($files as $dest => $path) {
            $dest = fopen($dest, 'w') or die("Unable to open file $dest!");
            $content = file_get_contents($path);
            echo $content;
            fwrite($dest, $content);
            fclose($dest);
        }
        echo '... done!';
    }
}
