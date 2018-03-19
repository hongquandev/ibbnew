<div class="bar-title">
    <h2>CHANGE MY PASSWORD</h2>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
             {if strlen($message)>0}
                        <div class="message-box message-box-ie">{$message}</div>
                        <div class="clearthis"></div>
             {/if}
                 <ul class="form-list form-company">

                    <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
                        <li class="wide">
                            <label>
                                <strong>Current password<span id="notify_current_password">*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="password" name="field[current_password]" id="current_password" class="input-text validate-require" autocomplete="off"/>
                            </div>
                        </li>

                	  <li class="fields">
                                <div class="field">
                                    <label>
                              			  <strong>New password<span id="notify_new_password">*</span></strong>
                           			</label>
                                    <div class="input-box">
                              			  <input type="password" name="field[new_password]" id="new_password" class="input-text validate-require" autocomplete="off"/>
                           			</div>
                                </div>
                                <div class="field">
                                    <label>
                               			 <strong>Confirm new password<span id="notify_confirm_new_password">*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="password" name="field[confirm_new_password]" id="confirm_new_password" class="input-text validate-require" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="clearthis">
                                </div>
                    	</li>
                    </form>
                    <div class="buttons-set">
                        <button class="btn-red btn-red-change-pass" onclick="agent.submit('#frmAgent')">
                            <span><span>Save</span></span>
                        </button>
                    </div>
                 </ul>
        </div>
    </div>
</div>