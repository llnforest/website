<ul class="nav nav-tabs">
    {if condition="checkPath('link/index')"}
    <li><a href="{:Url('link/index')}">友情链接列表</a></li>
    {/if}
    {if condition="checkPath('link/linkAdd')"}
    <li class="active"><a href="{:Url('link/linkAdd')}">添加友情链接</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('link/linkAdd')}" method="post">
    {include file="form:form_link" /}
</form>
