@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

<h1>追加請求書　確認画面</h1>

{{-- {{$request->billcategory}} --}}

<table class="table table-borderd">
  <thead>
    <tr>
      <th colspan='4'>結果</th>
    </tr>
    <tr>
      <th colspan="2">割引料金 <p>{{$request->discount_input}}</p>
      </th>
      <th colspan="2">割引率</th>
    </tr>
    <tr>
      <th>内容</th>
      <th>単価</th>
      <th>個数</th>
      <th>合計</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < $counter; $i++) <tr>
      <td>{{$master_arrays[$i*4]}}</td>
      <td>{{$master_arrays[($i*4)+1]}}</td>
      <td>{{$master_arrays[($i*4+2)]}}</td>
      <td>{{$master_arrays[($i*4+3)]}}</td>
      </tr>
      @endfor
  </tbody>
</table>

<div>
  割引前：<p>{{$request->sub_total}}</p>
  割引料金：<p>{{$request->discount_input}}</p>
  小計：<p>{{$request->after_dicsount}}</p>
  消費税：<p>{{$request->tax}}</p>
  合計：<p>{{$request->total}}</p>
</div>



















@endsection