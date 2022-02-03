<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('company.index') }}" class="brand-link" style="background: white;">
      <img src="{{ asset('assets/logo_text.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3" style="height: 33px; width: 210px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="
          @if(Auth::user()->logo == '')
            {{ asset('/assets/image/default.png') }}
            @else
                {{ asset('/assets/image/')}}/{{ Auth::user()->logo }}
            @endif" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
    
    <a class="btn btn-info d-block buy-sell-button" href="{{ route('inventory.product-inventory.sale.sell-product') }}" style="margin-bottom:3px;">Sell</a>
    <a class="btn btn-danger d-block buy-sell-button" href="{{ route('inventory.product-inventory.purchase.add-product') }}">Buy</a>
    

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('company.index') }}" class="nav-link @yield('company_dashboard')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          

          <li class="nav-item @yield('user')">
            <a href="#" class="nav-link @yield('user_class')">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('company.user.create') }}" class="nav-link @yield('user_register')">
                  <i class="nav-icon fas fa-registered"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('company.user.list') }}" class="nav-link @yield('user_list')">
                  <i class="nav-icon fas fa-list"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          
          {{-- <li class="nav-item @yield('customer')">
            <a href="#" class="nav-link @yield('customer_class')">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Customer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('company.customer.create') }}" class="nav-link @yield('customer_register')">
                  <i class="nav-icon fas fa-registered"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('company.customer.customer-list') }}" class="nav-link @yield('customer_list')">
                  <i class="nav-icon fas fa-list"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item @yield('inventory')">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" >
              <li class="nav-item @yield('product_class')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Product
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item @yield('product_group_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Product Group
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.group.add-group') }}" class="nav-link @yield('add_group')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Group</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.group.group-list') }}" class="nav-link @yield('list_group')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Group List</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item @yield('product_type_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Product Type
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.type.add-type') }}" class="nav-link @yield('add_type_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Type</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.type.type-list') }}" class="nav-link @yield('list_type_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Type List</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item @yield('product_add_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Product
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.add-product') }}" class="nav-link @yield('add_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Product</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.product.list-product') }}" class="nav-link @yield('list_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Product List</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>

            {{-- Supplier --}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('supplier')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Supplier
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item @yield('supplier_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Supplier
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.sup.sup-add') }}" class="nav-link @yield('supplier_add_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Supplier</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.sup.sup-list') }}" class="nav-link @yield('supplier_list_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Supplier List</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item @yield('supplier_accounts_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Supplier Accounts
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.accounts.deposit-withdraw') }}" class="nav-link @yield('deposit_withdraw_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Deposit/Withdraw</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.accounts.supplier-payment') }}" class="nav-link @yield('payment_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Payment</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.accounts.payment-collection') }}" class="nav-link @yield('payment_collection')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Payment Collection</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.supplier.accounts.account-statements') }}" class="nav-link @yield('account_statements')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Account Statements</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  
                </ul>
              </li>
            </ul>
            {{-- End Supplier --}}
            {{--Customer--}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('customer_class')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Customer
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item @yield('customer_add_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Customer
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.cus.add-customer') }}" class="nav-link @yield('add_customer')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Customer</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.cus.list-customer') }}" class="nav-link @yield('list_customer')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Customer List</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item @yield('customer_account_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Customer Accounts
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.account.deposit-withdraw') }}" class="nav-link @yield('diposit-withdraw')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Deposit/Withdraw</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.account.payment') }}" class="nav-link @yield('payment_account')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Payment Collection</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.account.payment-refund') }}" class="nav-link @yield('payment_refund')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Payment Refund</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.customer.account.account-statement') }}" class="nav-link @yield('list_account')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Account Statements</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  
                </ul>
              </li>
            </ul>
            {{--Customer End--}}
            {{--Project--}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('projects_class')">
                <a href="#" class="nav-link ">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>
                    Projects
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview pl-3">
                  <li class="nav-item">
                    <a href="{{ route('inventory.project.add-project') }}" class="nav-link @yield('project_add')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Add Projects</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('inventory.project.project-list') }}" class="nav-link @yield('project_list')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Projects List</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="" class="nav-link @yield('customer_list')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Combined Reports</p>
                    </a>
                  </li> --}}
                </ul>
              </li>
              </ul>
            {{--End Project--}}
            {{-- Product Inventory --}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('product_inventory_class')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Product Inventory
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item @yield('purchase_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Purchase Product
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.product-inventory.purchase.add-product') }}" class="nav-link @yield('add_product_class')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Product</p>
                        </a>
                      </li>
                      
                    </ul>
                  </li>
                  <li class="nav-item pl-3">
                    <a href="{{ route('inventory.product-inventory.sale.sell-product') }}" class="nav-link @yield('sell_product_class')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Sell Product</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            {{-- End Product Inventory --}}
            {{--Account--}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('accounts')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Accounts
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview pl-3">
                  <li class="nav-item @yield('bank_class')">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Bank
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="{{ route('inventory.accounts.bank.add-bank') }}" class="nav-link @yield('add_bank')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add Bank</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.accounts.bank.list-bank') }}" class="nav-link @yield('list_bank')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Bank List</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inventory.accounts.bank.diposit-withdraw') }}" class="nav-link @yield('deposit_withdraw')">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Diposit/Withdraw</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Expense
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Expense Categories</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Expenses</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Ledger
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Cash</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Ledger Categories</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Ledger</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Voucher
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Create Contra</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Contra List</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Expenses Entry</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>General Ledger</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Account Statement</p>
                    </a>
                  </li>
                </ul>
                
              </li>
              
            </ul>
            {{--End Account--}}
            {{--Reports--}}
            <ul class="nav nav-treeview">
            <li class="nav-item @yield('reports_class')">
              <a href="#" class="nav-link ">
                <i class="fas fa-circle nav-icon"></i>
                <p>
                  Reports
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview pl-3">
                <li class="nav-item">
                  <a href="{{ route('inventory.reports.sale.sell-reports') }}" class="nav-link @yield('sell_report')">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Sell Reports</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('inventory.reports.buy.buy-reports') }}" class="nav-link @yield('buy_reports')">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Buy Reports</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="" class="nav-link @yield('customer_list')">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Combined Reports</p>
                  </a>
                </li> --}}
              </ul>
            </li>
            </ul>
            {{--End REports--}}
            {{--Damage/Crack--}}
            <ul class="nav nav-treeview">
            <li class="nav-item @yield('damage_class')">
              <a href="#" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                <p>
                  Damage/Crack
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview pl-3">
                <li class="nav-item">
                  <a href="{{ route('inventory.damage.damage-add') }}" class="nav-link @yield('damage_add')">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('inventory.damage.damage-list') }}" class="nav-link @yield('damage_list')">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>List</p>
                  </a>
                </li>
              </ul>
            </li>
            </ul>
            {{--End Damage/Crack--}}
            {{--Return--}}
            <ul class="nav nav-treeview">
              <li class="nav-item @yield('customer')">
                <a href="#" class="nav-link @yield('customer_class')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Return
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="" class="nav-link @yield('customer_register')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Sell Return</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link @yield('customer_list')">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Buy Return</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            {{--End Return--}}
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  
  