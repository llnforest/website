<ul class="nav nav-tabs">
    {if condition="checkPath('link/index')"}
    <li><a href="{:Url('link/index')}">友情链接列表</a></li>
    {/if}
    {if condition="checkPath('link/linkAdd')"}
    <li><a href="{:Url('link/linkAdd')}">添加友情链接</a></li>
    {/if}
    {if condition="checkPath('link/linkEdit',['id'=>$info.id])"}
    <li class="active"><a href="{:Url('link/linkEdit',['id'=>$info.id])}">修改友情链接</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('link/linkEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_link" /}
</form>
