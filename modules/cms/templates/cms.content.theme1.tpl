<!--How to sell Template-->
<link href="{$ROOTURL}/modules/cms/templates/css/theme1-styles.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="{$ROOTURL}/modules/cms/templates/js/howtosell-effects.js"></script>
<div class="howtosell-wrapper">
    <div class="howtosell-intro">{$row.title}</div>
    <div class="howtosell-steps">
    {section name=infographic loop=$infographic_data }
        <div class="howtosell-step howtosell-step-{$infographic_data[infographic].step}">
            <a href="#step{$infographic_data[infographic].step}" class="howtosell-step-link step{$infographic_data[infographic].step}" style="background: url({$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}) 0 0 no-repeat;" ></a>
            <input type="hidden" class="icon_on" id="icon_on_step{$infographic_data[infographic].step}" value="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_on}" />
            <input type="hidden" class="icon_off" id="icon_off_step{$infographic_data[infographic].step}" value="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}" />
        </div>
        {if ($smarty.section.infographic.index + 1) % 3 == 0 }
        <div class="clearthis"></div>
        {/if}
    {/section} 
        
    </div>
    <div class="howtosell-steps-container">
    {section name=infographic loop=$infographic_data }
        <div class="howtosell-step-content step{$infographic_data[infographic].step}">
            <div class="howtosell-steps-content-header">{$infographic_data[infographic].title}</div>
            <div class="howtosell-step-content-content">{$infographic_data[infographic].content}</div>
        </div>
    {/section}        
    </div>
    <div class="clearthis"></div>
</div>