<link rel="stylesheet" href="{$ROOTURL}/modules/homepage_slides/js/flexslider.css" type="text/css">
<script src="{$ROOTURL}/modules/homepage_slides/js/jquery.flexslider-min.js"></script>
{literal}
    <style type="text/css">
        .homepage-content {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 0;
            position: relative;
        }
        .homepage-content a,
        .homepage-content p {
            display: block;
        }
        .homepage-content p {
            margin-bottom: 5px;
        }
        .homepage-content img {
            width: 100%;
            height: auto;
            margin: 5px 0;
        }
        #markover {
            position: absolute;
            z-index: 90;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            opacity: 0.4;
        }
        #enquiry {
            display: block;
            position: fixed;
            margin-top: -75px;
            top: 50%;
            left: 50%;
            margin-left: -165px;
            z-index: 99;
        }
        .enquiry-cont {
            max-width: 330px;
            text-align: center;
            width: 100%;
            border-radius: 25px;
            padding: 10px 20px;
            background-color: #297ffc;
            box-sizing: border-box;
        }
        .enquiry-cont p {
            color: #fff;
        }
        .enquiry-cont input {
            width: 100%;
            padding: 5px 10px;
            background-color: #fff;
            border: 1px solid #fff;
            color: #205dba;
            text-align: center;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            /*font-weight: bold;*/
        }
        .enquiry-cont button {
            margin-top: 10px;
            width: 65px;
            border-radius: 5px;
            height: 25px;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #fff;
            background-color: #297ffc;
            cursor: pointer;
            color: #fff;
        }
        .enquiry-cont button:hover {
            background-color: #fff;
            color: #297ffc;
        }
        .enquiry-cont span {
            position: absolute;
            color: #fff;
            display: block;
            bottom: 0;
            right: 0;
            margin-right: 20px;
            top: 86%;
            cursor: pointer;
        }
        .contact-us-lnk {
            color: white;
            text-decoration: underline;
            text-align: center;
            margin-top: -35px;
            font-size: 17px;
            font-weight: normal;
            cursor: pointer;
            line-height: 30px;
        }
        .contact-us-text {
            color: white;
            text-decoration: underline;
            position: absolute;
            top: 64%;
            right: 27%;
            font-size: 37px;
            font-weight: bold;
            font-family: ProximaNova-Regular, sans-serif;
        }
    </style>
{/literal}
<div id="markover"></div>
<div class="homepage-content">
    <div id="enquiry">
        <div class="enquiry-cont">
            <p style="font-weight: bold;line-height: 27px;font-size: 17px;">FIND OUT HOW TO REDUCE COSTS & ACCESS MORE
                CUSTOMERS NOW</p>
            <br/>
            <input placeholder="Enter email address here" type="text" id="email_address" name="email_address"/>
            <br/>
            <button onclick="sendEquiry()" id="send" type="button">SEND</button>
            <span onclick="closeEquiry()">Close</span>
        </div>
    </div>
    {if isset($slide_rows) and is_array($slide_rows) and count($slide_rows) > 0}
        <div class="flexslider">
            <ul class="slides">
                {foreach from = $slide_rows key = k item = row}
                    <li style="position: relative">
                        <img src="{$row.image}" alt="slide"/>
                        {if $row.text}
                            {$row.text}
                        {/if}
                    </li>
                {/foreach}
            </ul>
        </div>
    {/if}
</div>
{literal}
    <script type="text/javascript">
        function openEquiry() {
            jQuery('#markover').show();
            jQuery('#enquiry').show();
        }
        function closeEquiry() {
            jQuery('#markover').hide();
            jQuery('#enquiry').hide();
        }
        function sendEquiry() {
            var url = ROOTURL + "/modules/general/action.php?action=send_equiry";
            var email = jQuery('#email_address', '#enquiry').val();
            if (email.length <= 0) {
                jQuery('#email_address', '#enquiry').css('border', '1px dashed red');
                return;
            }
            var data = {'email_address': email};
            showLoadingPopup();
            jQuery.post(url, data, function (data) {
                closeLoadingPopup();
                var result = jQuery.parseJSON(data);
                if (result.success) {
                    closeEquiry();
                } else {
                    if (result.message) {
                        showMess__(result.message);
                    }
                }
            }, 'html');
        }
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        jQuery('.flexslider').flexslider({
            animation: "slide",
            slideshow: true,
            slideshowSpeed: 3000
        });
    </script>
{/literal}