
    <table id="chart" style="width:59%;margin: 0 auto;display: none;">
        <caption>{$title_chart}</caption>
        <thead>
        <tr>
            <td></td>
        {$day_str}
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        {foreach from = $type key = k item = val}
        <tr>
            <th scope="row">{$val}</th>
            {foreach from = $data[$k] key = k item = val2}
                <td>{$val2}</td>
            {/foreach}
            <td></td>
        </tr>
        {/foreach}
        <tr>
            <th scope="row">Total</th>
            <td></td>
        </tr>
        </tbody>
    </table>
