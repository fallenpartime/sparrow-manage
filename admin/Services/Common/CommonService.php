<?php
/**
 * 常用服务
 * Date: 2018/10/7
 * Time: 11:23
 */
namespace Admin\Services\Common;

class CommonService
{
    /**
     * 分页
     * @param $count
     * @param $perlogs
     * @param $page
     * @param $url
     * @param string $suffix
     * @return array
     */
    public static function pagination($count, $perlogs, $page, $url, $suffix = '')
    {
        $url .= '&page=';
        $pnums = @ceil($count / $perlogs);
        $re = '';
        for ($i = $page - 3; $i <= $page + 3 && $i <= $pnums; $i++) {
            if ($i > 0) {
                if ($i == $page) {
                    $re .= '<span><a class="paginate_active">'.$i.'</a></span>';
                } else {
                    $re .= '<span><a class="paginate_button" href="'.$url.$i.$suffix.'">'.$i.'</a></span>';
                }
            }
        }
        //上一页
        if( $page > 1 )
            $re = '<a class="paginate_button" href="'.$url.($page-1).$suffix.'">上一页</a>' . $re;
        //下一页
        if( $page < $pnums )
            $re .= '<a class="paginate_button" href="'.$url.($page+1).$suffix.'">下一页</a>';
        //首页
        if ($page > 1) //4
            //$re = '<a href="' . $url . '1' . $suffix . '" title="首页">&laquo;</a> ...' . $re;
            $re = '<a class="first paginate_button" href="'.$url.'1'.$suffix.'">首页</a>' . $re;
        //尾页
        if ($page + 0 < $pnums) //$page + 3 < $pnums
            //$re .= '<a href="' . $url . $pnums . $suffix . '" title="尾页">&raquo;</a>';
            $re .= '<a class="last paginate_button" href="'.$url.$pnums.$suffix.'">尾页</a>';

        if ($pnums <= 1)
            $re = '';

        $url .= $page;
        $start = '<div class="dataTables_paginate paging_full_numbers" style="width:1000px;"  >';
        $end = '</div>';
        $total = '<span><a class="paginate_active">总数：'.$count.'</a></span>';
        return [$url, $start.$re.$total.$end];
    }
}