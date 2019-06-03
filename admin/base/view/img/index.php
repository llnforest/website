<ul class="nav nav-tabs">
    {if condition="checkPath('img/index')"}
    <li class="active"><a href="{:Url('img/index')}">广告列表</a></li>
    {/if}
    {if condition="checkPath('img/imgAdd')"}
    <li><a href="{:Url('img/imgAdd')}">添加广告</a></li>
    {/if}
</ul>
 <div class="layui-form">
     <div class="cf well form-search row">

         <form  method="get">
             <div class="fl">
                 <div class="btn-group">
                     <input name="title" value="{:input('title')}" placeholder="广告标题" class="form-control"  type="text">
                 </div>
                 <div class="btn-group layui-form">
                     <select name="position_id" class="form-control" lay-search>
                         <option value="">全部分类</option>
                         {foreach $cateList as $item}
                         <option value="{$item.id}" {if input('position_id') == $item.id}selected{/if}>{$item.name}</option>
                         {/foreach}
                     </select>
                 </div>
                 <div class="btn-group">
                     <button type="submit" class="btn btn-success">查询</button>
                 </div>
             </div>
         </form>
     </div>
     <span class="btn btn-success batch" data-msg="确定要删除选中信息吗" data-url="{:url('img/batchDelImg')}" >删除</span>
     <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="15"><input type="checkbox"  lay-skin="primary" lay-filter="allChoose">
                <th width="80">封面图片</th>
                <th width="80">广告标题</th>
                <th width="80">排序<span order="sort" class="order-sort"> </span></th>
                <th width="80">分类</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><input type="checkbox" name="batch_id" data-id="{$v.id}" lay-skin="primary" lay-filter="itemChoose"></td>
                    <td><img class="mini-image" src="{$v.url?'__ImagePath__'.$v.url:''}" style="width:80px"></td>
                    <td>{$v.title}</td>
                    <td>
                        {if condition="checkPath('img/inputImg')"}
                        <input class="form-control change-data short-input"  post-id="{$v.id}" post-url="{:url('img/inputImg')}" data-name="sort" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>{$v.name}</td>
                
                    <td>
                        {if condition="checkPath('img/imgEdit',['id'=>$v['id']])"}
                        <a  href="{:url('img/imgEdit',['id'=>$v['id'],'position_id'=>$v['position_id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('img/imgDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('img/imgDelete',['id'=>$v['id']])}">删除</a>
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