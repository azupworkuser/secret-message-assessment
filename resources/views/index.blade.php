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
            <div class="col-12">
                <button class="btn btn-primary submit-form" type="button">Submit form</button>
            </div>
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

    $('button.submit-form').click(function() {
        window.Store.setPrivateKey($('input[name="private_key"]').val());
        $('form.registration').submit();
    });
</script>
@endpush