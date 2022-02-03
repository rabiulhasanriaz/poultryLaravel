<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $product->pro_name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="box">
        <div class="box-body">
                <div class="col-sm-offset-1 col-sm-10">
                    <div id="all-added-warrenty-product-id">
                        <div class="col-sm-12" style="margin-top: 5px;">
                            <ul class="list-group">
                                <li class="list-group-item"> 
                                    <input type="text" class="form-control" class="pur_warrenty_pro_sl_no_s" onchange="check_sl_no(this.value, '{{ $product->id }}')" id="pur_warrenty_pro_sl_no" autocomplete="off">
                                </li>
                            </ul>
                                <ul class="list-group show-added-list list-inline">
                                    @if(!empty($product_sl_no)) 
                                        @foreach ($product_sl_no as $sl_no)
                                            <li class="list-group-item" style="margin-top: 5px;">{{ $loop->iteration }} | {{ $sl_no }} | 
                                            <a href="javascript:void(0);" class="btn btn-info btn-xs" onclick="remove_product_sl('{{ $product->id }}', '{{ $sl_no }}')"><span class="fas fa-trash" style="font-size: 20px; color: red;"></span></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
