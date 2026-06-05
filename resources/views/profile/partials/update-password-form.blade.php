<section class="settings-card">
    <div class="settings-card-header">
        <i class="fas fa-lock"></i>
        <div>
            <h2>Update Password</h2>
            <p>Ensure your account is using a long, random password to stay secure</p>
        </div>
    </div>

    <div class="settings-card-body">
        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div class="form-group">
                <label>Current Password <span class="required">*</span></label>
                <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" required>
                @error('current_password', 'updatePassword')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>New Password <span class="required">*</span></label>
                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" required>
                    <div class="form-text">Minimum 8 characters</div>
                    @error('password', 'updatePassword')
                        <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password <span class="required">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required>
                </div>
            </div>

            <div class="divider"></div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-sm text-green-600">
                        <i class="fas fa-check-circle"></i> Password updated!
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>