
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>标识名称</th>
                <td>
                    <input class="form-control text" type="text" name="title" value="{$info.title??''}" placeholder="标识名称">
                </td>
            </tr>
            <tr>
                <th>标识</th>
                <td>
                    <input class="form-control text" type="text" name="mark" value="{$info.mark??''}" placeholder="标识">
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

