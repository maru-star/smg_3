@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<script>
  $(function(){
    $(".table").DataTable({
    lengthChange: false,// 件数切替機能 無効
    searching: false,// 検索機能 無効
    ordering: true,// ソート機能 無効
    info: false,// 情報表示 無効
    paging: false,// ページング機能 無効
    aoColumnDefs: [{"bSortable": false, "aTargets": [7]}],
    });
  })
</script>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">会場一覧</h1>
  <hr>
  <div class="d-flex justify-content-between mt-3 mb-5">
    <span>{{$querys->count()}}件表示</span>
    <div>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" data-offset="-320,5">
          検索
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <form class="" action="{{url('/admin/venues')}}">
            @csrf
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="freeword">フリーワード検索</label>
                <input type="text" name="freeword" class="form-control" id="freeword">
              </div>
              <div class="form-group">
                <label for="id">ID</label>
                <input type="text" name="id" class="form-control" id="id">
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="alliance_flag">直営・提携</label>
                <input type="text" name="alliance_flag" class="form-control" id="alliance_flag">
              </div>
              <div class="form-group">
                <label for="name_area">エリア別</label>
                <input type="text" name="name_area" class="form-control" id="name_area">
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="name_bldg">ビル名</label>
                <input type="text" name="name_bldg" class="form-control" id="name_bldg">
              </div>
              <div class="form-group">
                <label for="name_venue">会場名</label>
                <input type="text" name="name_venue" class="form-control" id="name_venue">
              </div>
            </div>
            <div class="d-flex justify-content-around col-md-12">
              <div class="form-group">
                <label for="name_bldg">収容人数（~名以上）</label>
                <input type="number" name="capacity1" class="form-control" id="capacity">
              </div>
              <div class="form-group">
                <label for="name_venue">収容人数（~名以下）</label>
                <input type="number" name="capacity2" class="form-control">
              </div>
            </div>
            <div class="mx-auto" style="width: 50px;">
              <input type="submit" value="検索" class="btn btn-info">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th>直営・提携</th>
      <th>会場</th>
      <th>広さ（坪）</th>
      <th>広さ（㎡）</th>
      <th>収容人数</th>
      <th>詳細</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($querys as $query)
    <tr>
      <td>{{ $query->id }}</td>
      <td>{{ $query->created_at }}</td>
      <td>{{ $query->alliance_flag==0?'直営':'提携' }}</td>
      <td>{{ $query->name_area }}{{ $query->name_bldg }}{{ $query->name_venue }}</td>
      <td>{{ $query->size1 }}</td>
      <td>{{ $query->size2 }}</td>
      <td>{{ $query->capacity }}</td>
      <td><a href="{{ url('/admin/venues', $query->id) }}">詳細</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $querys->links() }}
@endsection