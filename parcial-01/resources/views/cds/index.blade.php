<?php

/** @var \App\Models\Artist[]|\Illuminate\Database\Eloquent\Collection $cds */
/** @var array $formParams */
?>

@extends('layouts.main')

@section('title', 'Discographies list - Cidi Market')

@section('main')

<div class="container d-flex  py-4">
    <div class="row justify-content-center">
        <div @guest class="col-md-12" @endguest @auth class="col-md-9" @endauth>
            <h1>Discographies List</h1>
            <p>Discographies</p>
        </div>
        @auth
        <div class="col-md-3 text-center add-cd my-mb-0 my-mb-0 my-2">
            <a class="btn btn-light" href="{{ url('/cds/new') }}" role="button">
                <i class="bi bi-plus-circle-dotted mr-2"></i>Add a new CD to the list
            </a>
        </div>
        @endauth
        @foreach($cds as $cd)
        <div class="col-md-10 mb-3">
            <div class="card card-body">
                <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                    <div class="mr-2 mb-3 mb-lg-0">
                        <img src="<?= url('imgs/image.svg'); ?>" width="150" height="150" alt="">
                    </div>

                    <div class="media-body">
                        <h2 class="media-title font-weight-semibold">
                            <a href="{{route('cds.view', ['cd' => $cd->cd_id])}}">{{$cd->title}}</a>
                        </h2>
                        <ul class="list-inline list-inline-dotted mb-3 text-muted">
                            <li class="list-inline-item">{{$cd->artist->name}}</li>
                            <li class="list-inline-item">|</li>
                            <li class="list-inline-item">Release date: {{$cd->release_date}}</li>
                        </ul>
                        <p class="mb-3">{{Str::limit($cd->description, 150)}}</p>
                        <ul class="list-inline list-inline-dotted mb-0">
                            <li class="list-inline-item">
                                @if($cd->genres->count() > 0)
                                @foreach($cd->genres as $genre)
                                <span class="badge bg-warning text-white">{{$genre->name}}</span> 
                                    @endforeach
                                @endif
                            </li>
                        </ul>
                    </div>

                    <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                        <h3 class="mb-0 font-weight-semibold">usd {{$cd->cost / 100}}</h3>
                        <div>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="text-muted">Duration {{$cd->duration}} min</div>

                        <ul class="d-grid gap-2">
                            <li>
                                <span class="d-inline-block mt-4  tabindex="0" data-toggle="tooltip" title="Cooming Soon baby">
                                    <button type="button" style="pointer-events: none;" disabled class="btn btn-warning text-white">
                                        <i class="bi bi-bag-plus mr-2"></i>Add to cart
                                    </button>
                                </span>
                            </li>
                            @auth
                            <li>
                                <a class="btn btn-outline-secondary mt-1" href="{{ route('cds.editForm', ['cd'=> $cd->cd_id]) }}">
                                <i class="bi bi-pencil-square mr-2"></i>Edit disc
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    {{$cds->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

