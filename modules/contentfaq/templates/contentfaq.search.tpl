{literal}
    <style type="text/css">
        .faq-search-content {
            margin-bottom: 30px;
            float: left;
        }
        .faq-search-content .input-search{
            width: 400px;
        }
        .faq-search-content .btn-search {
            float: right;
            margin-left: 10px;
        }
        span.read-more-text a, span.re-collapse a{line-height: 50px}
        .query-found {
            background-color: #b3c7e1;
        }
    </style>
{/literal}

<div class="faq-search-content">
    <form action="{$ROOTURL}/?module=contentfaq&action=faq" id="frmFaqSearch" method="post" class="faq-search-form" >
        <input type="text" id="query-search" class="input-text input-search" name="query" placeholder="Search" value="{$query}" />
        <button class="btn-search" onclick="document.getElementById('frmFaqSearch').submit()"></button>
    </form>
</div>
<div class="clearthis"></div>