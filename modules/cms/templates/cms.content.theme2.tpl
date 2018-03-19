<!--How it works Template-->
<link href="{$ROOTURL}/modules/cms/templates/css/theme2-styles.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="{$ROOTURL}/modules/cms/templates/js/howitwork-effects.js"></script>
<div class="howitwork-wrapper">
    <div class="howitwork-intro">{$row.title}</div>
    <div class="howitwork-steps">
    {section name=infographic loop=$infographic_data }
        <div class="howitwork-step howitwork-step-{$infographic_data[infographic].step}">
            <a href="#step{$infographic_data[infographic].step}" class="howitwork-step-link step{$infographic_data[infographic].step}" style="background: url({$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}) 0 0 no-repeat;" ></a>
            <input type="hidden" class="icon_on" id="icon_on_step{$infographic_data[infographic].step}" value="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_on}" />
            <input type="hidden" class="icon_off" id="icon_off_step{$infographic_data[infographic].step}" value="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}" />
        </div>
        <div class="clearthis"></div>
    {/section}    
    </div>
    <div class="howitwork-steps-container">
    {section name=infographic loop=$infographic_data }
        <div class="howitwork-step-content step{$infographic_data[infographic].step}">
            <div class="howitwork-steps-content-header">{$infographic_data[infographic].title}</div>
            <div class="howitwork-step-content-content">{$infographic_data[infographic].content}</div>
        </div>
    {/section}
    </div>
    <div class="clearthis"></div>
</div>
<!--<img id="icon_step{$infographic_data[infographic].step}" src="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}" />-->