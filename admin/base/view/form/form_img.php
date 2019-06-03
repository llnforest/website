<script type="text/javascript" charset="utf-8" src="__PublicAdmin__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PublicAdmin__/ueditor/ueditor.all.min.js"> </script>
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>广告位置分类</th>
                <td>
                    <div class="layui-form select">
                    <select name="position_id" class="form-control text">
                        {foreach $cateList as $item}
                        <option value="{$item.id}" {if input('position_id') == $item.id}selected{/if}>{$item.name}</option>
                        {/foreach}
                    </select>
                    </div>
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>广告标题</th>
                <td>
                    <input class="form-control text" type="text" name="title" value="{$info.title??''}" placeholder="广告标题">
                    <span class="form-required">*</span>
                </td>
            </tr>
           

            <tr>
                <th>封面图片</th>
                <td>
                    <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('index/upload/image',['type'=>'cases'])}'}">
                        <i class="layui-icon">&#xe67c;</i>上传封面图片
                        <input class="image" type="hidden" name="url" value="{$info.url??''}">
                        <img class="mini-image {$info.url?'':'hidden'}" data-path="__ImagePath__" src="{$info.url?'__ImagePath__'.$info.url:''}">
                    </button>
                    <span class="red block">(图片建议大小 116*90)</span>
                </td>
            </tr>
            
            
            <tr>
                <th>排序</th>
                <td>
                    <input class="form-control text" type="text" name="sort" value="{$info.sort??''}" placeholder="排序">
                </td>
            </tr>

            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-success form-post " >保存</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
