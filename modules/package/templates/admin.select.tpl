<div class="edit-table">
    <table id="option-table" width="100%" class="grid-table" cellspacing="1">
        <thead>
            <tr class="title">
                <td align="center" style="font-weight:bold;color:#fff;width:100px;">Option</td>
                <td align="center" style="font-weight:bold;color:#fff;width:100px;">Position</td>
                <td align="center" style="font-weight:bold;color:#fff;width:50px;"></td>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td>
                    <button type="button" class="add-button button"><span>Add Option</span></button>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="option[remove]" id="option_remove" value=""/>
</div>
{literal}
<script type="text/javascript">
    var OptionTable = function(table){
        this.table = table;
    };
    OptionTable.prototype = {
        init:function() {
            if (typeof(this.table) == 'string'){
                this.table = jQuery(this.table);
            }
            this.addButton = this.table.find('.add-button');
            var self = this;
            var _i;
            this.addButton.bind('click',function(){
                self.addNewRow(null);
            })
        },
        addNewRow:function(data){
            var d = new Date();
            _id = typeof(data) != 'undefined' && data != null?data.id:'_' + d.getTime();
            if (typeof(data) == 'undefined' || data == null){
                data = {};
                data.label = '';
                data.order = '';
            }
            //add new row
            var html = '<tr><td><input type="text" name="option[' + _id + '][label]" value="'+data.label+'" style="width:96%"/></td>\
                                <td><input type="text" name="option[' + _id + '][order]" value="'+data.order+'" style="width:96%"/></td>\
                                <td><button type="button" class="delete-button button" onclick="optionTable.deleteRow(this,\'' + _id + '\')"><span>Delete</span></button></td>\
                            </tr>';
            this.table.find('tbody').append(html);
        },
        show:function(){
            this.reset();
        },
        deleteRow:function(obj, id){
            console.log(id);
            jQuery(obj).closest('tr').remove();
            var option_remove = jQuery('input#option_remove').val().split(',');
            option_remove.push(id);
            jQuery('input#option_remove').val(option_remove.join(','));
        },
        reset:function(){
            jQuery.each(this.table.find('tbody tr'),function(){
                jQuery(this).remove();
            });
        }
    };
    var optionTable = new OptionTable('#option-table');
    jQuery(document).ready(function(){
        optionTable.init();
    });
</script>
<style type="text/css">
#option-table tbody td,
#option-table tfoot td{
    border: 1px solid white;
    padding: 0px 3px;
    background: #f1f1f1;
}
</style>
{/literal}