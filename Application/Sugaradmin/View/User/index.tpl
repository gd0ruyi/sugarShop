<!--导航条-->
<ol class="breadcrumb">
  <li><a href="#">首页</a></li>
  <li class="active">用户管理</li>
</ol>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">用户列表</h3>
  </div>
  <div class="panel-body sgtable-toolbar">
    <!-- 工具组 -->
    <div class="btn-toolbar pull-right" role="toolbar" aria-label="Toolbar with button groups">
      <div class="btn-group" role="group" aria-label="Setting groups">
        <button type="button" class="btn btn-primary" sugar-dialog="true" sugar-target-id="user-edit" sugar-url="/Sugaradmin/User/edit" sugar-data="" title="创建用户">
          <span class="glyphicon glyphicon-plus"></span>
        </button>
      </div>
      <!-- <div class="btn-group" role="group" aria-label="Second group">
          <button type="button" class="btn btn-default">5</button>
          <button type="button" class="btn btn-default">6</button>
          <button type="button" class="btn btn-default">7</button>
        </div>
        <div class="btn-group" role="group" aria-label="Third group">
          <button type="button" class="btn btn-default">8</button>
        </div> -->
    </div>
  </div>
  <div class="panel-body">
    <!-- 表单 -->
    <form class="form-inline" id="user-form">

      <div class="form-group form-group-sm">
        <div class="input-group">
          <div class="input-group-btn" sugar-selector="true">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <font>关键字</font> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="#" value="name">姓名</a></li>
              <li><a href="#" value="email">邮箱</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#" value="all">关键字</a></li>
            </ul>
            <input type="hidden" name="keyword_type" value="">
          </div><!-- /btn-group -->
          <input type="text" class="form-control" id="user_keyword" name="user_keyword" placeholder="请输入关键字">
        </div>
      </div>

      <div class="form-group form-group-sm">
        <div class="btn-group" sugar-selector="true">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <font>全部类型</font> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#" value="0">管理员</a></li>
            <li><a href="#" value="1">普通用户</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" value="all">全部类型</a></li>
          </ul>
          <input type="hidden" name="user_type" value="">
        </div>
      </div>

      <div class="form-group form-group-sm">
        <div class="btn-group" sugar-selector="true">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <font>全部状态</font> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#" value="0">启用</a></li>
            <li><a href="#" value="1">禁用</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" value="all">全部状态</a></li>
          </ul>
          <input type="hidden" name="status" value="">
        </div>
      </div>

      <div class="form-group form-group-sm">
        <button type="submit" class="btn btn-primary">搜 索</button>
      </div>

      <div class="table-responsive">
        <table id="user-table" title="管理员列表-表格内容" class="table table-striped table-bordered table-hover ajax-tables">
        </table>
      </div>
    </form>
  </div>
</div>
<script language="javascript" type="text/javascript">
  // 创建下拉，使用标签属性为<element sugar-selector="true" ></element>
  // SugarCommons.createSelectInput();

  // 加载自定义插件
  SugarCommons.createPlugin();

  // 执行创建表格
  var columns = {
    'user_id': {
      th: { title: 'ID', sort_icon: true, sort_default: 'asc', class: 'text-center' },
      td: { style: "color:red; text-align:center" }
    },
    'username': {
      th: { title: '帐号', sort_icon: true, class: 'text-center' },
    },
    'use_type': {
      th: { title: '帐号类型', sort_icon: true, class: 'text-center' },
      td: { template: "{use_type_name}", class: 'text-center' }
    },
    'status': {
      th: { title: '状态', sort_icon: true, class: 'text-center' },
      td: { template: "{status_name}", class: 'text-center' }
    },
    'truename': {
      th: { title: '姓名', sort_icon: true, class: 'text-center' },
    },
    'email': {
      th: { title: '邮箱', sort_icon: true, class: 'text-center' },
    },
    'mobile': {
      th: { title: '电话', sort_icon: true, class: 'text-center' },
    },
    'add_time': {
      th: { title: '创建时间', class: 'text-center', sort_icon: true },
      td: { template: "{add_time_format}", class: 'text-center' }
    },
    'upd_time': {
      th: { title: '更新时间', class: 'text-center', sort_icon: true },
      td: { template: "{upd_time_format}", class: 'text-center' }
    },
    'las_time': {
      th: { title: '登录时间', class: 'text-center', sort_icon: true },
      td: { template: "{las_time_format}", class: 'text-center' }
    },
    'other': {
      th: { title: '描述说明', title_length: 12, class: 'text-center' },
      td: { template: '{username} 用户的登录时间为： {las_time_format}' }
    },
    'operation': {
      th: { title: '操作', class: 'text-center' },
      td: { class: 'text-center' }
    },
  };
  SugarTables.create('#user-form', '#user-table', '/Sugaradmin/User/loadAjax', columns);  
</script>