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
            <h2>₦ 0.00</h2>
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

                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        {{-- Email --}}
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{-- Amount --}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₦</span>
                                            </div>
                                            <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
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
