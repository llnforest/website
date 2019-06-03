<ul class="nav nav-tabs">
    {if condition="checkPath('info/index')"}
    <li class="active"><a href="{:Url('info/index')}">网站信息</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('info/index',['id'=>$info.id])}" method="post">
    {include file="form:form_info" /}
</form>
