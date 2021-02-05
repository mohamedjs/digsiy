<div class="container ml-2">
  <div class="row">
    @if(auth()->check())
    <nav class="col-sm-3 col-md-2 p-0 d-sm-block bg-light sidebar">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link {{ strpos(url()->full(), 'websites') !== false ? 'active' : '' }}" href="{{ route('admin.websites.index') }}">Websites</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ strpos(url()->full(), 'articles') !== false ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">Articles</a>
        </li>
      </ul>
    </nav>
    @endif

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 main">
      @yield("content")
    </main>
  </div>
</div>