<div class="reply-box">
  <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
    @include('shared._errors')
    {{ csrf_field() }}
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
    <div class="form-group">
      <textarea name="content" rows="3" class="form-control" placeholder="你说你马呢"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i> 回复</button>
  </form>
</div>
<hr>
