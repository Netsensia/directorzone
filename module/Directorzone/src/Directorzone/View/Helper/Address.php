<?php
namespace Directorzone\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Address extends AbstractHelper 
{
    public function __invoke($address)
    {
        if (!is_null($address)) {
            echo trim($address['address1']) == '' ? '' : ($address['address1'] . '<br>');
            echo trim($address['address2']) == '' ? '' : ($address['address2'] . '<br>');
            echo trim($address['address3']) == '' ? '' : ($address['address3'] . '<br>');
            echo trim($address['town']) == '' ? '' : ($address['town'] . '<br>');
            echo trim($address['county']) == '' ? '' : ($address['county'] . '<br>');
            echo trim($address['country']) == '' ? '' : ($address['country'] . '<br>');
            echo trim($address['postcode']) == '' ? '' : ($address['postcode'] . '<br>');
        }
    }

}
