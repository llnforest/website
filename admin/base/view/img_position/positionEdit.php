<ul class="nav nav-tabs">
    {if condition="checkPath('imgPosition/index')"}
    <li><a href="{:Url('imgPosition/index')}">广告位置列表</a></li>
    {/if}
    {if condition="checkPath('imgPosition/positionAdd')"}
    <li><a href="{:Url('imgPosition/positionAdd')}">添加广告位置</a></li>
    {/if}
    {if condition="checkPath('imgPosition/positionEdit',['id'=>$info.id])"}
    <li class="active"><a href="{:Url('imgPosition/positionEdit',['id'=>$info.id])}">修改广告位置</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('imgPosition/positionEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_position" /}
</form>
