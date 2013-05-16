pp
==

You will get all needed information about a product in brazilian e-commerce sites.

Simple to use, PP is the way to collect data about a product in brazilian e-commerce including price, description and picture.

See the code of tests.

To run the test:

$ bin/phpunit -c tests/phpunit.xml --group=Info

Example:

<?
<pre>
/**
* Getting information from ID 111970051
*/

use Puller\Target\SubmarinoProductInfo;

//http://www.submarino.com.br/produto/111970051
$productid = 111970051;

$p = new SubmarinoProductInfo( $productid );

echo $p->productId, "\n", $p->productName, "\n";

print_r( $p->productTable );
</pre>
