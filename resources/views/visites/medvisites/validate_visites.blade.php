@extends('layout.main')
@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done ! -  {{session('status')}}
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
    </div>

<div class="row">
        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">

                    <form class="" action="{{route('medvisites.validation')}}" method="get">
                        <div class="form-row align-items-center">

                            <input type="hidden" name="query" value="search">

                            <div class="col-sm-12 col-md-4">
                                <label for="date_v">Date visite</label>
                                <input type="text" class="form-control" name="date_d" id="date_d" placeholder="jj/mm/aaaa" autocomplete="off" required>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="date_f">Date visite</label>
                                <input type="text" class="form-control" name="date_f" id="date_f" placeholder="jj/mm/aaaa" autocomplete="off" required>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="dm">Délégue</label>
                                <select class="form-control" name="dm" id="dm" required>
                                    <option value="">Choisir...</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->user_id}}">{{$user->nom .' '.$user->prenom}}</option>
                                        @endforeach

                                </select>
                            </div>


                                <div class="col-sm-12 col-md-1">
                                    <button class="btn btn-primary mt-4" type="submit"><i class="mdi mdi-magnify"></i>Filtrer</button>
                                </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
</div>

<div class="row">
    <div class="col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">
                    @if(Request::has('query'))  <i class='mdi mdi-filter'></i> Filtres : @endif
                    {{Request::has('date_d') == true ? 'Date du ' . Request::input('date_d') : ''}}
                    {{Request::has('date_f') == true ? 'Au '. Request::input('date_f') : ''}}
                </h4>

                <table class="table table-bordered">
                    <thead>
                        <th>Date visite</th>
                        <th>Médecin</th>
                        <th>Specialité</th>
                        <th>Potentiel</th>
                        <th>Zone - Ville</th>
                        <th>Etat visite</th>
                        <th>Délégue</th>
                        <th>Valide ?</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                     @if($visites && $visites->count() > 0)
                         @foreach($visites as $visite)
                             <tr>
                                 <td class="">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$visite->date_visite)->format('d/m/Y')}}</td>
                                 <td class="text-uppercase">{{$visite->medecin->nom . ' '. $visite->medecin->prenom}}</td>
                                 <td class="text-uppercase">{{$visite->medecin->specialite->code}}</td>
                                 <td class="text-uppercase">{{$visite->medecin->potentiel}}</td>
                                 <td class="text-uppercase">{{$visite->medecin->zone_med . ' - ' . $visite->medecin->ville->libelle}}</td>
                                 <td class="text-capitalize">{{$visite->etat}}</td>
                                 <td class="text-capitalize">{{$visite->created_by}}</td>
                                 <td class="text-capitalize" ><label class="{{$visite->valid === null ? 'badge badge-warning' : ($visite->valid ? 'badge badge-success' : 'badge badge-secondary') }}">{{$visite->valid === null ? 'En cours' : ($visite->valid ? 'valide' : 'invalide') }}</label></td>
                                 <td class="text-uppercase">
                                     @if($visite->valid === null)
                                     <a href="javascript:void(0)" data-toggle="modal" data-target="#validateModel" data-whatever="{{$visite->visitemed_id}}" data-datevisite="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$visite->date_visite)->format('d/m/Y')}}" data-validation="1" data-dm="{{$visite->created_by}}" style="font-size: 22px" class="text-success"><i class="mdi mdi-checkbox-marked-circle-outline"></i></a> &nbsp;
                                     <a href="javascript:void(0)" data-toggle="modal" data-target="#validateModel" data-whatever="{{$visite->visitemed_id}}" data-datevisite="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$visite->date_visite)->format('d/m/Y')}}" data-validation="0" data-dm="{{$visite->created_by}}" style="font-size: 22px" class="text-warning"><i class="mdi mdi-close-circle-outline"></i></a>
                                    @endif
                                 </td>
                             </tr>
                             @endforeach
                     @else
                              <tr class="text-center">
                                  <td colspan="9">Aucune donnée disponible dans le tableau</td>
                              </tr>
                     @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('modals')

    <!-- Modal -->
    <div class="modal fade" id="validateModel" tabindex="-1" role="dialog" aria-labelledby="validateModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Visite du : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-1">Nous aimerions vraiment savoir votre opinion sur cette visite :</h6>
                    <form action="" method="post" id="validation_form">
                        @csrf
                        <input type="hidden" name="validation_type" id="validation_type" value="">
                        <textarea class="form-control"  name="validation_note" id="validation_note" cols="20" rows="5" required></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('validation_form').submit()" type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>

    @endsection

@push('scripts')
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#date_d,#date_f').datepicker({
            todayBtn: "linked",
            language: "fr"
        });

        $('#validateModel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) ;// Button that triggered the modal
            var v_id = button.data('whatever'); // Extract info from data-* attributes
            var validation = button.data('validation');
            var date_visite = button.data('datevisite');
            var dm = button.data('dm');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-body>form').attr('action','/medecins/visites/validation/'+v_id);

            if(validation == "0"){
                modal.find('.modal-footer>button[type="submit"]').text("Invalider");
            }
            else if(validation == "1"){
                modal.find('.modal-footer>button[type="submit"]').text("valider");
            }
            else{
                modal.find('.modal-footer>button[type="submit"]').prop("disabled",true);
            }

            modal.find('.modal-body>form #validation_type').val(validation);
            modal.find('.modal-title>span').text(date_visite + " - Délégue: " + dm);

        });

        $('#validateModel').on('hide.bs.modal', function (event) {

            var modal = $(this);

            modal.find('.modal-footer>button[type="submit"]').prop("disabled",false);
            modal.find('.modal-body>form').removeAttr('action');
            modal.find('.modal-footer>button[type="submit"]').text("");
            modal.find('.modal-body>form #validation_type').val("");
            modal.find('.modal-title>span').text("");

        });
    });
</script>
@endpush