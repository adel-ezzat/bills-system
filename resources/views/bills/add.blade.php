@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg"
                 alt="" width="72" height="72">
            <h2>Bills System</h2>
        </div>

        <div class="row">
            <div class="col order-md-1">
                <h4 class="mb-3">Add Bill</h4>

                <div class="row">
                    <div class="col mb-3">
                        <label>Client</label>
                        <select class="custom-select d-block w-100" id="client" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label>Safe</label>
                        <select class="custom-select d-block w-100" id="safe" required>
                            @foreach($safes as $safe)
                                <option value="{{ $safe->id }}">{{ $safe->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col mb-3">
                        <label>Items</label>
                        <select id="items-select" class="custom-select" multiple>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table id="table1" class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Cost Price</th>
                        <th scope="col">Sale Price</th>
                        <th scope="col">Total Price</th>
                    </tr>
                    </thead>
                    <tbody id="tableItems">
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0"></div>

                    <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">

                        <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                            <div class="col-7 text-right">
                                Total Amount
                            </div>
                            <div class="col-5">
                                <span id="bill-total" class="text-150 text-success-d3 opacity-2">--</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="button-placeholder">
                    <hr class="mb-4">
                    <button onclick="postBill()" class="btn btn-primary btn-lg btn-block">Add Bill</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        // validation
        function validate(items) {
            // check if user doesn't select a client
            if ($('#client').find(":selected").length == 0) {
                return alert('you should select the client!');
            }

            // check if user doesn't select a safe
            if ($('#safe').find(":selected").length == 0) {
                return alert('you should select the safe!');
            }
            // check if there is no selected items
            if (items.length == 0) {
                return alert('you should select at least one item!');
            }
        }

        // reset page after post and append bills button
        function pageReset() {
            // reset  selection
            $('option', $('#items-select')).each(function (element) {
                $(this).removeAttr('selected').prop('selected', false);
            });

            // reset tr items
            $("#tableItems").empty();

            // reset total
            $('#bill-total').html('--');

            // add button for old bills
            var oldBillsBtn = `<button id='old-bills' onclick="window.location='{{ route('bill.items.view') }}'" class="btn btn-warning btn-lg btn-block">Old Bills</button>`;
            if (!$("#old-bills").length) {
                $('#button-placeholder').append(oldBillsBtn);
            }
        }

        function getItemById(type, url, data) {
            $.ajax({
                type: type,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {data},
                success: function (res) {
                    $.each(res, function (index, value) {
                        var item_id = value.id;
                        var item_name = value.item_name;
                        var quantity = value.quantity;
                        var cost_price = value.cost_price;
                        var sale_price = value.sale_price;
                        var total_price = sale_price;

                        $element = `<tr class="item">
                                  <td id="${item_id}">${item_name}</td>
                                  <td><input stock="${quantity}" class="table_quantity" style="width:50px; text-align: center" type="number" value="1" min="1" max="${quantity}"></td>
                                  <td>${cost_price}</td>
                                  <td>${sale_price}</td>
                                  <td type="text">${total_price}</td>
                                 </tr>`;

                        // prevent add duplicated  items
                        var oldElement = $('#' + item_id).html();
                        if (oldElement !== item_name) {
                            $("#tableItems").append($element);
                            total();
                        }
                    });
                }
            });
        }

        // append selected items to table
        $("#items-select").on('change', function (e) {
            var values = $('#items-select').val()
            // prevent send request when there is no value
            if (typeof values !== 'undefined' && values.length > 0) {
                getItemById('POST', '{{ route('bill.items.id') }}', values);
            }
        });

        // table quantity input change event
        $(document).on('change', '.table_quantity', function (e) {
            let stock = $(this).attr("stock");
            let inputValue = $(this).val();
            let salePrice = $(this).closest('tr').find('td:eq(3)').html()
            let total_price = inputValue * salePrice;

            // check if stock smaller than the requested amount
            if (Number(stock) >= Number(inputValue)) {
                $(this).closest('tr').find('td:last').html(total_price);
            } else {
                // reset total
                $(this).closest('tr').find('td:last').html(salePrice);
                // reset input
                $(this).closest('tr').find('td:eq(1)').html('<input stock="${quantity}" class="table_quantity" style="width:50px; text-align: center" type="number" value="1">');
                alert('Sorry, we do not have enough “item” in stock to fulfil your order');
            }
            // re calculate total amount
            total();
        });

        // calculate total bill after table
        function total() {
            var sum = 0
            $('tr').find('td:last').each(function () {
                var total = Number($(this).text());
                sum = sum + total;
            });
            $('#bill-total').html(sum);
        }

        // post the bill data
        function postBill() {
            var getClient = $('#client').find(":selected").val();
            var getSafe = $('#safe').find(":selected").val();
            var getTotal = $('#bill-total').html();

            var itemObj = {
                'client': getClient,
                'safe': getSafe,
                'total': getTotal,
                items: []
            };

            // loop over table items to get data
            $('tr.item').each(function () {
                var itemId = $(this).find('td:first').attr("id"),
                    itemName = $(this).find('td:first').html(),
                    itemQuantity = $(this).find('td:eq(1) > input').val(),
                    itemSalePrice = $(this).find('td:eq(3)').html(),
                    itemTotal = $(this).find('td:last').html();

                itemObj.items.push({
                    'id': itemId,
                    'name': itemName,
                    'quantity': itemQuantity,
                    'salePrice': itemSalePrice,
                    'totalPrice': itemTotal
                });
            });

            validate(itemObj.items); // validation

            $.ajax({
                type: 'POST',
                url: '{{ route('bill.items.create') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: itemObj,
                success: function (res) {
                    alert(res);
                    pageReset();
                }
            });
        }
    </script>
@endsection
