<x-mail::message>
<x-slot:header>
<x-mail::header :url="config('app.url')">
Hafalan Santri MAKN Ende
</x-mail::header>
</x-slot:header>

# Assalamualaikum Warahmatullahi Wabarakatuh,

Yth. **{{ $user->name }}**,

Kami menerima permintaan untuk mereset kata sandi akun **Hafalan Santri** Anda. Demi keamanan akun Anda, silakan klik tombol di bawah ini untuk melanjutkan proses perubahan kata sandi.

<x-mail::button :url="$resetUrl">
Reset Kata Sandi
</x-mail::button>

**Harap diperhatikan:**
- Tautan ini hanya berlaku selama **60 menit**.
- Jika Anda tidak merasa melakukan permintaan ini, mohon abaikan email ini. Akun Anda tetap aman.

Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:
<span class="break-all">{{ $resetUrl }}</span>

Terima kasih atas perhatian dan kerjasamanya.

Wassalamualaikum Warahmatullahi Wabarakatuh.

Hormat kami,<br>
**Tim Teknis Hafalan Santri MAKN Ende**

<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} Hafalan Santri MAKN Ende. Semua hak dilindungi undang-undang.
</x-mail::footer>
</x-slot:footer>
</x-mail::message>
