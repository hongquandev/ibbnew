<script type="text/javascript">
    var tw_url = '{$tw.url}';
    {literal}

    (function(jQuery){
        jQuery.oauthpopup = function(options)
        {
            options.windowName = options.windowName ||  'ConnectWithOAuth';
            options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=400';
            options.callback = options.callback || function(){ window.location.reload(); };
            var that = this;

            that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
            that._oauthInterval = window.setInterval(function(){
                if (that._oauthWindow.closed) {
                    window.clearInterval(that._oauthInterval);
                    options.callback();
                }
            }, 1000);
        };
    })(jQuery);
    /*$(document).ready(function(){

         $('.tw_click').click(function(){
            $.oauthpopup({
                path: tw_url,
                callback: function(){
                    window.location.reload();
                }
            });
        });
    });*/
    function loginTw(){
        $.oauthpopup({
                path: tw_url,
                callback: function(){
                    window.location.reload();
                }
        });
    }

    function deleteTwitter(provider_id){
         var url = '/modules/agent/action.php?action=delete_tw';
         $.post(url,{provider:provider_id},OndeleteTw,'html');
    }
    function OndeleteTw(data)
    {
        var result = jQuery.parseJSON(data);
            if (result.success){
               $('#tw_detail').html('No account twitter connected. <a class="tw_click" href="javascript:void(0)" onclick="loginTw();" style="color:#990000">Add account.</a>');
            }
            else
            {
                showMess('Error when process. Please try again !');
            }
    }
  {/literal}
</script>
{if isset($db_twitter_data) and is_array($db_twitter_data) and count($db_twitter_data) > 0}
     <div id="tw_detail">You connected account: <span style="color:#990000">{$db_twitter_data.username}</span>
     <a href="javascript:void(0)" onclick="deleteTwitter('{$db_twitter_data.agent_id}')">(Delete)</a></div>
{else}
    No account twitter connected. <a class="tw_click" href="javascript:void(0)" style="color:#990000" onclick="loginTw();">Add account.</a>
{/if}