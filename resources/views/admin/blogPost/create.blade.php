<!-- Modal Thêm Bài Viết -->
<div class="modal fade" id="addBlogPostModal" tabindex="-1" aria-labelledby="addBlogPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('blog_post.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBlogPostModalLabel">Thêm bài viết</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug">
          </div>
          <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
          </div>
          <div class="mb-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="blog_category_id" class="form-label">Danh mục</label>
            <select class="form-select" id="blog_category_id" name="blog_category_id" required>
              <option value="">-- Chọn danh mục --</option>
              @foreach($BlogCategory as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-select" id="status" name="status">
              <option value="1">Hiển thị</option>
              <option value="0">Ẩn</option>
            </select>
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Kết thúc Modal -->
