@php($pro_sl_no = explode(',',$content->slno))
@php($loop_iteration = 0)
@foreach ($pro_sl_no as $sl_no)
    @if($sl_no != '')
    
        @php($loop_iteration++)
        <li class="list-group-item">{{ $loop_iteration }} | {{ $sl_no }} | 
            <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="remove_product_sl('{{ $content->pro_id }}', '{{ $sl_no }}')"><span class="fas fa-trash" style="font-size: 20px; color: red;"></span></a>
        </li>
    @endif
@endforeach
