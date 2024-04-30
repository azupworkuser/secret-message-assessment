@extends('layouts.default')

@section('title','Chat Room')

@section('content')
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">
            Message Room
            <small> ({{ count($room->members) }} members)</small>
        </a>
        @if(count($room->members) == 1)
        <span data-url="{{ $room->url }}" style="cursor:pointer" class="room-link text-warning">
            Room Invitation Link
        </span>
        @endif
    </div>
</nav>
<div class="card" style="height: 75vh">
    <div class="card-body message-body" data-url="{{ route('message.get', ['room' => request()->route('room')]) }}" data-read-url="{{ route('message.read') }}">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @if(count($room->members) == 2)
    <div class="card-footer">
        <form class="d-flex messages" action="{{ route('message.post') }}" method="post">
            @csrf
            <input type="hidden" name="sender_id" />
            <input type="hidden" name="recipient_id" />
            <input type="hidden" name="room_id" />
            <input type="hidden" name="body" />
            <input type="hidden" name="recipient_decription_key" />
            <input type="hidden" name="sender_decription_key" />
            <input type="hidden" name="read_once" value="0" />
            <input type="hidden" name="expire_days" value="0" />
            <textarea class="form-control me-2" autofocus required placeholder="Enter your message here..."></textarea>
            <select class="form-select expire-dropdown w-25">
                <option value="1">Select Message Preference</option>
                <option value="2">Read Once</option>
                <option value="3">Expire in 10 Days</option>
                <option value="4">Expire in 30 Days</option>
            </select>
            <button class="btn btn-outline-success mx-2" type="submit">Send</button>
        </form>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script type="module">
    let user_id = "{{ session('user_id') }}";
    let room_url = "{{ session('room_url') }}";
    if (user_id) {
        window.Store.setUserId(user_id);
    }

    if (room_url) {
        window.Store.setRoomUrl(room_url);
    }

    $('span.room-link').click(function() {
        let text = $(this).data('url');
        navigator.clipboard.writeText(text);
        alert('Link copied to clipboard!');
    });

    var sender = window.Store.getSender();
    var receiver = window.Store.getReceiver();
    $('form.messages').submit(function(event) {
        event.preventDefault();
        refreshLogins();
        const encryptedMessage = window.Encryption.encryptWithAES($('.me-2').val());
        const encryptedSymmetricKey = window.Encryption.encryptWithRSA(encryptedMessage.key, receiver.identifier);
        const encryptedSenderSymmetricKey = window.Encryption.encryptWithRSA(encryptedMessage.key, sender.identifier);

        $('input[name="sender_id"]').val(sender.id);
        $('input[name="room_id"]').val(sender.room_id);
        $('input[name="recipient_id"]').val(receiver.id);
        $('input[name="body"]').val(encryptedMessage.message);
        $('input[name="recipient_decription_key"]').val(encryptedSymmetricKey);
        $('input[name="sender_decription_key"]').val(encryptedSenderSymmetricKey);
        if ($(this)[0].checkValidity()) {
            event.currentTarget.submit();
        }
    });

    $('select.expire-dropdown').change(function(event) {
        let val = parseInt(event.target.value);
        switch (val) {
            case 1:
                $('input[name="read_once"]').val(0);
                $('input[name="expire_days"]').val(0);
                break;
            case 2:
                $('input[name="read_once"]').val(1);
                $('input[name="expire_days"]').val(0);
                break;
            case 3:
                $('input[name="read_once"]').val(0);
                $('input[name="expire_days"]').val(10);
                break;
            case 4:
                $('input[name="read_once"]').val(0);
                $('input[name="expire_days"]').val(30);
                break;
        }
    });

    $('.me-2').on('keypress', function(event) {
        if (event.which === 13) {
            $('form.messages').submit();
        }
    });

    const generateChatData = (messages) => {
        refreshLogins();
        let html = '';
        messages.forEach(function(value) {
            let decription_key = null;
            let read_once = false;
            if (value.sender.id == sender.id) {
                html += `<div class="card bg-secondary bg-gradient text-light my-2 w-75 right-message">`;
                decription_key = value.sender_decription_key;
            } else {
                if (value.read_once) {
                    read_once = true;
                    html += `<div class="card my-2 w-50 left-message">`;
                } else {
                    html += `<div class="card my-2 w-75 left-message">`;
                }

                decription_key = value.recipient_decription_key;
            }

            let symKey = window.Encryption.decryptWithRSA(decription_key, window.Store.getPrivateKey());
            html += `<div class="card-body">`;
            if (read_once) {
                html += "Read Once (Openned)";
            } else {
                html += window.Encryption.decryptWithAES(value.body, symKey);
            }
            html += '<br><br><small class="opacity-75">';
            if (!read_once && value.read_once) {
                html += '(Read once) ';
            }
            html += window.Moment(value.created_at).format('hh:mm A');
            html += '</small></div></div>';
        });

        if (html == '') {
            html = `<div class="d-flex justify-content-center">
            No Message Found
            </div>`;
        }

        return html;
    }

    const loadChats = () => {
        fetch($('.message-body').data('url'))
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('API request failed');
                }
            })
            .then(data => {
                window.Store.setRoomMembers(data.members);
                $('.message-body').html(generateChatData(data.messages));
                performMarkAsRead();
            }).finally(() => {
                refreshLogins();
                if (sender.length == 0) {
                    window.location.replace("{{ route('home') }}");
                }
            });
    }

    const refreshLogins = () => {
        sender = window.Store.getSender();
        receiver = window.Store.getReceiver();
    }

    const performMarkAsRead = () => {
        let formData = new FormData();
        formData.append('room_id', sender.room_id);
        formData.append('login_id', sender.id);
        fetch($('.message-body').data('read-url'), {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('API request failed');
            }
        }).finally(() => {
            scrollToBottom();
        });
    }

    const scrollToBottom = () => {
        $('.message-body').scrollTop($('.message-body')[0].scrollHeight);
    }
    loadChats();
</script>
@endpush