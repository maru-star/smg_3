@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

<h1>追加請求書　確認画面</h1>

{{ Form::model($request->reservation, ['route' => 'admin.bills.store']) }}
@csrf
{{ Form::hidden('reservation_id', $request->reservation, ['class' => 'form-control', 'readonly']) }}

<table class="table table-borderd">
  <thead>
    <tr>
      <th colspan='4'>結果</th>
    </tr>
    <tr>
      <th colspan="2">割引料金 <p>
          {{ Form::text('name', $request->discount_input, ['class' => 'form-control', 'readonly']) }}
        </p>
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
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_item]', $master_arrays[$i*4],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_cost]', $master_arrays[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_count]', $master_arrays[($i*4+2)],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_subtotal]', $master_arrays[($i*4+3)],['class'=>'form-control', 'readonly'] ) }}
      </td>
      @if ($request->billcategory==1)
      {{ Form::hidden('unit_type', 2 )}}
      @elseif ($request->billcategory==2)
      {{ Form::hidden('unit_type', 3 )}}
      elseif ($request->billcategory==3)
      {{ Form::hidden('unit_type', 4 )}} {{--その他--}}
      @endif
      </tr>
      @endfor
      @if ($request->discount_input)
      <tr>
        <td>
          {{ Form::text('discount_item', '割引料金',['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_input', $request->discount_input,['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_count', 1,['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_total', $request->discount_input,['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
      @endif
  </tbody>
</table>

<div>
  割引前： {{ Form::text('sub_total',$request->sub_total    ,['class'=>'form-control', 'readonly'] ) }}
  割引料金：{{ Form::text('discount_input',  $request->discount_input  ,['class'=>'form-control', 'readonly'] ) }}
  小計：{{ Form::text('after_dicsount',  $request->after_dicsount  ,['class'=>'form-control', 'readonly'] ) }}
  消費税：{{ Form::text('tax',   $request->tax ,['class'=>'form-control', 'readonly'] ) }}
  合計：{{ Form::text('total', $request->total   ,['class'=>'form-control', 'readonly'] ) }}

  {{-- {{ Form::text('discount_total',    ,['class'=>'form-control', 'readonly'] ) }} --}}

</div>




{{ Form::submit('更新', ['class' => 'btn btn-primary btn-block']) }}
{{ Form::close() }}















@endsection