@extends('layouts.default')

@section('title','Registration')

@section('content')
<div class="card">
    <div class="card-body">
        <form class="row g-3 needs-validation registration" method="post" action="{{ route('register') }}" novalidate>
            @csrf
            <input type="hidden" name="identifier" />
            <input type="hidden" name="private_key" />
            <x-register-fields />
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    let privateKey = window.Store.getPrivateKey();
    let hasSession = !(privateKey == 'null' || privateKey == null || privateKey == '' || !privateKey);
    if (hasSession == false || (hasSession == true && confirm('You already have active session, do you want to open a new session?'))) {
        let keys = window.Encryption.generateRSAKeyPair();
        $('input[name="identifier"]').val(keys.publicKey);
        $('input[name="private_key"]').val(keys.privateKey);
        window.Store.flush();
    } else {
        window.location.replace(window.Store.getRoomUrl());
    }

    $('form.registration').submit(function(event) {
        event.preventDefault();
        if ($(this)[0].checkValidity()) {
            window.Store.setPrivateKey($('input[name="private_key"]').val());
            event.currentTarget.submit();
        }
    });
</script>
@endpush