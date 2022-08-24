@extends('template.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $user->name }} Wallet <i class="fas fa-wallet    "></i> </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Wallet</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row">
        <div align="center">
            <small>Amount in Wallet <i class="fas fa-coins    "></i></small>
            <h2 id="walletBalance">₦ {{$userWallet->amount}}</h2>
            <hr>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-wallet-credit"
                title="Add money to your wallet">Credit Wallet <i class="fa fa-plus" aria-hidden="true"></i> </button>

            {{-- Credit Wallet Modal --}}
            <div class="modal fade" id="modal-wallet-credit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Credit Your Wallet <i class="fas fa-coins    "></i></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="paymentForm">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        {{-- Email --}}
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="email-address" name="email" placeholder="Email" value="{{$user->email}}" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{-- Amount --}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₦</span>
                                            </div>
                                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" onclick="payWithPaystack()" >Pay</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            {{-- Credit Wallet END --}}


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);

        function payWithPaystack(e) {
            e.preventDefault();
            let handler = PaystackPop.setup({
                key: 'pk_test_b3e254392ba5d8f8382e46733a0d438990b10969', // Replace with your public key
                email: document.getElementById("email-address").value,
                amount: document.getElementById("amount").value * 100,
                ref: 'InvestmentSite_'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                label: "Investment Site",
                onClose: function(){
                    alert('Window closed.');
                },
                callback: function(response){
                    $.ajax({
                        url: 'verify-payment/'+ response.reference,
                        method: 'get',
                        success: function (response) {
                            // the transaction status is in response.data.status
                            alert(response.data.amount / 100 + ' naira was credited to your wallet');
                            // console.log(response);
                            $('#modal-wallet-credit').hide();
                            window.location.reload()//reloads page
                        }
                    });
                }
            });

            handler.openIframe();
        }
    </script>

@endpush
