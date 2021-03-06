@extends('layouts.app')

@section('title')
    {{ $discipline->name }} - Portal das Disciplinas IMD
@endsection

@section('description')
    {{ $discipline->name }} - {{ $discipline->code }}, tutorado por {{ $discipline->professor->name }}. Clique para saiber mais.
@endsection

@section('scripts-head')
    <script src="{{asset('js/classification_system.js')}}" type="text/javascript"></script>
@endsection
@section('styles-head')
    <link href="{{asset('css/classification_system.css')}}" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <h2 class="container-fluid text-white text-center">{{ $discipline->name }} - {{ $discipline->code }}</h2>

    @if (isset($can))
        @if($can)
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 mt-5">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-light btn-block"
                            data-toggle="modal" data-target="#faqs-create">
                        Registrar FAQ
                    </button>
                </div>
            </div>
        @endif
    @endif

    <div class="row mt-3">
        <div class="col-12">
            <h3 class="text-white">Sinopse</h3>
            <div class="border border-info rounded">
                <div class="bg-color4">
                    <div class="text-white text-justify px-lg-3"> {{ $discipline->synopsis }} </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-8">
            <h3 class="text-white">Trailer</h3>
            @if(!is_null($discipline->trailer))
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $discipline->trailer->url}}" allowfullscreen></iframe>
                </div>
            @else
                <img class="img-fluid" src="{{ asset('img/novideo1.png') }}" alt="Sem trailer">
            @endif
        </div>

        <div class="col-md-4">
            <h3 class="text-white">Classificação</h3>
            @foreach ($discipline->classifications as $classification)
            <div class="row">
                <div class="col-md-5 mt-1">
                    <label class="text-white">
                        {{$classification->name}}
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="progress">
                        <div id="{{$classification->classificationDiscipline($discipline->id)->first()->classification_id}}" class="progress-bar progress-bar-striped" role="progressbar" style="width: {{($classification->classificationDiscipline($discipline->id)->first()->value/6)*100}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="20"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <h3 class="text-white">Vídeo</h3>
            @if($discipline->hasMediaOfType(\App\Enums\MediaType::VIDEO))
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" allowfullscreen
                            src="{{ $discipline->getMediasByType(\App\Enums\MediaType::VIDEO)->first()->url }}"></iframe>
                </div>
            @else
                <img class="img-fluid" src="{{ asset('img/novideo2.png') }}" alt="Sem vídeo">
            @endif
        </div>

        @if($discipline->hasMediaOfType(\App\Enums\MediaType::PODCAST))
            <div class="col-md-6">
                <h3 class="text-white">Podcast</h3>
                <audio controls="controls">
                    <source src="{{ $discipline->getMediasByType(\App\Enums\MediaType::PODCAST)->first()->url}}" type="audio/mp3" />
                    seu navegador não suporta HTML5
                </audio>
            </div>
        @endif
            

    </div>

    <div class="row mt-3">
        <div class="col-md-10">
            <h3 class="text-white">Obstáculos</h3>
            <div class="border border-info rounded">
                <div class="bg-color4">
                    <div class="text-white text-justify px-lg-3">{{ $discipline->difficulties }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <h3 class="text-white">Materiais</h3>
            @if($discipline->hasMediaOfType(\App\Enums\MediaType::MATERIAIS))
                <div class="d-flex align-center">
                    <a href="{{ $discipline->getMediasByType(\App\Enums\MediaType::MATERIAIS)->first()->url}}"
                       class="text">
                        <i class="fas fa-file-download fa-9x materiais-on"></i>
                    </a>
                    <br/>
                </div>
            @else
                <a href="#" class="text">
                    {{-- <i class="fas fa-file-download fa-7x materiais-off"></i> --}}
                    <i class="fas fa-file-excel fa-9x materiais-off"></i>
                </a>
                <br/>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <h3 class="text-white">Professor</h3>
            <div class="border border-info rounded">
                <div class="bg-color4">
                    <div class="text-white text-justify px-lg-3"> {{ $discipline->professor->name }} </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h3 class="text-white">Email</h3>
            <div class="border border-info rounded">
                <div class="bg-color4">
                    <div class="text-white text-justify px-lg-3"> {{ $discipline->professor->public_email }} </div>
                </div>
            </div>
        </div>
    </div>

    @if($discipline->faqs->count())
        <h2 class="container-fluid text-white text-center mt-5">FAQ</h2>
        <div class="row mt-3" id="faqs">
            @foreach($discipline->faqs as $faq)
                <div class="col-md-12 card">
                    <div class="card-header" id="faq-header-{{$faq->id}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faq-content-{{$faq->id}}"
                                    aria-expanded="true" aria-controls="faq-header-{{$faq->id}}">
                                {!! $faq->title !!}
                            </button>
                        </h5>
                    </div>

                    <div id="faq-content-{{$faq->id}}" class="collapse" aria-labelledby="faq-header-{{$faq->id}}" data-parent="#faqs">
                        <div class="card-body">
                            {!! $faq->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($can))
        @if ($can)
            @include('faqs.create_modal', ['discipline' => $discipline])
        @endif
    @endif
@endsection
