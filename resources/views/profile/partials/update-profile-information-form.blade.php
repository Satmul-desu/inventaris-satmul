<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div class="mb-4">
            <x-input-label for="photo" :value="__('Foto Profil')" />
            <div class="mt-2 d-flex align-items-center gap-4">
                <!-- Foto Saat Ini -->
                @php
                    $hasPhoto = $user->photo;
                    $photoUrl = $hasPhoto ? asset('storage/' . $user->photo) : null;
                @endphp
                
                @if($hasPhoto)
                    <img src="{{ $photoUrl }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #667eea;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fa {{ $user->admin_icon ?? 'fa-user' }}" style="font-size: 36px;"></i>
                    </div>
                @endif
                
                <!-- Input File -->
                <div>
                    <x-text-input id="photo" name="photo" type="file" class="form-control mt-1" accept="image/*" onchange="previewPhoto(event)" />
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    <p class="text-sm text-muted mt-1">Format: JPG, PNG, GIF. Maks: 2MB</p>
                </div>
            </div>
            <!-- Preview Foto -->
            <div id="photo-preview-container" class="mt-3" style="display: none;">
                <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
                <img id="photo-preview" src="" alt="Preview" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #667eea;">
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Informasi Tambahan (Read-only) -->
        <div class="p-4 bg-gray-50 rounded-lg mt-4">
            <h4 class="font-medium text-gray-700 mb-3">Informasi Akun</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Role:</label>
                    <p class="font-medium text-gray-900">{{ $user->role->name ?? 'Owner' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Status:</label>
                    <p class="font-medium text-gray-900">
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Tidak Aktif</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan!') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('photo-preview-container');
            const previewImage = document.getElementById('photo-preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
</section>
