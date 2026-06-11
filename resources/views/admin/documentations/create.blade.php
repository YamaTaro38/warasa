@extends('layouts.admin')

@section('page-title', 'Add Documentation')
@section('breadcrumb', 'Management > Documentation > Add new guide')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-plus"></i>
            Add New Documentation
        </div>
        <a href="{{ route('admin.documentations.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.documentations.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Title <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-input" placeholder="Guide title" required>
                    @error('title')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Category <span style="color:var(--danger);">*</span></label>
                    <select name="category" class="form-input" required>
                        <option value="getting-started">Getting Started</option>
                        <option value="features">Features</option>
                        <option value="tutorials">Tutorials</option>
                        <option value="faq">FAQ</option>
                        <option value="general">General</option>
                    </select>
                    @error('category')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:8px;padding-top:8px;">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_published" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span style="font-size:12px;color:var(--gray-500);">Published</span>
                    </div>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Content <span style="color:var(--danger);">*</span></label>
                    <textarea name="content" id="editor" rows="15" class="form-input" style="display:none;">{{ old('content') }}</textarea>
                    <div id="editor-container" style="border:1px solid var(--gray-300);border-radius:var(--radius-sm);min-height:400px;"></div>
                    @error('content')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="saveBtn">
                    <i class="fas fa-save"></i> Save Documentation
                </button>
                <a href="{{ route('admin.documentations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/awjjj1dctwum069xk5eiochg1n61dzlwym0mhhb8x2c21ftd/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#editor-container',
    height: 500,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons'
    ],
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | table | code fullscreen | help',
    image_advtab: true,
    automatic_uploads: true,
    images_upload_handler: function(blobInfo, progress) {
        return new Promise(function(resolve, reject) {
            var formData = new FormData();
            formData.append('image', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("admin.documentations.upload-image") }}', {
                method: 'POST',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(result) {
                if (result.location) {
                    resolve(result.location);
                } else {
                    reject('Upload failed: ' + result.message);
                }
            })
            .catch(function(error) {
                reject('Upload failed: ' + error.message);
            });
        });
    },
    content_style: `
        body { font-family: Inter, -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; line-height: 1.8; color: #334155; padding: 20px; }
        h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
        h2 { font-size: 20px; font-weight: 600; color: #1e293b; margin: 24px 0 8px; }
        h3 { font-size: 16px; font-weight: 600; color: #1e293b; margin: 20px 0 6px; }
        p { margin-bottom: 12px; }
        ul, ol { margin-bottom: 12px; padding-left: 24px; }
        li { margin-bottom: 4px; }
        code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 13px; }
        pre { background: #1e293b; color: #e2e8f0; padding: 16px; border-radius: 8px; overflow-x: auto; }
        img { max-width: 100%; height: auto; border-radius: 8px; margin: 12px 0; }
        blockquote { border-left: 4px solid #ee4d2d; padding: 12px 16px; background: #fff5f2; margin: 12px 0; border-radius: 4px; }
        a { color: #ee4d2d; }
        table { width: 100%; border-collapse: collapse; margin: 12px 0; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: left; }
        th { background: #f8fafc; font-weight: 600; }
    `,
    setup: function(editor) {
        editor.on('change', function() {
            tinymce.triggerSave();
            document.getElementById('editor').value = editor.getContent();
        });
    }
});

document.getElementById('saveBtn').addEventListener('click', function(e) {
    var content = tinymce.activeEditor.getContent();
    document.getElementById('editor').value = content;
});
</script>
@endpush