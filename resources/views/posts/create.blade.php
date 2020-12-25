@extends('skeleton')

@section('title', 'Create New Article')

@section('content')
  <div class="mainheading">
    <h1 class="sitetitle">Create New Article</h1>
    <p class="lead">
      Bootstrap theme, medium style, simply perfect for bloggers
    </p>
  </div>

  <section class="recent-post">
    <div class="section-title">
      <h2><span>Write Your Article Here...</span></h2>
    </div>
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="author">Author <span class="text-danger">*</span></label>
            <input type="text" name="author" id="author" tabindex="1" class="form-control" value="{{ old('author') }}">
          </div>
          <div class="form-group">
            <label for="author_photo">Author Photo <span class="text-danger">*</span></label>
            <input type="file" name="author_photo" id="author_photo" tabindex="2" class="form-control">
          </div>
          <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" tabindex="3" class="form-control" value="{{ old('title') }}">
          </div>
          <div class="form-group">
            <label for="description">Sort Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" cols="30" rows="3"
              class="form-control">{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label for="image">Article Image <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image" tabindex="4" class="form-control">
          </div>
          <div class="form-group">
            <label for="content">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" tabindex="5" class="form-control">{{ old('content') }}</textarea>
          </div>
          <div class="form-group text-right">
            <button type="reset" class="btn btn-outline-primary mr-1">Reset</button>
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

      $('button:reset').click(function() {
        $('#content').summernote('reset');
      });
    });

  </script>
@endpush
