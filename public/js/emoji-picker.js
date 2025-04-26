// Simple emoji picker using Unicode emojis
const emojiPickerBtn = document.getElementById('emoji-picker-btn');
const emojiPickerMenu = document.getElementById('emoji-picker-menu');
const chatInput = document.querySelector('input[name="message"]');

const emojis = ['😀','😂','😍','😎','😭','😡','👍','🙏','🎉','🔥','❤️','💡','😅','😇','😜','😏','😬','🤔','🤗','😴','🤩'];

if (emojiPickerBtn && emojiPickerMenu) {
    emojiPickerBtn.addEventListener('click', function() {
        emojiPickerMenu.classList.toggle('hidden');
    });
    emojis.forEach(e => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'text-2xl p-1 hover:bg-gray-200 rounded';
        btn.textContent = e;
        btn.onclick = function() {
            chatInput.value += e;
            emojiPickerMenu.classList.add('hidden');
            chatInput.dispatchEvent(new Event('input'));
            chatInput.focus();
        };
        emojiPickerMenu.appendChild(btn);
    });
    document.addEventListener('click', function(e) {
        if (!emojiPickerMenu.contains(e.target) && e.target !== emojiPickerBtn) {
            emojiPickerMenu.classList.add('hidden');
        }
    });
}
