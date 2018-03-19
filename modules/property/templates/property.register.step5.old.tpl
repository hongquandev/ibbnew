<div class="step-4-info">
    <div class="step-name">
        <h2>iBB Ratings</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p style="text-align: justify">
                This page offers you the chance to complete some questions which will allow potential buyers to get a quick view of the sustainability features of your property.
            </p>
            <br/>
            <p style="text-align: justify">
                The iBB sustainability rating model provides a star rating for the sustainability of your home, allowing buyers to quickly see what sustainable benefits are available.
            </p>
            <br/>
            <p style="text-align: justify">
                Remember, sustainability isn't just about the environment (it is good for it though), the benefits these features have for potential savings on utility bills and living comfort are a big factor buyers are looking for too.
            </p>
        </div>
        <div class="col-2 bg-f7f7f7">
            <div class="col22-set">
                {if strlen($message)>0}
                    <div class="message-box all-step-message-box">{$message}</div>
                {/if}
            
            	<form name="frmProperty" id="frmProperty" method="post" action="{$form_action}" onsubmit="return pro.isSubmit('#frmProperty')">
                <div class="col-11" style="width: 100%;">
                    <ul class="form-list form-property">
                        <li class="wide">
                            <h3>iBB Sustainability</h3>
                        </li>
                        {if is_array($green_ratings) and count($green_ratings)>0}
                        	{foreach from = $green_ratings key = k item = v}
                                {if true }
                                    <li class="wide">
                                        {assign var = var1 value = ""}
                                        {assign var = var2 value = ""}
                                        {if $v.require == 1}
                                            {assign var = var1 value = "<span id='notify_rating_`$v.rating_id`'>*</span>"}
                                            {assign var = var2 value = "validate-number-gtzero"}
                                        {/if}

                                        <label>
                                            <strong>{$v.title} {$var1}</strong>
                                        </label>
                                        <div class="input-box">
                                            <select name="fields[{$v.rating_id}]" id="rating_{$v.rating_id}" class="input-select {$var2}">
                                                {html_options options = $options[$v.rating_id] selected = $form_data[$v.rating_id]}
                                            </select>
                                        </div>
                                    </li>
                                {/if}
                            {/foreach}
                        {/if}
                    </ul>
                </div>

                {*{assign var = var1 value = "<span id='notify_rating_`$v.rating_id`'>*</span>"}*}
                {*<div class="col-22">
                    <ul class="form-list form-property">
                        <li class="wide">
                            <h3>iBB Livability Rating</h3>
                        </li>
                        {if is_array($livability_ratings) and count($livability_ratings)>0}
                        	{foreach from = $livability_ratings key = k item = v}
                                <li class="wide">
                                	{assign var = var1 value = ""}
                                    {assign var = var2 value = ""}
                                    {if $v.require == 1}

                                        {assign var = id value = "id='notify_rating_`$v.rating_id`'"}
                                        {assign var = var1 value = "<span >*</span>"}
                                        {assign var = var2 value = "validate-number-gtzero"}
                                    {/if}

                                    <label>
                                        <strong {$id}>{$v.title} {$var1}</strong>
                                    </label>
                                    <div class="input-box">
                                        <select name="fields[{$v.rating_id}]" id="rating_{$v.rating_id}" class="input-select {$var2}">
                                            {html_options options = $options[$v.rating_id] selected = $form_data[$v.rating_id]}
                                        </select>
                                    </div>
                                </li>
                            {/foreach}
                        {/if}
                       
                    </ul>
                </div>*}

				{*
                <div class="col-22" style="display: none;">
                        <ul class="form-list form-property" style="padding-top: 27px;">
                            <li class="wide">
                                <h3></h3>
                            </li>
                        {if is_array($green_ratings) and count($green_ratings)>0}
                            {foreach from = $green_ratings key = k item = v}
                                {if $k > 3}
                                    <li class="wide">
                                        {assign var = var1 value = ""}
                                        {assign var = var2 value = ""}
                                        {if $v.require == 1}
                                            {assign var = var1 value = "<span id='notify_rating_`$v.rating_id`'>*</span>"}
                                            {assign var = var2 value = "validate-number-gtzero"}
                                        {/if}

                                        <label>
                                            <strong>{$v.title} {$var1}</strong>
                                        </label>
                                        <div class="input-box">
                                            <select name="fields[{$v.rating_id}]" id="rating_{$v.rating_id}" class="input-select {$var2}">
                                                {html_options options = $options[$v.rating_id] selected = $form_data[$v.rating_id]}
                                            </select>
                                        </div>
                                    </li>
                                {/if}
                            {/foreach}
                        {/if}
                        </ul>

                    </div>
				*}
                <input type="hidden" name="track" id="track" value="0"/>
                <input type="hidden" name="is_submit2" id="is_submit2" value="0"/>
                </form>
                <div class="clearthis"></div>
                <script type="text/javascript">pro.is_submit = 'is_submit2';</script>
            </div>
            <div class="buttons-set">
                <button class="btn-red step-eight-btn-red" onclick="(document.location.href='/?module=property&action=register&step=4')"><span><span>Back</span></span></button>
                <button class="btn-red" onclick="pro.submit('#frmProperty',true)">
                    <span><span>Save</span></span>
                </button>
                 <button class="btn-red" onclick="pro.submit('#frmProperty')">
                    <span><span>Next</span></span>
                </button>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>
