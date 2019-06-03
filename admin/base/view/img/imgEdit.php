<ul class="nav nav-tabs">
    {if condition="checkPath('img/index')"}
    <li><a href="{:Url('img/index')}">广告列表</a></li>
    {/if}
    {if condition="checkPath('img/imgAdd')"}
    <li><a href="{:Url('img/imgAdd')}">添加广告</a></li>
    {/if}
    {if condition="checkPath('img/imgEdit',['id'=>$info.id])"}
    <li class="active"><a href="{:Url('img/imgEdit',['id'=>$info.id])}">修改广告</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('img/imgEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_img" /}
</form>
