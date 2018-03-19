{literal}
<style type="text/css">
    .note-copy-p{ font-style: italic;margin: 20px 10px}
    .property-list-copy{margin: 0; padding: 0;text-align: left; height: auto;max-height: 400px; overflow-y: scroll}
    .property-list-copy li{margin: 0; padding: 0;list-style: none;background-color: #a0a19d; color: #ffffff; font-weight: normal;}
    .property-list-copy li{padding: 10px;border-top: 1px solid #c2c2c2; box-sizing: border-box;}
    .property-list-copy li:last-child{border-bottom: 1px solid #c2c2c2;}
    .property-list-copy li:hover{background-color: #017db9; cursor: pointer}
</style>
{/literal}
<p class="note-copy-p">
   <strong>*Please select a property to copy as new property.</strong>
</p>
<ul class="property-list-copy">
{foreach from = $properties key = k item = row}
    <li onclick="jQuery('label input',this).attr('checked',true)">
        <label style="width: 100%" for="property_copy_{$k}">
            <input id="property_copy_{$k}" type="radio" name="property_copy_id" value="{$row.property_id}">
            Property ID: {$row.property_id} - {$row.kind_label} <br>
            <i style="font-size: 12px; font-weight: bold">
                &nbsp;&nbsp;&nbsp;&nbsp; Auction Type: {$row.auction_type_label} <br>
                &nbsp;&nbsp;&nbsp;&nbsp; Address: {$row.address}<br>
                &nbsp;&nbsp;&nbsp;&nbsp; Price: {$row.show_price}
            </i>
        </label>
    </li>
{/foreach}
</ul>