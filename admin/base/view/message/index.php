<ul class="nav nav-tabs">
    <li class="active"><a href="javascript:;">留言列表</a></li>
</ul>
 <div class="layui-form">

    <div class="cf well form-search row">

         <form  method="get">
             <div class="fl">
                 <div class="btn-group">
                     <input name="name" value="{:input('name')}" placeholder="输入姓名查找" class="form-control"  type="text">
                 </div>
                
                 <div class="btn-group">
                     <button type="submit" class="btn btn-success">查询</button>
                 </div>
             </div>
         </form>
     </div>
     <span class="btn btn-success batch" data-msg="确定要删除选中留言吗" data-url="{:url('Message/batchDelMessage')}" >删除</span>
     <span class="btn btn-success batch" data-url="{:url('Message/batchReadMessage')}">标记已读</span>

     <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="15"><input type="checkbox"  lay-skin="primary" lay-filter="allChoose">
                <th width="30">姓名</th>
                <th width="30">电话</th>
                <th width="30">邮箱</th>
                <th width="250">留言</th>
                <th width="30">留言时间 <span order="sendtime" class="order-sort"> </span></th>
                <th width="30">ip</th>
                <th width="30">状态{if $unread_num}<span class="layui-badge">{$unread_num}</span>{/if}</th>
                <th width="30">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><input type="checkbox" name="batch_id" data-id="{$v.id}" lay-skin="primary" lay-filter="itemChoose"></td>
                    <td>{$v.name}</td>
                    <td>{$v.phone}</td>
                    <td>{$v.email}</td>
                    <td>{$v.message}</td>
                    <td>{$v.sendtime|date="Y-m-d H:i:s",###}</td>
                    <td>{$v.ip}</td>
                    <td>
                        {if condition="$v.isstate eq 1"}
                            <a  class="span">已读</a>
                        {else/}
                            <a  class="span-post" post-url="{:url('message/messageIsstate',['id'=>$v['id']])}" style="color:red">未读</a>
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('message/messageDel',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('message/messageDel',['id'=>$v['id']])}">删除</a>
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