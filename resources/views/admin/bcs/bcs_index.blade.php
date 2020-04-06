@extends('layout.main')

@push('styles')
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
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="card">

                <div class="card-body">

                    <form class="justify-content-center" id="search-bcs" action="{{route('admin.bc.index')}}" method="get">
                        <div class="form-row ">
                            <div class="col ">
                                <label for="dt_d">Demandé entre le</label>
                                <input type="text" id="dt_d" name="dt_d" class="form-control" placeholder="Date début" autocomplete="off" required>
                            </div>
                            <div class="col">
                                <label for="dt_f">Et le</label>
                                <input type="text" id="dt_f" name="dt_f" class="form-control " placeholder="Date fin" autocomplete="off" required>
                            </div>

                            <div class="col">
                                <label for="user">Délégué</label>
                                <select name="user" class="form-control" id="user">
                                    <option value="">Choisir...</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->user_id . '_' . $user->nom . ' ' . $user->prenom}}">{{$user->nom . ' ' . $user->prenom}}</option>
                                    @endforeach
                                </select>
                            </div>

                                <button type="submit" class="btn btn-primary mt-4"><i style="font-size: 20px" class="mdi mdi-magnify"></i></button>

                        </div>



                    </form>

                </div>

            </div>

        </div>
    </div>

   <div class="row mt-3">
        <div class="col-sm-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title">
                        <span class="badge badge-secondary">{{$bcs->total()}}</span> BC trouvé(s)
                        <h4 class="card-title">
                            @if(Request::has(['dt_d','dt_f']))  <i class='mdi mdi-filter'></i> Filtres : @endif
                            {{Request::has('dt_d') == true ? 'Date du ' . Request::input('dt_d') : ''}}
                            {{Request::has('dt_f') == true ? 'Au '. Request::input('dt_f') : ''}}
                            {{Request::has('user') ? '/ Délégué : ' .  substr(Request::input('user'),strpos(Request::input('user'), '_') + 1) : ''}}
                            @if(Request::has(['dt_d','dt_f']))
                                <a class="float-sm-right text-primary" href="{{route('admin.bc.index')}}"><i class="mdi mdi-filter-remove"></i>&nbsp; Réinitialiser</a>
                            @endif
                        </h4>
                    </h4>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Date demande</th>
                            <th scope="col">Date réalisation</th>
                            <th scope="col">Médecin</th>
                            <th scope="col">Specialité</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Type</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Délégue</th>
                            <th scope="col">Voir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bcs as $bc)
                            <tr>
                                <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_demande)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_realisation)->format('d/m/Y')}}</td>
                                <td class="text-uppercase">{{$bc->medecin->nom . ' '. $bc->medecin->prenom}}</td>
                                <td>{{$bc->medecin->specialite->code}}</td>
                                <td>{{$bc->medecin->ville->libelle}}</td>
                                <td>{{$bc->type}}</td>
                                <td class="font-weight-bold">{{number_format($bc->montant,2,',',' ') . ' Dhs'}}</td>
                                <td class="text-capitalize">{{$bc->etat}}</td>
                                <td>{{$bc->created_by}}</td>
                                <td class="text-center text-secondary">
                                    <a href="{{route('admin.bc.show',['id'=>$bc->bc_id])}}">
                                        <i class="mdi mdi-information-outline"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <nav class="mt-5">
                        <ul class="pagination d-flex justify-content-center pagination-rounded">
                            {{ $bcs->appends([
                                                   'dt_d'=>Request::input('dt_d'),
                                                   'dt_f'=>Request::input('dt_f'),
                                                   'user'=>Request::input('user'),
                                                    ])->links() }}
                        </ul>
                    </nav>

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
        $('#search-bcs #dt_d,#search-bcs #dt_f').datepicker({
            todayBtn: "linked",
            language: "fr"
        });
    });
</script>
@endpush