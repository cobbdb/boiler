<?php

include_once("$MODULES/eta/H.php");
include_once("$MODULES/lumbermill/log.php");

// Set the default views directory.
H::setHome("$VIEWS/", true);

class Boiler {
    /**
     * Create or open file at given path.
     * @param {string} path
     * @return {resource}
     */
    private static function fopenPlus($path) {
        $dirname = dirname($path);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        return fopen($path, 'w');
    }

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
        echo 'Beginning render...';
        foreach ($pages as $dest => $page) {
            $model = $page['model'] ?: [];
            $view = $page['view'];
            $content = H::render($view, $model) or die("Missing view $src!");
            echo $content;
            $flatfile = H::render($base, [
                'body' => $content
            ]) or die("Missing base template $base!");
            $template = self::fopenPlus($dest);
            fwrite($template, $flatfile);
            fclose($template);
        }
        echo '... done!';
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
        echo 'Beginning copy...';
        foreach ($patterns as $dest => $src) {
            $files = glob($src);
            foreach ($files as $path) {
                $filename = basename($path);
                $fout = fopen("$dest$filename", 'w') or die("Unable to open file $dest$filename!");
                $content = file_get_contents($path);
                echo $content;
                fwrite($fout, $content);
                fclose($fout);
            }
        }
        echo '... done!';
    }
}
