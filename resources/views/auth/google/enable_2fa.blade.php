@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                Enable 2FA Authentication
            </div>
            <div class="card-body">
                <form action="{{ route('2fa.enable') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="one_time_password">One Time Password</label>
                        <input type="text" name="secret_2fa_key" class="form-control  id="one_time_password" 
                            @error('secret_2fa_key') is-invalid @enderror" readonly value="{{ $secret }}">
                            @error('secret_2fa_key')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>
                    <p>
                        Scan the QR code below using your phone's authenticator application.
                    </p>
                    <div class="mb-3">
                        {!! $qrImg !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Enable</button>
                </form>
            </div>  
        </div>
    </div>
</div>
@endsection