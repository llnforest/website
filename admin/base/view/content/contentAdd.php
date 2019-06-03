<ul class="nav nav-tabs">
    {if condition="checkPath('content/index')"}
    <li><a href="{:Url('content/index')}">信息列表</a></li>
    {/if}
    {if condition="checkPath('content/contentAdd')"}
    <li class="active"><a href="{:Url('content/contentAdd')}">添加信息</a></li>
    {/if}
    
</ul>
<form  class="form-horizontal" action="{:url('content/contentAdd')}" method="post">
    {include file="form:form_content" /}
</form>
