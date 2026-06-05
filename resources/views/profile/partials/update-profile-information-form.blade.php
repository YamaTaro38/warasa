<section class="settings-card">
    <div class="settings-card-header">
        <i class="fas fa-user-edit"></i>
        <div>
            <h2>Profile Information</h2>
            <p>Update your account's profile information</p>
        </div>
    </div>

    <div class="settings-card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <div class="form-group">
                <label>Name <span class="required">*</span></label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="info-box mt-3" style="background: #fef3c7; border-color: #fde68a;">
                        <i class="fas fa-envelope" style="color: #d97706;"></i>
                        <div class="info-box-content">
                            <div class="info-box-title" style="color: #92400e;">Email Unverified</div>
                            <div class="info-box-text" style="color: #b45309;">Please verify your email address</div>
                        </div>
                        <button form="send-verification" class="btn-outline" style="padding: 6px 12px; font-size: 11px;">
                            Resend Verification
                        </button>
                    </div>
                @endif
            </div>

            <div class="divider"></div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-sm text-green-600">
                        <i class="fas fa-check-circle"></i> Saved!
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>