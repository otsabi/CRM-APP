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
                    Well done ! - {{session('status')}}
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
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">

                    <form id="search-visites" action="{{route('admin.visiteph_results')}}" method="get">
                        <div class="form-row">
                            <div class="col">
                                <label for="">Date debut</label>
                                <input type="text" id="dt_d" name="dt_d" class="form-control form-control-lg" placeholder="Date début" autocomplete="off" required>
                            </div>
                            <div class="col">
                                <label for="">Date fin</label>
                                <input type="text" id="dt_f" name="dt_f" class="form-control form-control-lg" placeholder="Date fin" autocomplete="off" required>
                            </div>

                            <div class="col">
                                <label for="etat">Etat</label>
                                <select name="etat[]" class="form-control form-control-lg" id="etat" multiple="multiple">
                                    <option value="plan">Plan</option>
                                    <option value="reporté">Reporté</option>
                                    <option value="réalisé hors plan">réalisé hors plan</option>
                                    <option value="réalisé">Réalisé</option>
                                </select>
                            </div>


                        </div>
                        <div class="form-row mt-4">

                            <div class="col">
                                <label for="user">Délégues</label>
                                <select name="user[]" class="form-control form-control-lg" id="user" multiple="multiple">
                                    @foreach($users as $user)
                                        <option value="{{$user->user_id}}">{{$user->nom . ' ' . $user->prenom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="sect">Secteur</label>
                                <select name="sect[]" class="form-control form-control-lg"  id="sect" multiple="multiple">
                                    @foreach($secteurs as $sect)
                                        <option value="{{$sect->secteur_id}}">{{$sect->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary mt-4"><i style="font-size: 20px" class="mdi mdi-magnify"></i></button>


                    </form>

                </div>

            </div>

        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('theme/vendors/select2/dist/js/select2.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#user,#spec,#etat,#sect').select2();

        $('#search-visites #dt_d,#search-visites #dt_f').datepicker({
            todayBtn: "linked",
            language: "fr"
        });
    });
</script>
@endpush