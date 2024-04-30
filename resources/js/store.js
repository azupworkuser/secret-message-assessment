const setPrivateKey = (privateKey) => {
    localStorage.setItem('private_key', privateKey);
}

const getPrivateKey = () => {
    return localStorage.getItem('private_key');
}

const setUserId = (userId) => {
    localStorage.setItem('user_id', userId);
}

const getUserId = () => {
    return localStorage.getItem('user_id');
}

const setRoomMembers = (members) => {
    localStorage.setItem('room_members', JSON.stringify(members));
    let sender = members.filter(function (el) {
        return el.id == getUserId();
    });

    if (sender.length > 0) {
        setSender(sender[0]);
    }

    let recipient = members.filter(function (el) {
        return el.id != getUserId();
    });

    if (recipient.length > 0) {
        setReceiver(recipient[0]);
    }
}

const getRoomMembers = () => {
    return JSON.parse(localStorage.getItem('room_members'));
}

const setSender = (sender) => {
    localStorage.setItem('sender', JSON.stringify(sender));
}

const getSender = () => {
    return JSON.parse(localStorage.getItem('sender'));
}

const setReceiver = (receiver) => {
    localStorage.setItem('receiver', JSON.stringify(receiver));
}

const getReceiver = () => {
    return JSON.parse(localStorage.getItem('receiver'));
}

const setRoomUrl = (url) => {
    localStorage.setItem('room_url', url);
}

const getRoomUrl = () => {
    return localStorage.getItem('room_url');
}

const flush = () => {
    setPrivateKey(null);
    setUserId(null);
    setRoomMembers([]);
    setSender([]);
    setReceiver([]);
    setRoomUrl(null);
}

export {
    setPrivateKey,
    getPrivateKey,
    setUserId,
    getUserId,
    setRoomMembers,
    getRoomMembers,
    getSender,
    getReceiver,
    setRoomUrl,
    getRoomUrl,
    flush
};