<?php
namespace Directorzone\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Address extends AbstractHelper 
{
    public function __invoke($address)
    {
        if (!is_null($address)) {
            echo (!isset($address['address1']) || trim($address['address1']) == '') ? '' : ($address['address1'] . '<br>');
            echo (!isset($address['address2']) || trim($address['address2']) == '') ? '' : ($address['address2'] . '<br>');
            echo (!isset($address['address3']) || trim($address['address3']) == '') ? '' : ($address['address3'] . '<br>');
            echo (!isset($address['town']) || trim($address['town']) == '') ? '' : ($address['town'] . '<br>');
            echo (!isset($address['county']) || trim($address['county']) == '') ? '' : ($address['county'] . '<br>');
            echo (!isset($address['country']) || trim($address['country']) == '') ? '' : ($address['country'] . '<br>');
            echo (!isset($address['postcode']) || trim($address['postcode']) == '') ? '' : ($address['postcode'] . '<br>');
        }
    }

}
