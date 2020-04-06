@extends('layout.main')

@push('styles')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8 grid-margin d-flex flex-column">
        <div class="row">
            <div class="col-sm-12 col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-primary mb-4">
                            <i class="mdi mdi-stethoscope mdi-36px"></i>
                            <p class="font-weight-medium mt-2">Visites Médicales</p>
                        </div>
                        <h1 class="font-weight-light">{{$nbr_v_mois}}</h1>
                        <p class="text-muted mb-0">Ce mois-ci</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-success mb-4">
                            <i class="mdi mdi-stethoscope mdi-36px"></i>
                            <p class="font-weight-medium mt-2">Visites Médicales</p>
                        </div>
                        <h1 class="font-weight-light">{{$nbr_v_week}}</h1>
                        <p class="text-muted mb-0">Cette semaine</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-danger mb-4">
                            <i class="mdi mdi-city mdi-36px"></i>
                            <p class="font-weight-medium mt-2">Visites Pharma</p>
                        </div>
                        <h1 class="font-weight-light">{{$nbr_ph_mois}}</h1>
                        <p class="text-muted mb-0">Ce mois-ci</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-info mb-4">
                            <i class="mdi mdi-city mdi-36px"></i>
                            <p class="font-weight-medium mt-2">Visites Pharma</p>
                        </div>
                        <h1 class="font-weight-light">{{$nbr_ph_week}}</h1>
                        <p class="text-muted mb-0">Cette semaine</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row flex grow-1">
            <div class="col-sm-12 grid-margin grid-margin-lg-0 stretch-card">
                <div class="card">
                    <div class="card-body p-3">

                        <div class="d-flex justify-content-between align-items-start">
                            <div class="col-sm-7">
                                <h4 class="card-title mt-2">Visites par specialité</h4>
                            </div>
                            <div class="col-auto">
                                <select id="spec-filter" class="custom-select custom-select-sm">
                                    <option value="month">Ce mois-ci</option>
                                    <option value="ninthyday">90 derniers jours</option>
                                </select>
                            </div>

                        </div>
                        <div id="piechart" >
                            <div class="d-flex justify-content-center">
                                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 grid-margin mt-2  stretch-card">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="col-sm-7">
                                <h4 class="card-title mt-2">Visites par ville</h4>
                            </div>
                            <div class="col-auto">
                                <select id="ville-filter" class="custom-select custom-select-sm">
                                    <option value="month">Ce mois-ci</option>
                                    <option value="ninthyday">90 derniers jours</option>
                                </select>
                            </div>

                        </div>
                        <div id="barchart">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card d-flex flex-column justify-content-between">
            <div class="card-body p-1">
                <h4 class="card-title p-3 mb-0 font-weight-bold">Médecins les plus visités</h4>
                <ul class="list-group list-group-flush">
                    @foreach($medecins as $medecin)
                    <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase">
                        {{$medecin->nom . ' ' . $medecin->prenom . ' - ' . $medecin->specialite->code}}<span class="badge badge-info badge-pill">{{$medecin->visites_count}}</span>
                    </li>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/psDash.js')}}" ></script>
@endpush
