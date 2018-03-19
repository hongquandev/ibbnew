{if $recent && count($recent) > 0}
    <h3 class="press_tsb_categories"><span>Recent posts</span></h3>
      <ul class="list-entries">
        {foreach from=$recent key=k item=row}
            {assign var=class value=$k%2}
            <li class="class-{$class}">
                <a href="{$row.url}">
                    {if $row.photo}
                        <img width="50" src="{$row.photo}" style="float:left"/>
                    {/if}
                    <span class="title">{$row.title}</span>
                    <div class="content">
                        {$row.content}
                    </div>
                </a>
                <div class="clearthis"></div>
            </li>
        {/foreach}
      </ul>
{/if}
