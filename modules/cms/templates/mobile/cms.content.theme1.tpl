<!--How to sell Template-->
<link href="{$ROOTURL}/modules/cms/templates/mobile/css/theme1-styles.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="{$ROOTURL}/modules/cms/templates/mobile/js/howtosell-effects.js"></script>
<div class="howtosell-wrapper">
    <div class="howtosell-intro">{$row.title}</div>
    <div class="howtosell-steps">
    {assign var=foo value = 0}
    {assign var=bar value = 1}
    {php}
    $infographic_data = $this->_tpl_vars["infographic_data"]; 
    //print_r_pre($infographic_data); die();
    $content_show = "";
    $i = 0;
    foreach($infographic_data as $key => $val) {
        $i++;
        //print $key;
        $step_icon_str = '
            <div class="howtosell-step howtosell-step-'.$val["step"].'">
            <a href="#step'.$val["step"].'" class="howtosell-step-link step'.$val["step"].'" ><img src="'.MEDIAURL.'/store/uploads/infographic/images/'.$val["icon_off"].'" width="100%"/></a>
            <input type="hidden" class="icon_on" id="icon_on_step'.$val["step"].'" value="'.MEDIAURL.'/store/uploads/infographic/images/'.$val["icon_on"].'" />
            <input type="hidden" class="icon_off" id="icon_off_step'.$val["step"].'" value="'.MEDIAURL.'/store/uploads/infographic/images/'.$val["icon_off"].'" />
            </div>                
        ';
        $content_show .= $step_icon_str;
        if($i % 2 == 0) {
            $j = $key - 1;
            $content_show .= '<div class="clearthis"></div>';
            $content_show .= '     
                <div class="howtosell-step-content step'.$infographic_data[$j]["step"].'">
                    <div class="howtosell-steps-content-header">'.$infographic_data[$j]["title"].'
                        <a class="close-link" data-step="step'.$infographic_data[$j]["step"].'">close</a>
                    </div>
                    <div class="howtosell-step-content-content">'.$infographic_data[$j]["content"].'</div>
                </div> 
                <div class="howtosell-step-content step'.$infographic_data[$key]["step"].'">
                    <div class="howtosell-steps-content-header">'.$infographic_data[$key]["title"].'
                        <a class="close-link" data-step="step'.$infographic_data[$key]["step"].'">close</a>
                    </div>
                    <div class="howtosell-step-content-content">'.$infographic_data[$key]["content"].'</div>
                </div>  
            ';
        }
    }
    print($content_show);
    {/php}           
    </div>
    <div class="clearthis"></div>
</div>