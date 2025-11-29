
@extends('admin.layout.master')
@section('main')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center bg-primary">
                <h4 class="mb-0 text-white">Sửa trạng thái liên hệ</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('comment.update', $comment->id) }}" method="PUT">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="1" @if($comment->status == 1) selected @endif>Hợp lệ</option>
                            <option value="0" @if($comment->status == 0) selected @endif>Không hợp lệ</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('comment.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- cái này nhé --}}
@endsection
