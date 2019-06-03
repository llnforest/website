
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>标识分类</th>
                <td >
                    <div class="layui-form select">
                        <select name="mark" class="form-control text">
                            {foreach $markList as $item}
                            <option value="{$item.mark}" {if input('mark') == $item.mark}selected{/if}>{$item.title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <span class="form-required">*</span>
                </td>
            </tr>
    
            <tr>
                <th>分类名称 </th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}" placeholder="分类名称">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>分类排序</th>
                <td>
                    <input class="form-control text" type="text" name="sort" value="{$info.sort??''}" placeholder="分类排序">
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

