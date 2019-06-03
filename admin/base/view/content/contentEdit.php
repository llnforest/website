<ul class="nav nav-tabs">
    {if condition="checkPath('content/index')"}
    <li><a href="{:Url('content/index')}">信息列表</a></li>
    {/if}
    {if condition="checkPath('content/contentAdd')"}
    <li><a href="{:Url('content/contentAdd')}">添加信息</a></li>
    {/if}
    {if condition="checkPath('content/contentEdit',['id'=>$info.id])"}
    <li class="active"><a href="{:Url('content/contentEdit',['id'=>$info.id])}">修改信息</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('content/contentEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_content" /}
</form>
