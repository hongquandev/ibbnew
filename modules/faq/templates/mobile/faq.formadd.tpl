<body>
<div style="width:100%">

<form method="post" action="index.php?module=faq&action=add" class="cmxform" name="frmCreate" id="frmCreate" enctype="multipart/form-data"  >

    <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">                            
                            FAQ Information                       
                        </td>
                    </tr>
                </table>
            </td>    
        </tr>  
        <tr>
        <td colspan="2" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1" bgcolor="#CCCCCC"></td>
                    <td align="left" valign="top" class="padding1">
                        <table width="100%" cellspacing="15">
                            <tr>
                                <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                <!--bar-->
                                	{include file = 'admin.faq.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>Faq detail</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                                {if isset($action)}
                                                  	<table width="100%">
                                                        <tr>
                                                            <td class="labelName" id="gosPos" width="22%">
                                                            <strong id="notify_title"><p style="margin-top:7px;">  Title <span class="require">*</span></strong>
                                                            </td>
                                                          <td  class="value">
                                                          <input type="text" id="title" name="fields[title]" class="validate-require" style="width:80%"  />
                                                          </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="labelName"  id="gosPos" width="22%" >
                                                                <strong id="notify_title"><p style="margin-top:7px;"> Description <span class="require"></span></strong>
                                                            </td>
                                                            <td class="value">
                                                             <input type="text" id="description" name="fields[description]" style="width:80%"  />
                                                            </td>
                                                           </tr>   
                                                     <tr>
                                                        <tr>
                                                                 <td class="labelName"  id="gosPos" width="22%" >
                                                               
                                                                 </td>
                                                                <td class="value">
                                                                	<strong id="notify_title"> Active <span class="require"> </span></strong>
                                                               		<input type="checkbox" name="active" id="active" checked="checked"> </input>
                                                                </td>
                                                           </tr>   
                                                     <tr>
                                                     
                                                        <td colspan="2" align="right">
                                                            <hr/>
                                                            <script type="text/javascript">
                                                            var faq = new Faq();
                                                            </script>
                                                            <input type="hidden" name="next" id="next" value="0"/>
                                                          
                                                           <input type="button"  class="button" value="Create Faq" onClick="faq.submit('#frmCreate');"/>
                                                            <input type="button" class="button" value="Back" onClick="window.location='?module=faq'"/>
                                                        </td>
                                                    </tr>
                                                            
                                                      
                                                </table>
                                                {else}
                                                    Can not find the template with this request.
                                                {/if}
                                            
                                            </td>
                                        </tr> 
                                    </table>                                  
                                </td>
                            </tr>             
                        </table>
                    </td>
                    <td width="1" bgcolor="#CCCCCC"></td>
                </tr>
            </table>
        </td>
        </tr>
        
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</form>

</div>
</body>

