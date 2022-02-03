<div class="load-details">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Warranty</th>
                <th>Short Qty</th>
                <th>Total Qty</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        @php($sl=0)
        @php($balance=0)
        @php($total=0)
        <tbody>
            @foreach ($detail_buy as $buy)
            <tr>
                <td>{{ ++$sl }}</td>
                <td>
                    {{ $buy->getProductWarranty->pro_name }}
                    
                    ({{ \Illuminate\Support\Str::limit($buy->getProductWarranty->pro_description, 40) }})
                </td>
                <td>
                    @if ($buy->getProductWarranty->pro_warranty == 0)
                        No Warranty
                    @else
                        {{ $buy->getProductWarranty->pro_warranty }} Days
                    @endif
                </td>
                <td class="text-right">{{ $buy->short_qty }}</td>
                <td class="text-right">{{ $buy->total_qty }}</td>
                <td class="text-right">{{ number_format($buy->unit_price,2) }}</td>
                <td class="text-right">{{ number_format($buy->debit,2) }}</td>
            </tr>
            @php($total += $buy->debit)
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">Total:</td>
                <td class="text-right">{{ number_format($total,2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>