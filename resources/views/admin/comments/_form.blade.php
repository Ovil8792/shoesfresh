<div class="mb-3">
    <label for="user_id" class="form-label">Người bình luận</label>
    <select id="user_id" name="user_id" class="form-select" required>
        <option value="">Chọn người dùng</option>
        <!-- Options will be populated from controller -->
        <option value="1" {{ old('user_id', $comment->user_id ?? '') == 1 ? 'selected' : '' }}>Người dùng mẫu</option>
    </select>
</div>

<div class="mb-3">
    <label for="product_id" class="form-label">Sản phẩm</label>
    <select id="product_id" name="product_id" class="form-select" required>
        <option value="">Chọn sản phẩm</option>
        <!-- Options will be populated from controller -->
        <option value="1" {{ old('product_id', $comment->product_id ?? '') == 1 ? 'selected' : '' }}>Sản phẩm mẫu</option>
    </select>
</div>

<div class="mb-3">
    <label for="content" class="form-label">Nội dung bình luận</label>
    <textarea id="content" name="content" class="form-control" rows="5" placeholder="Nhập nội dung bình luận" required>{{ old('content', $comment->content ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="rating" class="form-label">Đánh giá (sao)</label>
    <select id="rating" name="rating" class="form-select" required>
        <option value="">Chọn số sao</option>
        <option value="1" {{ old('rating', $comment->rating ?? '') == 1 ? 'selected' : '' }}>1 sao</option>
        <option value="2" {{ old('rating', $comment->rating ?? '') == 2 ? 'selected' : '' }}>2 sao</option>
        <option value="3" {{ old('rating', $comment->rating ?? '') == 3 ? 'selected' : '' }}>3 sao</option>
        <option value="4" {{ old('rating', $comment->rating ?? '') == 4 ? 'selected' : '' }}>4 sao</option>
        <option value="5" {{ old('rating', $comment->rating ?? '') == 5 ? 'selected' : '' }}>5 sao</option>
    </select>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Trạng thái</label>
    <select id="status" name="status" class="form-select" required>
        <option value="">Chọn trạng thái</option>
        <option value="pending" {{ old('status', $comment->status ?? '') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
        <option value="approved" {{ old('status', $comment->status ?? '') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
        <option value="rejected" {{ old('status', $comment->status ?? '') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
    </select>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Lưu
    </button>
    <a href="{{ route('admin.comment') }}" class="btn btn-outline-secondary">Hủy</a>
</div>

