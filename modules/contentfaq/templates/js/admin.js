var ContentFaq = function () {
}
ContentFaq.prototype = {
    submit: function (frm) {
        var validation = new Validation(frm);
        if (validation.isValid()) {
            jQuery(frm).submit();
        }
    }
}
