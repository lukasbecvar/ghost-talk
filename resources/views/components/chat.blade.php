<div class="chat-box">
    <div class="chat-title"><a href="/profile?name={{ $chat_username }}">{{ $chat_username }}</a></div>

    <div class="message-container" id="message-container"></div>

    <div class="message-input-container">
        <input type="text" class="message-input" placeholder="Type your message" id="message-input" onkeydown="handleEnterKey(event)">
        <button class="send-button" onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    function fetchMessages(chatId) {
        const messageContainer = document.getElementById('message-container');
        const isUserAtBottom = messageContainer.scrollHeight - messageContainer.scrollTop === messageContainer.clientHeight;

        fetch(`/chat/messages?chat=${chatId}`).then(response => response.json()).then(messages => {
            const shouldAutoScroll = isUserAtBottom;

            // clear previous messages
            messageContainer.innerHTML = '';

            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', message.sender === '{{ $username }}' ? 'outgoing' : 'incoming');

                const titleDiv = document.createElement('div');
                titleDiv.classList.add('title');

                const usernameSpan = document.createElement('span');
                usernameSpan.classList.add('username');
                usernameSpan.textContent = message.sender;

                const timestampSpan = document.createElement('span');
                timestampSpan.classList.add('timestamp');

                // parse timestamp and format it (assuming the timestamp is in ISO format)
                const timestampDate = new Date(message.created_at);
                const formattedTimestamp = `${timestampDate.getHours()}:${(timestampDate.getMinutes() < 10 ? '0' : '') + timestampDate.getMinutes()}`;

                timestampSpan.textContent = formattedTimestamp;

                titleDiv.appendChild(usernameSpan);
                titleDiv.appendChild(timestampSpan);

                const messageContent = document.createElement('div');
                messageContent.classList.add('message-content');
                    
                // replace URLs with anchor tags
                const messageText = message.message.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="link">$1</a>');
                messageContent.innerHTML = messageText;

                messageDiv.appendChild(titleDiv);
                messageDiv.appendChild(messageContent);

                messageContainer.appendChild(messageDiv);
            });

            // scroll down only if the user was at the bottom before fetching new messages
            if (shouldAutoScroll) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        });
    }

    fetchMessages({{ $chat_id }});

    // set interval to fetch messages every second
    setInterval(() => {
        fetchMessages({{ $chat_id }});
    }, 500);

    function sendMessage() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value;

        // assuming you have a function to send a message
        if (message.length > 2000) {
            // ahow a custom alert for maximal message length error
            showAlert('Maximal message length is 2000 characters');
        } else {
            sendNewMessage(message);
        }
    }

    function sendNewMessage(message) {
        const messageContainer = document.getElementById('message-container');

        if (!message.length < 1) {

            var messageInput = document.getElementById('message-input');
            var message = messageInput.value;

            // fetch API to send the message
            fetch(`/chat/send?chat={{ $chat_id }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                },
                body: JSON.stringify({
                    message: message,
                }),
            })
            .then(response => response.json())
            .then(data => {
                // refresh or update the UI with the new message
                fetchMessages({{ $chat_id }});
                // clear the input after sending
                messageInput.value = '';
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        }
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    function handleEnterKey(event) {
        if (event.keyCode === 13) {
            event.preventDefault(); 
            sendMessage(); 
        }
    }

    function showAlert(message) {
        const alertContainer = document.createElement('div');
        alertContainer.classList.add('custom-alert');

        const alertMessage = document.createElement('p');
        alertMessage.textContent = message;

        alertContainer.appendChild(alertMessage);

        document.body.appendChild(alertContainer);

        // remove the alert after a few seconds (adjust the timeout as needed)
        setTimeout(() => {
            document.body.removeChild(alertContainer);
        }, 3000);
    }
</script>
