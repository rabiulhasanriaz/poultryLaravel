<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Auth\LoginController@login')->middleware('guest');
Route::post('login-process','Auth\LoginController@login_process')->name('login-process');
Route::post('logout','Auth\LoginController@logout')->name('logout');

// Route::get('/','Auth\LoginController@login');
// Route::post('process-login','Auth\LoginController@loginProcess')->name('process-login');
Route::group(['prefix' => 'Root' , 'as' => 'root.' , 'namespace' => 'Root' , 'middleware' => 'RootAccess'],function(){
    Route::get('index','HomeController@index')->name('index');
    Route::group(['prefix' => 'company' , 'as' => 'company.'],function(){
        Route::get('company','CompanyController@create')->name('create');
        Route::post('store','CompanyController@store')->name('store');
        Route::get('list','CompanyController@list')->name('list');
        Route::get('company-update-ajax','CompanyController@companyUpdateAjax')->name('company-update-ajax');
        Route::post('company-update/{id}','CompanyController@update')->name('company-update');
        Route::get('status-update/{id}','CompanyController@statusUpdate')->name('status-update');
        Route::get('permission','CompanyController@permission')->name('permission');
    });
});

Route::group(['prefix' => 'company' , 'as' => 'company.' , 'namespace' => 'Company' , 'middleware' => 'CompanyAccess'],function(){
    Route::get('index','HomeController@index')->name('index');
    //User
    Route::group(['prefix' => 'user' , 'as' => 'user.'],function(){
        Route::get('create','UserController@create')->name('create');
        Route::post('user-submit','UserController@store')->name('user-submit');
        Route::get('list','UserController@userList')->name('list');
        Route::get('user-update-ajax','UserController@userUpdateAjax')->name('user-update-ajax');
        Route::post('user-update/{id}','UserController@userUpdate')->name('user-update');
    });
    //User End
    //Company
    Route::group(['prefix' => 'customer' , 'as' => 'customer.'],function(){
        Route::get('create','CustomerController@createCustomer')->name('create');
        Route::post('submit-customer','CustomerController@store')->name('submit-customer');
        Route::get('customer-list','CustomerController@customerList')->name('customer-list');
        Route::get('customer-update-ajax','CustomerController@customerUpdateAjax')->name('customer-update-ajax');
        Route::post('customer-update/{id}','CustomerController@customerUpdate')->name('customer-update');
    });
    //End Company
});

 //Inventory
 Route::group(['prefix' => 'inventory' , 'as' => 'inventory.' , 'namespace' => 'Inventory'],function(){
    //Product
    Route::group(['prefix' => 'product' , 'as' => 'product.'],function(){
        Route::group(['prefix' => 'group' , 'as' => 'group.'],function(){
            Route::get('add-group','ProductController@groupAdd')->name('add-group');
            Route::post('group-store','ProductController@groupStore')->name('group-store');
            Route::get('group-list','ProductController@groupList')->name('group-list');
            Route::get('group-ajax','ProductController@groupAjax')->name('group-ajax');
            Route::post('group-update/{id}','ProductController@groupUpdate')->name('group-update');
        });
        Route::group(['prefix' => 'type' , 'as' => 'type.'],function(){
            Route::get('add-type','ProductController@addType')->name('add-type');
            Route::post('store-type','ProductController@typeStore')->name('store-type');
            Route::get('type-list','ProductController@typeList')->name('type-list');
            Route::get('type-ajax','ProductController@typeAjax')->name('type-ajax');
            Route::post('type-update/{id}','ProductController@typeUpdate')->name('type-update');
        });
        Route::get('add-product','ProductController@addProduct')->name('add-product');
        Route::get('type-ajax','ProductController@show_pro_type_by_ajax')->name('type-ajax');
        Route::post('product-store','ProductController@productDetailSubmit')->name('product-store');
        Route::get('list-product','ProductController@listProduct')->name('list-product');
    });
    //End Product
    //Supplier
    Route::group(['prefix' => 'supplier' , 'as' => 'supplier.'],function(){
        Route::group(['prefix' => 'sup' , 'as' => 'sup.'],function(){
            Route::get('sup-add','SupplierController@addSupplier')->name('sup-add');
            Route::post('sup-store','SupplierController@supplierStore')->name('sup-store');
            Route::get('sup-list','SupplierController@supplierList')->name('sup-list');
        });
        Route::group(['prefix' => 'accounts' , 'as' => 'accounts.'],function(){
            Route::get('deposit-withdraw','SupplierController@depositWithdraw')->name('deposit-withdraw');
            Route::get('supplier-balance-ajax','SupplierController@supplierBalanceAjax')->name('supplier-balance-ajax');
            Route::post('deposit-withdraw-store','SupplierController@depositWithdrawStore')->name('deposit-withdraw-store');
            Route::get('supplier-payment','SupplierController@supplierPayment')->name('supplier-payment');
            Route::get('ajax-bank-balance','SupplierController@ajaxLoadBankBalance')->name('ajax-bank-balance');
            Route::post('supplier-payment-store','SupplierController@supplierPaymentStore')->name('supplier-payment-store');
            Route::get('payment-collection','SupplierController@supplierPaymentCollection')->name('payment-collection');
            Route::post('payment-collection-store','SupplierController@paymentCollectionStore')->name('payment-collection-store');
            Route::get('account-statements','SupplierController@accountStatements')->name('account-statements');
        });
    });
    //End Supplier

    //Customer
    Route::group(['prefix' => 'customer' , 'as' => 'customer.'],function(){
        Route::group(['prefix' => 'cus' , 'as' => 'cus.'],function(){
            Route::get('add-costomer','CustomerController@addCustomer')->name('add-customer');
            Route::post('customer-store','CustomerController@customerStore')->name('customer-store');
            Route::get('list-costomer','CustomerController@listCustomer')->name('list-customer');
        });
        // customar accounts
        Route::group(['prefix' => 'account' , 'as' => 'account.'],function(){
            Route::get('account-statement','CustomerController@accountstatement')->name('account-statement');
            Route::get('deposit-withdraw','CustomerController@depositwithdraw')->name('deposit-withdraw');
            Route::get('customer-balance-ajax','CustomerController@ajaxLoadCustomerBalance')->name('customer-balance-ajax');
            Route::post('deposit-withdraw-store','CustomerController@depositwithdrawStore')->name('deposit-withdraw-store');
            Route::get('payment','CustomerController@paymentcollection')->name('payment');
            Route::get('project-ajax-customer','CustomerController@show_project_ajax')->name('project-ajax-customer');
            Route::get('bank-balance-ajax','CustomerController@ajaxLoadBankBalance')->name('bank-balance-ajax');
            Route::post('payment-store','CustomerController@paymentcollectionStore')->name('payment-store');
            Route::get('payment-refund','CustomerController@paymentrefund')->name('payment-refund');
            Route::post('payment-refund-store','CustomerController@paymentRefundStore')->name('payment-refund-store');
        });
    });
    //End Customer
    //Project
    Route::group(['prefix' => 'project' , 'as' => 'project.'],function(){
        Route::get('add-project','ProjectController@projectAdd')->name('add-project');
        Route::post('project-store','ProjectController@projectStore')->name('project-store');
        Route::get('project-list','ProjectController@projectList')->name('project-list');
        Route::get('project-details/{id}','ProjectController@projectDetails')->name('project-details');
        Route::get('project-invoice/{id}','ProjectController@projectInvoice')->name('project-invoice');
        Route::get('invoice-ajax','ProjectController@invoiceReportAjax')->name('invoice-ajax');
    });
    //End Project

    //Product Inventory
    Route::group(['prefix' => 'product-inventory' , 'as' => 'product-inventory.'],function(){
        Route::group(['prefix' => 'purchase' , 'as' => 'purchase.'],function(){
            Route::get('add-product','ProductBuyController@addProduct')->name('add-product');
            Route::get('add-to-cart','ProductBuyController@addToCart')->name('add-to-cart');
            Route::get('get-cart-content','ProductBuyController@getCartContent')->name('get-cart-content');
            Route::get('update-cart','ProductBuyController@updatecart')->name('update-cart');
            Route::get('remove-cart','ProductBuyController@removecart')->name('remove-cart');
            Route::get('add-to-cart-warrenty-product','ProductBuyController@addToCartWarrentyProduct')->name('add-to-cart-warrenty-product');
            Route::get('add-warrenty-product-sl-no','ProductBuyController@addWarrentyProductSlNo')->name('add-warrenty-product-sl-no');
            Route::get('remove-warrenty-product-sl','ProductBuyController@removeWarrentyProductSlNo')->name('remove-warrenty-product-sl');
            Route::get('buy-temporary','ProductBuyController@invTemporaryBuy')->name('buy-temporary');
            Route::post('cart-submit','ProductBuyController@cartSubmit')->name('cart-submit');
        });
        Route::group(['prefix' => 'sale' , 'as' => 'sale.'],function(){
            Route::get('sell-product','ProductSellController@sellProduct')->name('sell-product');
            Route::get('type-submit-ajax','ProductSellController@show_pro_type_ajax')->name('type-submit-ajax');
            Route::get('project-ajax','ProductSellController@show_project_ajax')->name('project-ajax');
            Route::get('pro-search-ajax','ProductSellController@product_search_ajax')->name('pro-search-ajax');
            Route::get('add-to-cart','ProductSellController@addToCart')->name('add-to-cart');
            Route::get('sell-service-charge','ProductSellController@addServiceCharges')->name('sell-service-charge');
            Route::get('get-cart','ProductSellController@getCartContent')->name('get-cart');
            Route::get('update-cart','ProductSellController@updatecart')->name('update-cart');
            Route::get('remove-cart','ProductSellController@removecart')->name('remove-cart');
            Route::get('add-to-cart-warranty-product','ProductSellController@addToCartWarrentyProduct')->name('add-to-cart-warranty-product');
            Route::get('add-warranty-product-sl-no','ProductSellController@addWarrentyProductSlNo')->name('add-warranty-product-sl-no');
            Route::get('remove-warranty-product-sl','ProductSellController@removeWarrentyProductSlNo')->name('remove-warranty-product-sl');
            Route::get('sell-temp-invoice','ProductSellController@invTemporaryProduct')->name('sell-temp-invoice');
            Route::post('cart-submit','ProductSellController@cartSubmit')->name('cart-submit');
            Route::get('sell-print/{invoice}','ProductSellControler@sell_reports_pdf')->name('sell-print');
        });

    });
    //End Product Inventory

    //Accounts
    Route::group(['prefix' => 'accounts' , 'as' => 'accounts.'],function(){
        Route::group(['prefix' => 'bank' , 'as' => 'bank.'],function(){
            Route::get('add-bank','BankController@addbank')->name('add-bank');
            Route::post('add-bank-store','BankController@storeBank')->name('add-bank-store');
            Route::get('list-bank','BankController@listbank')->name('list-bank');
            Route::get('diposit-withdraw','BankController@dipositwithdraw')->name('diposit-withdraw');
            Route::post('deposit-withdraw-store','BankController@depostiWithdrawStore')->name('deposit-withdraw-store');
            Route::get('ajax-load-bank-balance','BankController@ajaxLoadBankBalance')->name('ajax-load-bank-balance');
        });

    });
    //End Accounts

    //Reports
    Route::group(['prefix' => 'reports' , 'as' => 'reports.'],function(){
        Route::group(['prefix' => 'sale' , 'as' => 'sale.'],function(){
            Route::get('sell-reports','ReportsController@sell_reports')->name('sell-reports');
            Route::get('sell-reports-ajax','ReportsController@sell_report_ajax')->name('sell-reports-ajax');
        });
        Route::group(['prefix' => 'buy' , 'as' => 'buy.'],function(){
            Route::get('buy-reports','ReportsController@buy_reports')->name('buy-reports');
            Route::get('buy-reports-ajax','ReportsController@buy_reports_ajax')->name('buy-reports-ajax');
        });
    });
    //End Reports

    //Damage
    Route::group(['prefix' => 'damage' , 'as' => 'damage.'],function(){
        Route::get('damage-add','DamageController@damage_add')->name('damage-add');
        Route::get('product-type-ajax','DamageController@show_pro_grp_by_ajax')->name('product-type-ajax');
        Route::get('product-name-ajax','DamageController@show_pro_name_ajax')->name('product-name-ajax');
        Route::post('damage-add-store','DamageController@damage_add_submit')->name('damage-add-store');
        Route::get('damage-list','DamageController@damage_list')->name('damage-list');
    });
    //End Damage
});
//End Inventory