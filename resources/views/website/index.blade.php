@extends('layouts.app')

@section('content')
<div class="card mt-2 mb-2">
  <div class="card-body">
    Websites
    <span class="badge float-right">
      <a href="{{ route('admin.websites.create') }}" class="btn btn-sm btn-success">
        Create New Website 
      </a>
    </span>
  </div>
</div>
@include("layouts.alerts")
<div class="container table-responsive py-5"> 
  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Website Name</th>
        <th scope="col">Website Link</th>
        <th scope="col">Created At</th>
        <th scope="col">Last Scraped At</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($websites as $key => $website)
      <tr>
        <th scope="row">{{ $key+1 }}</th>
        <td>{{ $website->name }}</td>
        <td>{{ $website->link }}</td>
        <td>{{ $website->created_at->format("d M Y h:i a") }}</td>
        <td>{{ $website->last_scraped_at->format("d M Y h:i a") }}</td>
        <td>
          <a class="btn btn-primary mb-1" href="{{ route('admin.articles.index', ['website_id' => $website->id]) }}"> show Articles </a>
          <button  class="btn btn-success" onclick="event.preventDefault();document.getElementById('update-webiste').submit();">
             Update Article <i class="fas fa-edit-alt"></i>
           </button>
           <form id="update-webiste" action="{{ route('admin.websites.update', ['website' => $website]) }}" method="POST" class="d-none">
                @method("patch")
                @csrf
            </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
