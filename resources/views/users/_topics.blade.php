@if (count($topics))
  <ul class="list-group mt-4 border-0">
    @foreach ($topics as $topic)
      <li class="list-group-item pl-2 pr-2 border-right-0 border-left-0 @if($loop->first) border-top-0 @endif">
        <a href="{{ $topic->link() }}">
          {{ $topic->title }}
        </a>
        <span class="meta float-right text-secondary">
          {{ $topic->reply_count }} 回复
          <span> ⋅ </span>
          {{ $topic->created_at }}
        </span>
      </li>
    @endforeach
  </ul>

  <div class="mt-4 pt-1">
    {{ $topics->render() }}
  </div>
@else
  <div class="empty-block">你看你马呢</div>
@endif
