<?php

include_once("$MODULES/eta/H.php");
include_once("$MODULES/lumbermill/log.php");
include_once("$MODULES/fopen-plus/fopenp.php");

// Set the default views directory.
H::setHome("$VIEWS/", true);

class Boiler {
    /**
     * ## render(base, pages)
     * @param {string} base Path to site-wide base template.
     * @param {array<dest, array<view, [model]>>} pages
     * @example
     * ```php
     *  Boiler::render('./base.html', [
     *      '../public/page.html' => [
     *          'view' => '../private/view.html',
     *          'model' => []
     *      ]
     *  ]);
     * ```
     */
    public static function render($base, $pages = []) {
        echo '<h1>Beginning render...</h1>';
        foreach ($pages as $dest => $model) {
            $flatfile = H::render($base, $model) or die("Missing template $base!");
            $template = fopenp($dest);
            fwrite($template, $flatfile);
            fclose($template);
        }
        echo '<h1>... render done!</h1>';
    }

    /**
     * ## copy(base, pages)
     * @param {array<string, string>} patterns Globbing patterns.
     * @example
     * ```php
     *  Boiler::copy([
     *      "$PUBLIC/assets/js/" => "$ASSETS/dist/js/*",
     *      "$PUBLIC/assets/css/" => "$ASSETS/dist/css/*",
     *      "$PUBLIC/assets/img/" => "$ASSETS/dist/img/*",
     *      "$PUBLIC/assets/fonts/" => "$ASSETS/dist/fonts/*"]
     *  ]);
     * ```
     */
    public static function copy($patterns = []) {
        echo '<h1>Beginning copy...</h1>';
        foreach ($patterns as $dest => $src) {
            $files = glob($src);
            foreach ($files as $path) {
                $filename = basename($path);
                $fout = fopenp("$dest$filename", 'w') or die("Unable to open file $dest$filename!");
                $content = file_get_contents($path);
                fwrite($fout, $content);
                fclose($fout);
            }
        }
        echo '<h1>... copy done!</h1>';
    }
}
