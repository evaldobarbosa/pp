pp
==

You will get all needed information about a product in brazilian e-commerce sites.

Simple to use, PP is the way to collect data about a product in brazilian e-commerce including price, description and picture.

See the code of tests.

To run the test:

$ bin/phpunit -c tests/phpunit.xml --group=Info

Example:

```php
<?
/**
* Getting information from products
*/

use Puller\Target\SubmarinoProductInfo;

//http://www.submarino.com.br/produto/111970051
$productid = 111970051;

$p = new SubmarinoProductInfo( $productid );
echo $p->productId, "\n", $p->productName, "\n";
print_r( $p->productTable );

$p = new NetShoesProductInfo( '094-0460-014-03' );
echo $p->productId, "\n", $p->productName, "\n";
print_r( $p->productTable );

$p = new PontoFrioProductInfo( 'TelefoneseCelulares/Smartphones/Celular-Desbloqueado-Motorola-RAZR-i-Preto-com-Processador-Intel-de-2-GHz-Tela-de-4-3’’-Android-4-0-Camera-8MP-Wi-Fi-3G-NFC-GPS-e-Bluetooth-1748861.html' );
echo $p->productId, "\n", $p->productName, "\n";
print_r( $p->productTable );
</pre>
```

## Important

> *This software now is under LPGLv3. Se this:*<br/>
> *http://www.gnu.org/copyleft/lesser.txt*
> Winner - June 2013
> <img src="http://www.phpclasses.org/award/innovation/winner.png"/><br/>
> http://www.phpclasses.org/package/8077-PHP-Scrape-product-data-pages-from-e-commerce-sites.html
