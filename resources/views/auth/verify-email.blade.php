<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Kayıt olduğunuz için teşekkürler! Başlamadan önce, size e-posta ile gönderdiğimiz bağlantıya tıklayarak e-posta adresinizi doğrulayabilir misiniz? E-postayı almadıysanız, size memnuniyetle yenisini göndeririz.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Kayıt sırasında verdiğiniz e-posta adresine yeni bir doğrulama bağlantısı gönderildi.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Doğrulama E-postasını Tekrar Gönder
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Çıkış Yap
            </button>
        </form>
    </div>
</x-guest-layout>
