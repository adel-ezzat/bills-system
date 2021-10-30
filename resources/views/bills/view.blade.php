@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg"
                 alt="" width="72" height="72">
            <h2><h2>Bills System</h2></h2>
        </div>

        <div class="row">
            <div class="col order-md-1">
                <h4 class="mb-3">All Bills</h4>
                <table id="table1" class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Total Bills</th>
                        <th scope="col">Total Items</th>
                        <th scope="col">Date</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tableItems">
                    @foreach($bills as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->client['client_name'] }}</td>
                            <td>{{ $bill->total }}</td>
                            <td>{{ $bill->items_count }}</td>
                            <td>{{ $bill->created_at }}</td>
                            <td>
                                <button type="button"
                                        onclick="window.location='{{ route('bill.items.view.id', $bill->id) }}'"
                                        class="btn btn-info">Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection



