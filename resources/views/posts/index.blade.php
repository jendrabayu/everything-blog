@extends('skeleton')

@section('content')

  <section class="featured-posts">
    <div class="section-title">
      <h2><span>{{ $content_title }}</span></h2>
    </div>
    @include('partials.alerts')
    <div class="card-columns listfeaturedtag">

      @foreach ($posts as $post)
        <!-- begin post -->
        <div class="card">
          <div class="row">
            <div class="col-md-5 wrapthumbnail">
              <a href="{{ route('post.show', $post['slug']) }}">
                <div class="thumbnail" style="background-image:url({{ Storage::url($post['image']) }});">
                </div>
              </a>
            </div>
            <div class="col-md-7">
              <div class="card-block">
                <h2 class="card-title"><a
                    href="{{ route('post.show', $post['slug']) }}">{{ Str::limit($post['title'], 70) }}</a></h2>
                <h4 class="card-text">{{ Str::limit($post['description'], 120) }}</h4>
                <div class="metafooter">
                  <div class="wrapfooter">
                    <span class="meta-footer-thumb">
                      <img class="author-thumb" src="{{ Storage::url($post['author_photo']) }}"
                        alt="{{ $post['author'] }}">
                    </span>
                    <span class="author-meta">
                      <span class="post-name">{{ Str::words($post['author'], 2, '') }}</span><br />
                      <span
                        class="post-date">{{ \Carbon\Carbon::parse($post['created_at'])->isoFormat('D MMMM Y') }}</span>
                    </span>
                    <span class="post-read-more">
                      <a href="{{ route('post.edit', [$post['slug']]) }}">
                        <svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25">
                          <image xlink:href="{{ asset('assets/img/icon/edit.svg') }}" width="20" height="20" />
                        </svg>
                      </a>
                      <a href="javascript:;" class="ml-2 btn-delete"
                        data-link="{{ route('post.destroy', $post['slug']) }}">
                        <svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25">
                          <image xlink:href="{{ asset('assets/img/icon/trash.svg') }}" width="20" height="20" />
                        </svg>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end post -->
      @endforeach

    </div>
  </section>

  <form id="form-delete" action="" method="post" hidden>
    @csrf
    @method('DELETE')
  </form>
@endsection


@push('javascript')
  <script>
    $(function() {
      $('.btn-delete').click(function() {
        $('#form-delete').prop('action', $(this).data('link'));
        $('#form-delete').submit();
      });
    });

  </script>
@endpush
