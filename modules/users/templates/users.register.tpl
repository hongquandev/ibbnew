<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main user-register">
                    <h1>REGISTER</h1>
                    <div class="ureg-panel">
                    	{assign var="step1" value=""}
                        {assign var="step2" value=""}
                        {assign var="step3" value=""}
                        {assign var="step4" value=""}
                        {assign var="step5" value=""}
                        
                        {assign var="step$step" value="-active"}
                        
                        <div class="step step-1{$step1}">
                        </div>
                        <div class="step step-2{$step2}">
                        </div>
                        <div class="step step-3{$step3}">
                        </div>
                        <div class="step step-4{$step4}">
                        </div>
                        <div class="step step-5{$step5}">
                        </div>
                    </div>
                    <div class="step-info">
                    	{if $step>=1 and $step<=5}
                        	{include file = "users.register.step$step.tpl"}
                        {else}
                        	{'waiting'}
                        {/if}
                   </div>
                </div>
                <div class="col-right">
                    {include file = 'users.register.right.tpl'}
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
