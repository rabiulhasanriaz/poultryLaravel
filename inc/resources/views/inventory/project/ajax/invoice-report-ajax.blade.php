<div class="load-details">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Sold Qty</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        @php($sl=0)
        @php($balance=0)
        @php($total = 0)
        <tbody>
            @foreach ($detail_ajax as $detail)
            <tr>
                  <td>{{ ++$sl }}</td>
                  <td>
                      @if ($detail->tran_type == 1)
                      {{ $detail->getProductWarranty->pro_name }}<br>
                      @if ($detail->getProductWarranty->pro_warranty != 0)
                          {{ $detail->getProductWarranty->pro_warranty }} Days
                      @endif
                      ({{ \Illuminate\Support\Str::limit($detail->getProductWarranty->pro_description, 40) }})
                      @endif
                  </td>
                  @if ($detail->tran_type == 1)
                  <td class="text-right">{{ $detail->tran_desc }}</td> 
                  @elseif($detail->tran_type == 10)
                  <td class="text-right">{{ $detail->tran_desc }}</td>  
                  @elseif($detail->tran_type == 11)
                  <td class="text-right">{{ $detail->tran_desc }}</td>
                  @endif

                  @if ($detail->tran_type == 1)
                  <td class="text-right">{{ $detail->qty }}</td>
                  <td class="text-right">{{ number_format($detail->unit_price,2) }}</td>
                  @elseif($detail->tran_type == 10)
                  <td class="text-right">{{ $detail->qty }}</td>
                  <td class="text-right">{{ number_format($detail->unit_price,2) }}</td>
                  @elseif($detail->tran_type == 11)
                  <td class="text-right"></td>
                  <td class="text-right"></td>  
                  @endif                         

                  @if ($detail->tran_type == 1)
                  <td class="text-right">{{ number_format($detail->debit,2) }}</td> 
                  @elseif($detail->tran_type == 10)
                  <td class="text-right">{{ number_format($detail->debit,2) }}</td>  
                  @elseif($detail->tran_type == 11)
                  <td class="text-right">{{ number_format($detail->debit,2) }}</td>
                  @endif
                  
              </tr>
              @php($total = $total + $detail->debit)
            @endforeach
        </tbody>
        <tfoot>
          @if ($discount_amount > 0)
            <tr>
                <td colspan="5" class="text-right">Discount:</td>
                <td class="text-right">{{ $discount_amount }}</td>
            </tr>
            @endif

            @php($balance = $total - $discount_amount)
            <tr>
                <td colspan="5" class="text-right">Total:</td>
                <td class="text-right">{{ number_format($balance,2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>