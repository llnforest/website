<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace model;

class BaseContentCategoryModel extends \think\Model
{
    // 设置完整的数据表（包含前缀）通用分类表
    protected $name = 'tp_base_content_category';

    //初始化属性
    protected function initialize()
    {
    }

}
?>