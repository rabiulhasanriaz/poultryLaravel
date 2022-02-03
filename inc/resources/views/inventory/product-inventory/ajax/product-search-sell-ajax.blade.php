<table id="sell_product_list_table" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>SL</th>
        <th>Name</th>
        <th>Type</th>
        <th>A. Stock</th>
        <th>Price</th>
        <th style="width: 110px; text-align: center;">Sell</th>
    </tr>
    </thead>
    <tbody id="product_table_body">
@php($sl=0)
@foreach ($sell_product as $sell)
<tr>
    <td class="text-center">{{ ++$sl }}</td>
    <td>{{ $sell->pro_name }}</td>
    <td>{{ $sell->typeName->name }}</td>
    <td align="center">{{ $sell->available_qty }}</td>
    <td class="text-center"><input type="text" autocomplete="off" class="form-control" id="pro_price_{{ $sell->id }}" style="width: 100px;" value="{{ $sell->sell_price }}"></td>
    <td class="text-center">
        @if($sell->pro_warranty == 0)
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="text" autocomplete="off" class="form-control" style="width: 50px;" id="pro_qty_{{ $sell->id }}" placeholder="Qty">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-success btn-sm" onclick="addtocart('{{ $sell->id }}')">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        
        @else
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="text" autocomplete="off" class="form-control" style="width: 50px;" placeholder="N/A" disabled>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-success btn-sm" onclick="addWarrentyProduct('{{ $sell->id }}')">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        @endif
    </td>
</tr>
@endforeach

</tbody>
</table>


<script>
$('#sell_product_list_table').DataTable( {
pageLength : 5,
lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']]
} );
</script>