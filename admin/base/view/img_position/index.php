<ul class="nav nav-tabs">
    {if condition="checkPath('imgPosition/index')"}
    <li class="active"><a href="{:Url('imgPosition/index')}">广告位置列表</a></li>
    {/if}
    {if condition="checkPath('imgPosition/positionAdd')"}
    <li><a href="{:Url('imgPosition/positionAdd')}">添加广告位置</a></li>
    {/if}
</ul>
 <div class="layui-form">
     <span  class="btn btn-success batch" data-msg="确定要删除选中信息吗" data-url="{:url('imgPosition/batchDelPosition')}">删除</span>
     <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="15"><input type="checkbox"  lay-skin="primary" lay-filter="allChoose">
                <th width="15">ID</th>
                <th width="80">广告位置名称</th>
                <th width="80">排序<span order="sort" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><input type="checkbox" name="batch_id" data-id="{$v.id}" lay-skin="primary" lay-filter="itemChoose"></td>
                    <td>{$v.id}</td>
                    <td>{$v.name}</td>
                    <td>
                        {if condition="checkPath('imgPosition/inputPosition')"}
                        <input class="form-control change-data short-input"  post-id="{$v.id}" post-url="{:url('imgPosition/inputPosition')}" data-name="sort" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('imgPosition/positionEdit',['id'=>$v['id']])"}
                        <a  href="{:url('imgPosition/positionEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('imgPosition/positionDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('imgPosition/positionDelete',['id'=>$v['id']])}">删除</a>
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