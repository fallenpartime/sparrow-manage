@extends('front.article.listmain')
@section('title', '教育快讯')
@section('body_content')
    <div class="container">
        <ul class="article-list">
        </ul>
    </div>
    <script>
        $(function(){
            var isLoad =true;
            var code = '';
            var currentPage = 1;
            var nomore_Text = '没有更多数据';
            $(window).scroll(function(){
                //是否滚动到底部
                console.log('cesjo');
                var _needload = isScrollLoad();
                if(_needload && isLoad){
                    getPage();
                }
            });
            window.onload = function(){
                //加载数据
                getPage();
            };

            // 获取分页数据
            function getPage(){
                isLoad = false;
                $.ajax({
                    url:"{{ route('front.news') }}",
                    type:"post",
                    data: {currentPage: currentPage, code: code},
                    success:function(data){
                        var data = JSON.parse(data).data;
                        code = data.code;
                        isLoad = true;
                        pageData(data.list,data.pageCount,data.pageNo);
                    },
                    error:function(e){
                        alert("错误！！");
                    }
                })
            }
            // 得到分页数据后看是否需要渲染
            // data:新闻列表 pageCount：页总数 pageNo：当前页数
            function pageData(data, pageCount, pageNo){
                currentPage++;
                var html = '';
                $.each(data,function(index,item){
                    html+='<li class="list-item list-shadow">'+
                        '<a href="'+item.link+'" class="itemContain">'+
                        '<div class="cover">'+
                        '<img src="'+item.image+'" alt="">'+
                        '</div>'+
                        '<div class="cont">'+
                        '<h2 class="title">'+item.title+'</h2>'+
                        '<p class="desc">'+item.desc+'</p>'+
                        '</div>'+
                        '</a>'+
                        '</li>'
                });
                $('.article-list').append(html);
                if(pageCount == pageNo || currentPage > pageCount){
                    //数据全部加载完毕
                    isLoad = false;
                }
            }
            // 判断是否加载接口
            function isScrollLoad(){
                //加载更多距离
                var btn_top = $("body").height();
                //窗体高度
                var window_height = $(window).height();
                //滚动距离
                var scroll_Top = $(window).scrollTop();
                //是否需要加载(底部距离是否小于窗口高度+滚动的距离)
                console.log(btn_top,window_height,scroll_Top);
                return btn_top < scroll_Top + window_height + 30  ? true : false;
            }
        })
    </script>
@endsection