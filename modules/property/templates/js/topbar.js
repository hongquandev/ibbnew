    function OrderChangeStateCode(combo, form_action, mode) {
        $('#order_by').val(combo.value);
        /*document.getElementById('frmSearch').action = form_action+mode;*/
        document.getElementById('frmSearch').action = jQuery('#frmGoto').attr('action');
        return document.getElementById('frmSearch').submit();
    }
    function KindChangeCode(combo, form_action, mode) {
        $('#property_kind').val(combo.value);
        /*document.getElementById('frmSearch').action = form_action+mode;*/
        document.getElementById('frmSearch').action = jQuery('#frmGoto').attr('action');
        return document.getElementById('frmSearch').submit();
    }
    function ActionChange(form_action, mode) {
        if (mode == '') {
            document.getElementById('frmSearch').action = form_action;
        } else {
            document.getElementById('frmSearch').action = form_action + mode;
        }

        return document.getElementById('frmSearch').submit();
    }

