@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/select2/dist/css/select2.css')}}">
<link rel="stylesheet" href="{{asset('theme/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
@endpush

@section('content')

    <div class="row">

        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done! -  {{session('status')}}
                </div>
            @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6>Oops ! </h6>
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        </div>

        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-newspaper-variant-outline"></i>&nbsp; Nouveau Business case
                </div>

               <div class="card-body">
                    <form class="forms-sample" action="{{route('bcs.store')}}" method="POST">
                        @csrf
                        <div class="form-row pb-5">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="med">Médecin*</label>
                                <select class="form-control form-control-lg" id="med" name="med" required>

                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                    <label for="date_realisationbc">Date réalisation*</label>
                                    <input type="text" value="{{ old('date_realisationbc') }}" class="form-control form-control-lg" id="date_realisation_bc" name="date_realisationbc" placeholder="Date réalisation" autocomplete="off"  required>
                                    <small id="date_realisation_bcHelpBlock" class="form-text text-muted">
                                        la date de réalisation doit être au moins 3 jours après le jour de demande.
                                    </small>
                            </div>
                        </div>

                        <div class="form-row pb-3">
                                <div class="col-sm-12 col-md-4 mb-3">

                                        <label for="type_bc">Type d'investissement*</label>
                                        <select class="form-control" name="type_bc" id="type_bc" required>
                                            <option value=" "></option>
                                            <option value="Billet">Billet</option>
                                            <option value="Hôtel">Hôtel</option>
                                            <option value="Congrès">Congrès</option>
                                            <option value="Inscription">Inscription</option>
                                            <option value="Journée">Journée</option>
                                            <option value="Formation">Formation</option>
                                            <option value="Matériel">Matériel</option>
                                            <option value="Diner">Diner</option>
                                            <option value="Dejeuner">Dejeuner</option>
                                            <option value="Petit-Dej">Petit-Dej</option>
                                            <option value="Autre">Autre</option>
                                        </select>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                        <label for="destination_bc">Destination</label>
                                        <input type="text" value="{{ old('destination_bc') }}" class="form-control" id="destination_bc" name="destination_bc">
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label for="detail_bc">Detail d'investissement</label>
                                    <textarea  name="detail_bc" class="form-control" id="detail_bc"  cols="30" rows="3" required>{{ old('detail_bc') }}</textarea>

                                </div>

                            </div>

                            <div class="form-row pb-3">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                            <label for="montant_bc">Montant*</label>
                                            <input type="number" value="{{old('montant_bc')}}" class="form-control" placeholder="0000.00" id="montant_bc" name="montant_bc" required>
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="engagement_bc">Engagement</label>
                                        <select class="form-control" name="engagement_bc" id="engagement_bc">
                                                <option value=""></option>
                                                <option value="faible">Faible</option>
                                                <option value="moyen">Moyen</option>
                                                <option value="elevé">Elevé</option>
                                        </select>

                                    </div>
                            </div>
                            
                            <div class="form-row pt-3">
                                    <div class="col">
                                        <a href="{{route('bcs.index')}}" class="btn btn-light float-left">Annuler</a>
                                        <button type="submit" class="btn btn-success float-right">Demander</button>
                                    </div>
                            </div>

                    </form>
               </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('theme/vendors/select2/dist/js/select2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/searchmed.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
<script>
    $(document).ready(function(){

        $('#date_realisation_bc').datepicker({
            'startDate' : '+3d',
            todayBtn: "linked",
            language: "fr"
        });
    });
</script>
@endpush
