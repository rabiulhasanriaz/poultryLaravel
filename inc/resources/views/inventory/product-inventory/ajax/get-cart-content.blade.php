@php($total = 0)
@php($sl = 0)
@foreach($cart_content as $content)

    <tr>
        <td>{{ ++$sl }}</td>
        <td>
            @if ($content->deal_type == 5)
                Service Charge
            @else
            {{ $content->pro_warranty->pro_description }}, {{ $content->type_name }}
            <br>
            <b>{{ implode(', ', explode(',',$content->slno)) }}</b>
            @endif
            
        </td>
        {{-- <input type="hidden" name="test" value="0"> --}}
        <td align="center">
            @if ($content->qty < 10)
              0{{ $content->qty }}
            @else
            {{ $content->qty }}
            @endif
        </td>
        <td class="text-right">{{ number_format($content->unit_price, 2) }}</td>
        @php($amount = $content->unit_price * $content->qty)
        <td class="text-right temp_cart">{{ number_format($amount,2) }}</td>
        <td class="text-center">
            <a href="javascript:void(0);" onclick="remove_cart({{ $content->pro_id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-minus"></i>
            </a>
        </td>
    </tr>
    @php($total += $amount)
@endforeach
<tr>
    <td colspan="4" class="text-right">Discount:</td>
    <td>
        <input type="number" onkeyup="total_sell_amount()" placeholder="Discount" name="discount" class="form-control text-right temp_cart_discount" style="width: 140px; float:right;">
    </td>
    <td></td>
</tr>
<tr>
    <td colspan="4" class="text-right">Delivery Charges:</td>
    <td>
        <input type="number" onkeyup="total_sell_amount()" placeholder="Delivery Charges" name="delivery" class="form-control text-right temp_cart_delivery" style="width: 140px; float:right;">
    </td>
    <td></td>
</tr>



{{-- <tr>
    <td colspan="3" class="text-right">Total Amount:</td>
    <td>
        <input type="number" class="form-control text-right" value="{{ $total }}" style="width: 140px; float:right;" disabled>
    </td>
    <td></td>
</tr> --}}

<script type="text/javascript">
// document.getElementById('fee').value = '0';
</script>
<style>
    .some-class {
      float: left;
      clear: none;
    }
    
    label {
      float: left;
      clear: none;
      display: block;
      padding: 0px 1em 0px 8px;
    }
    
    input[type=radio],
    input.radio {
      float: left;
      clear: none;
      margin: 2px 0 0 2px;
    }
</style>