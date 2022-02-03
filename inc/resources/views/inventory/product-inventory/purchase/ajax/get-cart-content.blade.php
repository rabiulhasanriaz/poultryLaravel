@foreach($cart_content as $content)

    <tr>
        <td >
            {{ $content->pro_name }}, {{ $content->type_name }}
            <br>
            <b>{{ implode(', ', explode(',',$content->slno)) }}</b>
        </td>
        <td align="center">
            {{ $content->qty }}
        </td>
        
        <td class="text-center">{{ $content->exp_date }}</td>
        <td class="text-right">{{ number_format($content->unit_price, 2) }}</td>
        <td class="text-right temp_cart">{{ number_format(($content->unit_price * $content->qty), 2) }}</td>
        <td class="text-center">{{ number_format($content->short_qty, 2) }}</td>
        <td>{{ $content->short_remarks }}</td>
        <td class="text-center">
            <a href="javascript:void(0);" onclick="remove_cart({{ $content->pro_id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-minus"></i>
            </a>
        </td>
    </tr>
@endforeach