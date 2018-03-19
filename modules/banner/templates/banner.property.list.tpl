
{assign var = len value = $len}
{assign var = dgetlist value = $getlist}
{assign var = len_arr value = $len_arr}
{assign var = pid value = $pid}
{assign var = p value =$pid}

{if $isearch % 6 == 0}
    
    {if isset($dgetlist) and $pid > 0 or  isset($dgetlist) and $pid == ''}

          {if $pid == ''}
                {assign var = pid value = 0}
            {elseif $pid > 0}
                {assign var = pid value = $pid+1}
                
          {/if}                  
          {if $len_arr > 0} {* Check Array Banner > 0 With Don't error divide zero *} 
            {assign var = xsearch value = $pid%$len_arr}  
                {if $len >= 12} {* If choose 12 pro show in 1 page how to show correct. ? *}
                    {if $pid == 0 and $len_arr >= 2}
                        {* Comment lai {assign var = pid value = 2} dem 11/11/2011 *}
                       {* {assign var = pid value = 2} *}
                    {/if}
                {/if}
          {/if}
                                
            {assign var = arr2 value = $auction_cv[$xsearch]} 
            {include file = "`$ROOTPATH`/modules/banner/templates/banner_view_auction_sale.tpl"}	 
            {assign var = jsearch value = $jsearch+1} 
                              
    {/if}  


{/if}     
