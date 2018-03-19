        function formatCurrency_offer(num) {
            num = num.toString().replace(/\$|\,/g,'');
            if(isNaN(num))
            num = "0";
            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num*100+0.50000000001);
            cents = num%100;
            num = Math.floor(num/100).toString();
            if(cents<10)
            cents = "0" + cents;
            for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
            num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));

            return (((sign)?'':'-') + '$' + num);
        }

        function Make_offer_price(num,id) {
            var price = num;
            i = price.indexOf("$");
            price = price.substr(i+1,price.length - i + 1);
            
            var j=0;
            for(j;j<=price.length;j++)
            {
                 price=price.replace(",","");
            }
            price_ = new String(price);
            price_ = Number(price_);
            if (/^[0-9]+$/.test(price_)) {
                jQuery('#offer_price','#frmMakeAnOffer_'+id).val(price);
            }
            else
            {
                jQuery('#offer_price','#frmMakeAnOffer_'+id).val('0');
            }
            
            return formatCurrency(num);
        }

