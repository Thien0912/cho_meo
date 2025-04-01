@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chatbot</h1>
    <div id="chat-box" style="border:1px solid #ccc; height:300px; overflow:auto; padding:10px;">
        <!-- Tin nhắn sẽ hiển thị ở đây -->
    </div>
    <div class="mt-3">
        <input type="text" id="question" class="form-control" placeholder="Nhập câu hỏi...">
        <button id="send-btn" class="btn btn-primary mt-2">Gửi</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('send-btn').addEventListener('click', function() {
        let question = document.getElementById('question').value;
        if (!question) return;
        
        fetch("{{ url('/chat/ask') }}?question=" + encodeURIComponent(question))
            .then(response => response.json())
            .then(data => {
                let chatBox = document.getElementById('chat-box');
                chatBox.innerHTML += '<div><strong>Chatbot:</strong> ' + data.chat_response + '</div>';
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>
@endpush
