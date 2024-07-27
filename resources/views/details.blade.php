@extends('layouts.app')

@section('content')
    <div class="container">
        @include('includes.messages')
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="cover__image">
                            <img src="{{ asset($item->thumbnail) }}" alt="">

                            <div class="cover__profile">
                                <img src="{{ asset($item->thumbnail) }}" alt="">
                            </div>

                            <div class="cover__desc">
                                <h5 class="card-title item-title">{{ $item->name }}</h5>
                                <h4>{{ $item->description }}</h4>
                                <div class="dates d-flex justify-content-end">
                                    Start - {{ date('d/m/Y H:i', strtotime($item->created_at)) }} <br>
                                    Ends - {{ date('d/m/Y H:i', strtotime($item->expires_at)) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-white pt-4 pl-4 pr-4 pb-4" style="margin-top: 150px">
            <div class="col-lg-12">
                @if(!lastBidder($item))
                    <div class="form-wrapper">
                        <form id="bidForm" action="{{ route('submitBid', $item->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="bid">
                                    <b class="d-block mb-0">Enter your bid amount</b>
                                    <small class="d-block text-muted mt-0 mb-3">Minimal bid amount is {{ $item->minimal_bid }}</small>
                                    <input type="number" class="form-control" id="bid" name="bid">
                                </label>
                            </div>
                        </form>
                        <form id="autoBidForm" action="{{ route('autobid', $item->id) }}" method="POST">
                            @csrf
                        </form>
                        <div class="d-flex mb-4">
                            <button class="btn btn-primary btn-smaller mr-2" onclick="document.querySelector('#bidForm').submit()">Submit Bid</button>
                            <button class="btn btn-primary btn-smaller" onclick="document.querySelector('#autoBidForm').submit()">{{ $item->autoBid()->where('user_id', auth()->user()->id)->count() > 0 ? 'Disable AutoBid' : 'Enable AutoBid' }}</button>
                        </div>
                    </div>
                @else
                    <p class="text-danger">
                        Cannot bid at the moment,
                        You already are the last bidder !
                    </p>
                @endif

                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                    <th>ID</th>
                    <th>Bidder Name</th>
                    <th>Bid Amount</th>
                    <th>Date/Time</th>
                    </thead>
                    <tbody>
                    @forelse($bids as $counter => $bid)
                        <tr>
                            <td>{{ ++$counter }}</td>
                            <td>{{ $bid->user->name }}</td>
                            <td>{{ $bid->bid_amount }}</td>
                            <td>{{ $bid->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4"><b>No bids submitted for this item</b></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>


@endsection
