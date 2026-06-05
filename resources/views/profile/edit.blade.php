@extends('layouts.dashboard')

@section('page-title', 'Settings')
@section('breadcrumb', 'Account Settings')

@section('content')
<style>
    /* Settings Page Compact Styles */
    .settings-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .settings-card {
        background: white;
        border: 1px solid var(--shopee-border, #e2e8f0);
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .settings-card-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .settings-card-header i {
        font-size: 18px;
        color: #ee4d2d;
    }

    .settings-card-header h2 {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .settings-card-header p {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .settings-card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-group label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #ee4d2d;
        box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
    }

    .form-control:disabled {
        background: #f8fafc;
        cursor: not-allowed;
    }

    .form-text {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .btn-save {
        background: #ee4d2d;
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        background: #d63e1f;
        transform: translateY(-1px);
    }

    .btn-save:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-outline {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #065f46;
    }

    .alert-success i {
        font-size: 14px;
    }

    .divider {
        height: 1px;
        background: #e2e8f0;
        margin: 20px 0;
    }

    .info-box {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 12px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-box i {
        font-size: 18px;
        color: #0284c7;
    }

    .info-box-content {
        flex: 1;
    }

    .info-box-title {
        font-size: 12px;
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 2px;
    }

    .info-box-text {
        font-size: 11px;
        color: #0284c7;
    }

    @media (max-width: 640px) {
        .settings-card-body {
            padding: 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }
</style>

<div class="settings-container">
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('status') === 'profile-updated')
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        <span>Profile updated successfully!</span>
    </div>
    @endif

    <!-- Profile Information Card -->
    <div class="settings-card">
    <div class="settings-card-header">
        <i class="fas fa-user-circle"></i>
        <div>
            <h2>Profile Information</h2>
            <p>Update your account profile information</p>
        </div>
    </div>
    <div class="settings-card-body">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                    class="form-control @error('email') is-invalid @enderror" 
                    {{ auth()->user()->hasVerifiedEmail() ? 'disabled' : '' }}>
                @error('email')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                @enderror
                
                @if(auth()->user()->hasVerifiedEmail())
                    <div class="form-text" style="color: #f59e0b; margin-top: 8px;">
                        <i class="fas fa-info-circle"></i> 
                        Email sudah terverifikasi. Untuk mengubah email, silahkan hubungi admin.
                    </div>
                @else
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> 
                        Email belum diverifikasi. Anda dapat mengubah email kapan saja.
                    </div>
                @endif
            </div>
            
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div class="info-box">
                <i class="fas fa-envelope"></i>
                <div class="info-box-content">
                    <div class="info-box-title">Email Unverified</div>
                    <div class="info-box-text">Please verify your email address to access all features</div>
                </div>
                <button type="button" id="resendVerificationBtn" class="btn-outline" style="padding: 6px 12px; font-size: 11px;">
                    Resend Verification
                </button>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <!-- Tombol Save tetap aktif, tidak di-disable -->
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>

    <!-- Change Password Card -->
    <div class="settings-card">
        <div class="settings-card-header">
            <i class="fas fa-lock"></i>
            <div>
                <h2>Change Password</h2>
                <p>Update your password to keep your account secure</p>
            </div>
        </div>
        <div class="settings-card-body">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Current Password <span class="required">*</span></label>
                    <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required>
                    @error('current_password', 'updatePassword')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>New Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
                        <div class="form-text">Minimum 8 characters</div>
                        @error('password', 'updatePassword')
                        <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="divider"></div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Danger Zone Card -->
    <div class="settings-card">
        <div class="settings-card-header" style="border-bottom-color: #fee2e2;">
            <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
            <div>
                <h2 style="color: #dc2626;">Danger Zone</h2>
                <p>Permanently delete your account and all data</p>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="info-box" style="background: #fef2f2; border-color: #fecaca;">
                <i class="fas fa-trash-alt" style="color: #ef4444;"></i>
                <div class="info-box-content">
                    <div class="info-box-title" style="color: #991b1b;">Delete Account</div>
                    <div class="info-box-text" style="color: #dc2626;">Once deleted, all your products, projects, and data will be permanently removed</div>
                </div>
                <button type="button" onclick="openDeleteModal()" class="btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="modal-title">Delete Account</div>
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p>Are you sure you want to delete your account?</p>
                <p class="text-xs text-gray-500 mt-2">This action cannot be undone. All your products and data will be permanently deleted.</p>

                <div class="form-group mt-4">
                    <label>Enter your password to confirm</label>
                    <input type="password" name="password" id="deletePassword" class="form-control" required placeholder="Your password">
                    @error('password', 'userDeletion')
                    <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="modal-btn modal-btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    }

    // Resend verification email
    document.getElementById('resendVerificationBtn')?.addEventListener('click', async function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Sending...';
        btn.disabled = true;

        try {
            const response = await fetch('{{ route("verification.send") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message || 'Verification link sent to your email!', 'success');
                btn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 3000);
            } else {
                const errorMsg = data.message || 'Failed to send verification link. Please try again.';
                showToast(errorMsg, 'error');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Network error. Please check your connection and try again.', 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });

    function showToast(message, type = 'success') {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.toast');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;
        toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // Add these animations to your CSS
    const style = document.createElement('style');
    style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
    document.head.appendChild(style);

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close modal on overlay click
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background: white;
        border-radius: 12px;
        width: 420px;
        max-width: 90%;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95);
        transition: transform 0.2s ease;
        overflow: hidden;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1);
    }

    .modal-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header i {
        font-size: 18px;
    }

    .modal-header.danger i {
        color: #ef4444;
    }

    .modal-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        flex: 1;
    }

    .modal-body {
        padding: 20px;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
    }

    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-btn {
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .modal-btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }

    .modal-btn-cancel:hover {
        background: #e2e8f0;
    }

    .modal-btn-danger {
        background: #ef4444;
        color: white;
    }

    .modal-btn-danger:hover {
        background: #dc2626;
    }
</style>
@endsection