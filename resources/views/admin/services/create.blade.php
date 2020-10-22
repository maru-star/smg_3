@extends('layouts.admin.app')

@section('content')

<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
    </ol>
  </nav>
</div>
<h1 class="mt-3 mb-5">有料サービス管理　新規作成</h1>
<div class="text-right mb-3">
  <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i
      class="fas fa-plus"></i></a>
</div>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th>有料サービス名</th>
      <th>料金</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
    </tr>
  </thead>
  <tbody>
    {{ Form::open(['url' => 'admin/services', 'method'=>'psot']) }}
    @csrf
    <tr>
      <td>{{App\Models\Service::all()->count()+1}}</td>
      <td>{{Carbon\Carbon::now()}}</td>
      <td>{{ Form::text('item', old('item'), ['class' => 'form-control']) }}</td>
      <td>{{ Form::number('price', old('price'), ['class' => 'form-control']) }}</td>
      <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control','rows'=>"2"]) }}</td>
      <td>{{ Form::submit('登録', ['class' => 'btn btn-primary']) }}</td>
    </tr>
    {{ Form::close() }}
  </tbody>
</table>
@endsection