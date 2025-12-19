<x-mail::message>
<!-- Greeting -->
<x-slot:header>
<x-mail::header :url="config('app.url')">
Hafalan Santri MAKN Ende
</x-mail::header>
</x-slot:header>

{{-- Header --}}
# Halo {{ $user->name }},

Anda menerima email ini karena ada permintaan reset kata sandi untuk akun Anda di Hafalan Santri MAKN Ende.

## Reset Kata Sandi

Silakan klik tombol di bawah ini untuk mereset kata sandi Anda:

<x-mail::button :url="$resetUrl">
Reset Kata Sandi
</x-mail::button>

Jika tombol di atas tidak berfungsi, Anda juga bisa mengklik tautan berikut:

[{{ $resetUrl }}]({{ $resetUrl }})

## Informasi Tambahan

Jika Anda tidak meminta reset kata sandi, abaikan email ini. Email ini dibuat secara otomatis, mohon jangan balas email ini.

<x-mail::subcopy>
© {{ date('Y') }} Hafalan Santri MAKN Ende. Madrasah Aliyah Kejuruan Negeri Ende.
</x-mail::subcopy>

<x-mail::footer>
<x-mail::subcopy>
© {{ date('Y') }} Hafalan Santri MAKN Ende. Madrasah Aliyah Kejuruan Negeri Ende.
</x-mail::subcopy>
</x-mail::footer>
</x-mail::message>
