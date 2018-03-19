<div class="title"><h2>{$term_title}<span id="btnclosex" class="btn-x" onclick="term.closePopup()">Close X</span></h2> </div>
<div class="content" style="padding: 10px">
    <p><strong>Please read the following License Terms of Use. You must accept the terms of this agreement before continuing register bid this property.</strong></p>
    <div class="scroll">{$term}</div>
    <p style="color: red; font-size: 13px; margin: 5px 0;float: left">“NOTE : please check your JUNK email folder for your confirmation email”</p>
    <div class="buttons-set">
        <button class="btn-gray" name="cancel" id="cancel" onclick="term.closePopup()" style="float:right">
            <span><span>Cancel</span></span>
        </button>
        <button class="btn-blue" name="submit" id="submit" onclick="term.save()" style="float:right;margin-right:2px">
            <span><span>I accept</span></span>
        </button>
    </div>
</div>
