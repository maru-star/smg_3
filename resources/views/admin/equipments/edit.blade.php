@extends('layouts.admin.app')

@section('content')
<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$eqipment->id) }}</li>
    </ol>
  </nav>
</div>
<h1 class="mt-3 mb-5">有料備品管理　編集</h1>
<div class="text-right mb-3">
  <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i
      class="fas fa-plus"></i></a>
</div>





{{ Form::model($eqipment, ['route' => ['admin.equipments.update', $eqipment->id], 'method' => 'put']) }}
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th>有料備品名</th>
      <th>料金</th>
      <th>数量</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ $eqipment->id }}</td>
      <td>{{ $eqipment->created_at }}</td>
      <td>{{ Form::text('item', $eqipment->item, ['class' => 'form-control']) }}</td>
      <td>{{ Form::text('price', $eqipment->price, ['class' => 'form-control']) }}</td>
      <td>{{ Form::number('stock', $eqipment->stock, ['class' => 'form-control']) }}</td>
      <td>{{ Form::text('remark', $eqipment->remark, ['class' => 'form-control']) }}</td>
      <td>
        {{ Form::submit('更新', ['class' => 'btn btn-primary']) }}
      </td>
    </tr>
  </tbody>
</table>
{{ Form::close() }}

@endsection