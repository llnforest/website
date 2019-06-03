<ul class="nav nav-tabs">
    {if condition="checkPath('contentCategory/index',['mark'=>'service'])"}
    <li class="active"><a href="{:Url('contentCategory/index',['mark'=>input('mark')])}">分类列表</a></li>
    {/if}
    {if condition="checkPath('contentCategory/categoryAdd')"}
    <li><a href="{:Url('contentCategory/categoryAdd',['mark'=>input('mark')])}">添加分类</a></li>
    {/if}
</ul>
 <div class="layui-form">
     <div class="cf well form-search row">

         <form  method="get">
             <div class="fl">
                 <div class="btn-group">
                     <input name="name" value="{:input('name')}" placeholder="分类名称" class="form-control"  type="text">
                 </div>
                 <div class="btn-group layui-form">
                     <select name="mark" class="form-control" lay-search>
                         <option value="">全部标识</option>
                         {foreach $markList as $item}
                         <option value="{$item.mark}" {if input('mark') == $item.mark}selected{/if}>{$item.title}</option>
                         {/foreach}
                     </select>
                 </div>
                 <div class="btn-group">
                     <button type="submit" class="btn btn-success">查询</button>
                 </div>
             </div>
         </form>
     </div>
     <span class="btn btn-success batch" data-msg="确定要删除选中信息吗" data-url="{:url('contentCategory/batchDelCategory')}" >删除</span>
     <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="15"><input type="checkbox"  lay-skin="primary" lay-filter="allChoose">
                <th width="80">所属标识</th>
                <th width="80">分类名称</th>
                <th width="80">排序<span order="sort" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>

            {foreach $list as $v}
                <tr>
                    <td><input type="checkbox" name="batch_id" data-id="{$v.id}"  lay-skin="primary" lay-filter="itemChoose"></td>
                    <td>{$v.title}</td>
                    <td>{$v.name}</td>
                    <td>
                        {if condition="checkPath('contentCategory/inputCategory')"}
                        <input class="form-control change-data short-input"  post-id="{$v.id}" post-url="{:url('contentCategory/inputCategory')}" data-name="sort" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('contentCategory/categoryEdit',['id'=>$v['id']])"}
                        <a  href="{:url('contentCategory/categoryEdit',['id'=>$v['id'],'mark'=>$v['mark']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('contentCategory/categoryDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('contentCategory/categoryDelete',['id'=>$v['id'],'mark'=>input('mark')])}">删除</a>
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