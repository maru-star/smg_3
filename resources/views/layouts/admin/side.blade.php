<script>
  $(function () {
        // こちらを参考
        // https://designsupply-web.com/media/knowledgeside/1592/
        function link_check(link,classes){
            var path = location.pathname
            if (path == link){
            var target=$("."+classes);
            $(target).addClass('active');
            $(target).parent().parent().parent().addClass('menu-open');
            }
        }
        link_check('/admin/venues','venues-index');
        link_check('/admin/venues/create','venues-create');
        link_check('/admin/equipments','venues-equipments');
        link_check('/admin/services','venues-services');
        link_check('/admin/dates','venues-dates');
        link_check('/admin/frame_prices','venues-price');
        link_check('/admin/agents','agent-index');
        link_check('/admin/agents/create','agent-create');
        link_check('/admin/clients','clients-index');
        link_check('/admin/clients/create','clients-create');
   });

</script>

<div class="sidebar">

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book-open" style="color:red;"></i>
          <p>予約<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>一括登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-calendar-week" style="color:yellow;"></i>
          <p>予約状況カレンダー<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="far fa-circle nav-icon"></i>
              <p>利用日時</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>会場別</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link ">
          <i class="nav-icon fas fa-tasks" style="color:green;"></i>
          <p>顧客管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/clients') }}" class="nav-link clients-index">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/clients/create') }}" class="nav-link clients-create">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link venues">
          <i class="nav-icon fas fa-map-marker-alt" style="color:aqua;"></i>
          <p>会場管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/venues') }}" class="nav-link venues-index">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/venues/create') }}" class="nav-link venues-create">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/equipments') }}" class="nav-link venues-equipments">
              <i class="far fa-circle nav-icon"></i>
              <p>有料備品管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/services') }}" class="nav-link venues-services">
              <i class="far fa-circle nav-icon"></i>
              <p>有料サービス管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/dates') }}" class="nav-link venues-dates">
              <i class="far fa-circle nav-icon"></i>
              <p>営業時間管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/frame_prices') }}" class="nav-link venues-price">
              <i class="far fa-circle nav-icon"></i>
              <p>料金管理</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-yen-sign" style="color:blue;"></i>
          <p>売上請求情報<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>########</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-building" style="color:magenta;"></i>
          <p>仲介会社<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/agents') }}" class="nav-link agent-index">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/agents/create') }}" class="nav-link agent-create">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-mail-bulk" style="color:salmon;"></i>
          <p>メールテンプレート管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-shield" style="color:seagreen;"></i>
          <p>管理者管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>







    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->