{if $package_data}
    {if $layout == 'list'}

        <li class="wide">
            <label id="notify_package"><strong>Package<span>*</span></strong></label>
            <div class="input-box">
                {foreach from = $package_data key = k item = row }
                    {assign var = chked value = ''}
                <label for="package_id{$row.package_id}">
                    {if $form_datas.package_id == $row.package_id}
                        {assign var = chked value = 'checked'}
                    {/if}
                    <input type="radio" name="package_id[]" id="package_id{$row.package_id}" value="{$row.package_id}" {$chked}/>
                    <span style="margin-left:10px">{$row.title} - {$row.price} per month.</span>
                </label>
                <br/>
                {/foreach}
            </div>
        </li>
    {elseif $layout == 'table'}
        <table class="tpackage">
            <thead>
                <tr>
                    <th class="empty"></th>
                    <th class="empty"></th>
                    <th scope="col" abbr="Starter">Photo Upload</th>
                    <th scope="col" abbr="Medium">Video Upload</th>
                    <th scope="col" abbr="Business">Sub account(s)</th>
                    <th scope="col" abbr="Deluxe">Document upload</th>
                    <th scope="col" abbr="Deluxe">Comment</th>
                    <th scope="col" abbr="Deluxe">Blog</th>
                </tr>
            </thead>
            <tbody>
            {foreach from = $package_data key = k item = row }
                <tr>
                    <th>
                         <input type="radio" name="package_id[]" id="package_id{$row.package_id}" value="{$row.package_id}"/>
                    </th>
                    <th scope="col">
                        <span style="font-size:20px;line-height: 25px">{$row.title}</span>
                        <br />
                        <span class="price">{$row.price}</span>
                        <span style="font-size:10px">/month</span></th>
                    <td>{$row.photo_num}</td>
                    <td>{$row.video_num}</td>
                    <td>{$row.account_num}</td>
                    <td>{$row.document_ids}</td>
                    <td>{$row.can_comment}</td>
                    <td>{$row.can_blog}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/if}
{/if}
