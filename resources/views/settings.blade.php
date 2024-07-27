@extends('layouts.app')

@section('content')
    <div class="container">
        @include('includes.messages')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white" style="box-shadow: none; border-radius: 0;">
                    <div class="card-body">
                        <form action="{{ route('saveSettings') }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if(auth()->user()->auto_bid == null)
                                <div class="form-group">
                                    <label for="enable">
                                        Do you want to enable AutoBid ? <br>
                                        <input type="checkbox" id="enable" name="enable_disable"> Yes
                                    </label>
                                </div>
                            @else
                                Do you want to disable AutoBid ?
                                <hr>
                                <div class="form-group">
                                    <label for="disable">
                                        <input type="checkbox" id="disable" name="enable_disable"> Yes
                                    </label>
                                </div>
                            @endif
                            <div class="form-group autoBidField">
                                <label for="auto_bid">Amount</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="auto_bid"
                                        name="auto_bid"
                                {{ auth()->user()->auto_bid == null ? 'disabled' : '' }}"
                                value="{{ auth()->user()->auto_bid }}">
                                <hr>
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const enable = document.querySelector('#enable');
        const disable = document.querySelector('#disable');
        const amountField = document.querySelector('#auto_bid');

        if (amountField.value === null || amountField.value === '' || typeof amountField === 'undefined') {
            amountField.disabled = true;
        }

        if (enable !== null && typeof enable !== 'undefined') {
            enable.addEventListener('click', () => {
                if (amountField.disabled === true) {
                    amountField.disabled = false;
                } else {
                    amountField.disabled = true;
                }
            });
        }

        let oldVal = amountField.value;

        if (disable !== null && typeof disable !== 'undefined') {
            disable.addEventListener('click', () => {
                if (amountField.disabled === true) {
                    amountField.disabled = false;
                    amountField.value = oldVal;
                } else {
                    amountField.disabled = true;
                    amountField.value = null;
                }
            });
        }
    </script>
@endsection
