
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>网站名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}" placeholder="网站名称">
                </td>
            </tr>
            <tr>
                <th>网站地址</th>
                <td>
                    <input class="form-control text" type="text" name="linkurl" value="{$info.linkurl??''}" placeholder="网站地址"><span class="form-required" size="3">以 http:// 开头</span>
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

