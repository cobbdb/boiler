# PHP Lumber Mill

    npm i phplumbermill --save

```php
include_once('./node_modules/phplumbermill/log.php');

log::title('Starting something great');
log::write('doing something great');

log::title('Starting something awesome');
log::end('done with something awesome');

log::end('done with something great');
```

##### event.log file
```
Starting something great ...
    ... doing something great
	Starting something awesome ...
		... done with something awesome
	... done with something great
```
