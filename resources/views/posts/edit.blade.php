@extends('skeleton')

@section('title', 'Edit Article')

@section('content')
  <div class="mainheading">
    <h1 class="sitetitle">Edit Article</h1>
    <p class="lead">
      Bootstrap theme, medium style, simply perfect for bloggers
    </p>
  </div>

  <section class="recent-post">
    <div class="section-title">
      <h2><span>Edit Your Article Here...</span></h2>
    </div>
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <form action="{{ route('post.update', $post['slug']) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="author">Author <span class="text-danger">*</span></label>
            <input type="text" name="author" id="author" tabindex="1" class="form-control" value="{{ $post['author'] }}">
          </div>
          <div class="form-group">
            <label for="author_photo">Author Photo <span class="text-danger">*</span></label>
            <input type="file" name="author_photo" id="author_photo" tabindex="2" class="form-control">
          </div>
          <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" tabindex="3" class="form-control" value="{{ $post['title'] }}">
          </div>
          <div class="form-group">
            <label for="description">Sort Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" cols="30" rows="3"
              class="form-control">{{ $post['description'] }}</textarea>
          </div>
          <div class="form-group">
            <label for="image">Article Image <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image" tabindex="4" class="form-control">
          </div>
          <div class="form-group">
            <label for="content">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" tabindex="5" class="form-control">{{ $post['content'] }}</textarea>
          </div>
          <div class="form-group text-right">
            <button id="btn-reset" type="button" class="btn btn-outline-primary mr-1">Reset</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@push('stylesheet')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@push('javascript')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(function() {
      $('#content').summernote({
        height: 300,
      });

      $('#btn-reset').click(function() {
        window.location.reload();
      });
    });

  </script>
@endpush
