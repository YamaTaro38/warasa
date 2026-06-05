<section class="settings-card">
    <div class="settings-card-header" style="border-bottom-color: #fee2e2;">
        <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
        <div>
            <h2 style="color: #dc2626;">Delete Account</h2>
            <p>Permanently delete your account and all data</p>
        </div>
    </div>

    <div class="settings-card-body">
        <div class="info-box" style="background: #fef2f2; border-color: #fecaca;">
            <i class="fas fa-trash-alt" style="color: #ef4444;"></i>
            <div class="info-box-content">
                <div class="info-box-title" style="color: #991b1b;">Warning</div>
                <div class="info-box-text" style="color: #dc2626;">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Before deleting your account, please download any data or information that you wish to retain.
                </div>
            </div>
            <button type="button" onclick="openDeleteModal()" class="btn-danger">
                <i class="fas fa-trash-alt"></i> Delete Account
            </button>
        </div>
    </div>
</section>

<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="modal-title">Delete Account</div>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="modal-body">
                <p>Are you sure you want to delete your account?</p>
                <p class="text-xs text-gray-500 mt-2">This action cannot be undone. All your products, projects, and data will be permanently deleted.</p>

                <div class="form-group mt-4">
                    <label>Enter your password to confirm</label>
                    <input id="delete_account_password" name="password" type="password" class="form-control" placeholder="Your password" required>
                    @error('password', 'userDeletion')
                        <div class="form-text" style="color: #ef4444;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeDeleteAccountModal()">Cancel</button>
                <button type="submit" class="modal-btn modal-btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal() {
    const modal = document.getElementById('deleteAccountModal');
    if (modal) {
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
    }
}

function closeDeleteAccountModal() {
    const modal = document.getElementById('deleteAccountModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 300);
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteAccountModal();
    }
});

document.getElementById('deleteAccountModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteAccountModal();
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