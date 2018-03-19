<script type="text/javascript">
    var fb_id = '{$form_data.facebook_application_api_id}';
    {literal}
    window.fbAsyncInit = function () {
        FB.init({ appId: fb_id, cookie: true, xfbml: true, oauth: true });
    };

    (function(d) {
        var js, id = 'facebook-jssdk';
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
    }(document));
    function logIn() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected' || response.status === 'not_authorized') {
                FB.logout(function(response) {
                    // user is now logged out
                });

            }
        });
        FB.login(function(response) {
                    if (response.authResponse) {

                        FB.api('/me/accounts', 'get', {}, function(response) {
                                    if (response.data) {
                                        $('<tr><td></td><td id="list-fanpage"><img src="/modules/general/templates/images/ajax-loader.gif"></td></tr>').insertAfter('#fanpage');
                                        var html = '';

                                        for (var i = 0,page; page = response.data[i]; i++) {
                                            if (page.name) {
                                                html += '<input name="fanpage[]" onclick="set_page(this)" type="radio" id="' + page.id + '" lang="' + page.access_token + '"/> ' + page.name + '<br />';
                                            }
                                        }
                                        html += '<input type="hidden" name="fields[facebook_fanpage_token]" id="facebook_fanpage_token"/>';
                                        $('#list-fanpage').html(html);
                                    }
                                });
                    } else {
                        //user cancelled login or did not grant authorization
                    }
                }, {scope:'email,user_birthday,status_update,offline_access,manage_pages'});
    }
    {/literal}
</script>
<div id="fb-root"></div>
<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
             <select name="fields[facebook_enable]" id="facebook_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.facebook_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%">
        	<strong>Application Api Id</strong>
        </td>
        <td>
			<input type="text" name = "fields[facebook_application_api_id]" id = "facebook_application_api_id" value="{$form_data.facebook_application_api_id}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>
{*
	<tr>
    	<td width = "19%">
        	<strong>Application Api Key</strong>
        </td>
        <td>
			<input type="text" name = "fields[facebook_application_api_key]" id = "facebook_application_api_key" value="{$form_data.facebook_application_api_key}" class="input-text validate-require" style="width:100%"/>
        </td>
    </tr>*}
	<tr>
    	<td width = "19%">
        	<strong>Application Secret</strong>
        </td>
        <td>
			<input type="text" name = "fields[facebook_application_secret]" id = "facebook_application_secret" value="{$form_data.facebook_application_secret}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

    <tr id="fanpage">
    	<td width = "19%">
        	<strong>Fanpage ID</strong>
        </td>
        <td>
            <input type="button" class="button" style="float:right" onclick="logIn()" value="Get FanpageID"/>
			<input type="text" name = "fields[facebook_fanpage_id]" id = "facebook_fanpage_id" value="{$form_data.facebook_fanpage_id}" class="input-text" style="width:75%" autocomplete="off" style="float:left"/>
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
</table>
<script type="text/javascript">
    {literal}
        function set_page(obj){
            if ($('#facebook_fanpage_token').length > 0){
                $('#facebook_fanpage_token').val($(obj).attr('lang'));
                $('#facebook_fanpage_id').val($(obj).attr('id'));
            }
        }
    {/literal}
</script>