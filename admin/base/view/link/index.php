<ul class="nav nav-tabs">
    {if condition="checkPath('link/index')"}
    <li class="active"><a href="{:Url('link/index')}">友情链接列表</a></li>
    {/if}
    {if condition="checkPath('link/linkAdd')"}
    <li><a href="{:Url('link/linkAdd')}">添加友情链接</a></li>
    {/if}
</ul>
 <div class="layui-form">
        <span  class="btn btn-success batch" data-msg="确定要删除选中信息吗" data-url="{:url('link/batchDelLink')}" >删除</span>
        <table class="table table-hover table-bordered table-list layui-table" id="menus-table">
            <thead>
            <tr>
                <th width="15"><input type="checkbox"  lay-skin="primary" lay-filter="allChoose">
                <th width="250">网站名称</th>
                <th width="250">网站地址</th>
                <th width="50">排序<span order="sort" class="order-sort"> </span></th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><input type="checkbox" name="batch_id" data-id="{$v.id}" lay-skin="primary" lay-filter="itemChoose"></td>
                    <td>{$v.name}</td>
                    <td>{$v.linkurl}</td>
                    <td>
                        {if condition="checkPath('link/inputLink')"}
                        <input class="form-control change-data short-input"  post-id="{$v.id}" post-url="{:url('link/inputLink')}" data-name="sort" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('link/linkEdit',['id'=>$v['id']])"}
                        <a  href="{:url('link/linkEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('link/linkDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('link/linkDelete',['id'=>$v['id']])}">删除</a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {$page}
    </div>
