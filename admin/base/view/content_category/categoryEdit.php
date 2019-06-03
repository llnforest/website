<ul class="nav nav-tabs">
    {if condition="checkPath('contentCategory/index',['mark'=>input('mark')])"}
    <li><a href="{:Url('contentCategory/index',['mark'=>input('mark')])}">分类列表</a></li>
    {/if}
    {if condition="checkPath('contentCategory/categoryAdd',['mark'=>input('mark')])"}
    <li><a href="{:Url('contentCategory/categoryAdd',['mark'=>input('mark')])}">添加分类</a></li>
    {/if}
    {if condition="checkPath('contentCategory/categoryEdit',['id'=>$info.id])"}
    <li class="active"><a href="{:Url('contentCategory/categoryEdit',['id'=>$info.id])}">修改分类</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('contentCategory/categoryEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_category" /}
</form>
