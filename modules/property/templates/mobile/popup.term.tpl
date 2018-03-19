<script type="text/javascript">
    Cufon.replace('#nh_txt');
</script>
<div class="title"><h2 id="nh_txt">{$term_title}<span id="btnclosex" class="btnclosex-popup-newsletter" onclick="term.closePopup()">x</span></h2> </div>
<div class="content" style="padding: 10px">
      <p><strong>Please read the following License Terms of Use. You must accept the terms of this agreement before continuing register bid this property.</strong></p>
      <div class="scroll">{$term}</div>
      <div class="button-pop-newsletter-customize">
        <input type="hidden" name="id" value="{$property_id}">
        <button class="btn-red f-right" name="cancel" id="cancel" onclick="term.closePopup()"><span><span>Cancel</span></span></button>
        <button class="btn-red btn-width f-right" name="submit" id="submit" onclick="term.save()"><span><span>I accept</span></span</button>
      </div>
</div>
