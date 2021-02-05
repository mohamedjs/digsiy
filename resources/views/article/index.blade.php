@extends('layouts.app')

@section('content')
<div class="card mt-2 mb-2">
  <div class="card-body">
    Articles
  </div>
</div>
@include("layouts.alerts")
<div class="container table-responsive py-5"> 
  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Article Name</th>
        <th scope="col">Article Description</th>
        <th scope="col">Article Dom</th>
        <th scope="col">Article Link</th>
        <th scope="col">Website Name</th>
        <th scope="col">Created At</th>
      </tr>
    </thead>
    <tbody>
      @foreach($articles as $key => $article)
      <tr>
        <th scope="row">{{ $key+1 }}</th>
        <td>{{ $article->title }}</td>
        <td>{{ $article->description }}</td>
        <td>{{ $article->dom }}</td>
        <td>{{ $article->link }}</td>
        <td>{{ $article->website->name }}</td>
        <td>{{ $article->created_at->format("d-m-Y") }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
