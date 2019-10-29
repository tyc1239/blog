<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.2</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{url('css/font.css')}}">
    <link rel="stylesheet" href="{{url('css/xadmin.css')}}">
    <!-- <link rel="stylesheet" href="./css/theme5.css"> -->
    <script src="{{url('lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('js/xadmin.js')}}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="{{url('https://cdn.staticfile.org/html5shiv/r29/html5.min.js')}}"></script>
    <script src="{{url('https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body class="index">
<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="./index.html">X-admin v2.2</a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('最大化','http://www.baidu.com','','',true)">
                        <i class="iconfont">&#xe6a2;</i>弹出最大化</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出自动宽高','http://www.baidu.com')">
                        <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出指定宽高','http://www.baidu.com',500,300)">
                        <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开','member-list.html')">
                        <i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开刷新','member-del.html',true)">
                        <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">admin</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('个人信息','http://www.baidu.com')">个人信息</a></dd>
                <dd>
                    <a onclick="xadmin.open('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
                <dd>
                    <a href="/admins/loginout">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index">
            <a href="/admin/index">前台首页</a></li>
    </ul>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>公众号管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('首次关注回复设置','/admins/replay')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>首次关注回复设置</cite></a>
                        </a>
                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('首次关注回复设置类型','/admins/settype')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>首次关注回复设置类型</cite></a>
                        </a>
                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('更新日志','log.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>更新日志</cite></a>
                    </li>
                </ul>
            </li>




        </ul>
        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>素材管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">

                    <li>
                        <a onclick="xadmin.add_tab('首次关注回复设置','/material/list')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>素材列表展示图片</cite></a>
                        </a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('首次关注回复设置','/material/tlist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>素材列表展示语音</cite></a>
                        </a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('首次关注回复设置','/material/slist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>素材列表展示视频</cite></a>
                        </a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('素材管理页面','/material/index')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>素材上传内容</cite></a>
                    </li>

                </ul>
            </li>




        </ul>

        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>微信红包</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('微信红包列表添加','/material/hongbao')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>微信红包列表添加</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('微信红包列表展示','/material/hblist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>微信抢红包列表</cite></a>
                    </li>

                </ul>
            </li>




        </ul>
        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>群发</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('根据openid群发','/material/groupsendopenid')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>根据openid群发</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('根据标签进行群发','/material/tagindex')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>根据标签进行群发</cite></a>
                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('根据标签进行群发!','/material/getuserlist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>根据标签进行群发!</cite></a>
                    </li>

                </ul>
            </li>

        </ul>

        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>粉丝管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('粉丝列表','/material/fanslist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>粉丝列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('标签列表','/material/taglist')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>标签列表</cite></a>

                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('标签添加','/material/tagadd')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>标签添加</cite></a>

                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('给用户添加标签','/material/addusertag')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>给用户添加标签</cite></a>

                    </li>

                </ul>
            </li>

        </ul>

        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="自定义菜单管理">&#xe6b4;</i>
                    <cite>自定义菜单管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">

                    <li>
                        <a onclick="xadmin.add_tab('自定义菜单','/material/menuindex')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>发送</cite></a>
                        </a>
                    </li>

                </ul>
            </li>




        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home">
                <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd></dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                {{--<iframe src='./welcome.html' frameborder="0" scrolling="yes" class="x-iframe"></iframe>--}}
                >
                <div class="layui-fluid">
                    <div class="layui-row layui-col-space15">
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-body ">
                                    <blockquote class="layui-elem-quote">欢迎管理员：
                                        <span class="x-red">test</span>！当前时间:2018-04-25 20:50:53
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">数据统计</div>
                                <div class="layui-card-body ">
                                    <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                                        <li class="layui-col-md2 layui-col-xs6">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>66</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-md2 layui-col-xs6">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>会员数</h3>
                                                <p>
                                                    <cite>12</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-md2 layui-col-xs6">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>回复数</h3>
                                                <p>
                                                    <cite>99</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-md2 layui-col-xs6">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>商品数</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-md2 layui-col-xs6">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-md2 layui-col-xs6 ">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>6766</cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm6 layui-col-md3">
                            <div class="layui-card">
                                <div class="layui-card-header">下载
                                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                                <div class="layui-card-body  ">
                                    <p class="layuiadmin-big-font">33,555</p>
                                    <p>新下载
                                <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm6 layui-col-md3">
                            <div class="layui-card">
                                <div class="layui-card-header">下载
                                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                                <div class="layui-card-body ">
                                    <p class="layuiadmin-big-font">33,555</p>
                                    <p>新下载
                                <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm6 layui-col-md3">
                            <div class="layui-card">
                                <div class="layui-card-header">下载
                                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                                <div class="layui-card-body ">
                                    <p class="layuiadmin-big-font">33,555</p>
                                    <p>新下载
                                <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm6 layui-col-md3">
                            <div class="layui-card">
                                <div class="layui-card-header">下载
                                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                                <div class="layui-card-body ">
                                    <p class="layuiadmin-big-font">33,555</p>
                                    <p>新下载
                                <span class="layuiadmin-span-color">10%
                                    <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">系统信息</div>
                                <div class="layui-card-body ">
                                    <table class="layui-table">
                                        <tbody>
                                        <tr>
                                            <th>xxx版本</th>
                                            <td>1.0.180420</td></tr>
                                        <tr>
                                            <th>服务器地址</th>
                                            <td>x.xuebingsi.com</td></tr>
                                        <tr>
                                            <th>操作系统</th>
                                            <td>WINNT</td></tr>
                                        <tr>
                                            <th>运行环境</th>
                                            <td>Apache/2.4.23 (Win32) OpenSSL/1.0.2j mod_fcgid/2.3.9</td></tr>
                                        <tr>
                                            <th>PHP版本</th>
                                            <td>5.6.27</td></tr>
                                        <tr>
                                            <th>PHP运行方式</th>
                                            <td>cgi-fcgi</td></tr>
                                        <tr>
                                            <th>MYSQL版本</th>
                                            <td>5.5.53</td></tr>
                                        <tr>
                                            <th>ThinkPHP</th>
                                            <td>5.0.18</td></tr>
                                        <tr>
                                            <th>上传附件限制</th>
                                            <td>2M</td></tr>
                                        <tr>
                                            <th>执行时间限制</th>
                                            <td>30s</td></tr>
                                        <tr>
                                            <th>剩余空间</th>
                                            <td>86015.2M</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">开发团队</div>
                                <div class="layui-card-body ">
                                    <table class="layui-table">
                                        <tbody>
                                        <tr>
                                            <th>版权所有</th>
                                            <td>xuebingsi(xuebingsi)
                                                <a href="http://x.xuebingsi.com/" target="_blank">访问官网</a></td>
                                        </tr>
                                        <tr>
                                            <th>开发者</th>
                                            <td>马志斌(113664000@qq.com)</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <style id="welcome_style"></style>
                        <div class="layui-col-md12">
                            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本系统由x-admin提供技术支持。</blockquote></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tab_show"></div>
</div>
</div>
<div class="page-content-bg"></div>
<style id="theme_style"></style>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<script>//百度统计可去掉
    var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>

