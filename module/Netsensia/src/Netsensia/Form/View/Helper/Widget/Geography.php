<?php
namespace Netsensia\Form\View\Helper\Widget;

class Geography extends Widget
{
    public function render()
    {
        ?>
        <table class="table widget_geography" style="margin-bottom:5px" data-widgetid="<?= $this->element->getAttribute('id'); ?>" style="margin-top:1em">
        <caption>Geographies</caption>
        <tr><th>Region</th><th>Continent</th><th>Area</th><th>Country</th><th>Region</th><th>City</th></tr>
        <tr><td><input type="checkbox" value="1" data-expand="isnode" name="widgetignore[]">&nbsp;Global</td></tr>
        <tr><td><input type="checkbox" data-expand="continents" name="widgetignore[]">&nbsp;Select Continent(s)</td></tr>
        </table>
        <?php
    }
}

5