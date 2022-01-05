## How to enable debugging

First install XDebug for PHP:

`sudo apt install php-xdebug`

Make sure configuration for XDebug is stored in the file

`/etc/php/7.4/apache2/conf.d/20-xdebug.conf`

on your Virtual Machine! 

Use the configuration below:

```apacheconf
zend_extension=xdebug.so
xdebug.idekey="PHPSTORM"
xdebug.remote_autostart=on
xdebug.remote_enable=on
xdebug.mode=debug
xdebug.default_enable=1
xdebug.remote_port=9000
xdebug.remote_handler=dbgp
xdebug.client_host=192.168.123.11
xdebug.remote_connect_back=1
```

Of course, make sure that the IP-adres for `xdebug.client_host` is set to your *host* machine. 

