@extends('layout.main')

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
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-badge-horizontal"></i>&nbsp; Mes visites pharmacie
                        <a class="float-sm-right text-dark" data-toggle="modal" data-target="#filterModel" href="#" > Filtrer <i class="mdi mdi-filter-menu"></i> </a>
                    </h5>

                </div>
                <div class="card-body">
                    <h4 class="card-title">
                        @if(Request::has('type'))  <i class='mdi mdi-filter'></i> Filtres : @endif
                        {{Request::has('date_debut') == true ? 'Date du ' . Request::input('date_debut') : ''}}
                        {{Request::has('date_fin') == true ? 'Au '. Request::input('date_fin') : ''}}
                        {{Request::has('etat') &&  Request::input('etat') != '' ? '/ Etat des visites : '. Request::input('etat') : ''}}
                        @if(Request::has(['date_debut','date_fin']))
                                <a class="float-sm-right text-primary" href="{{route('phvisites.index')}}"><i class="mdi mdi-filter-remove"></i>&nbsp; Réinitialiser</a>
                        @endif
                    </h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th></th>
                            <th>Date visite</th>
                            <th>Pharmacie</th>
                            <th>Potentiel</th>
                            <th>Zone</th>
                            <th>Ville</th>
                            <th>Etat</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($visites as $visite)
                                <tr>
                                    <td class="text-center">
                                        <a class="text-info" style="font-size: 1.6rem" href="#visite{{$visite->visitephar_id}}"  aria-controls="#visite{{$visite->visitephar_id}}" data-toggle="collapse" aria-expanded="false" ><i class="mdi mdi-chevron-down-circle"></i></a>
                                    </td>
                                    <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$visite->date_visite)->format('d/m/Y')}}</td>
                                    <td class="text-uppercase">{{$visite->pharmacie->libelle}}</td>
                                    <td class="text-uppercase">{{$visite->pharmacie->potentiel}}</td>
                                    <td class="text-uppercase">{{$visite->pharmacie->zone_ph}}</td>
                                    <td class="text-uppercase">{{$visite->pharmacie->ville->libelle}}</td>
                                    <td class="text-capitalize">{{$visite->etat}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdown{{$visite->visitephar_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                            <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$visite->visitephar_id}}">
                                                <a class="dropdown-item" href="{{route('phvisites.show',['phvisite' => $visite->visitephar_id])}}"><i class="mdi mdi-eye"></i>&nbsp;Voir</a>
                                                @if($visite->etat === 'plan') <a class="dropdown-item" href="{{route('phvisites.edit',['phvisite' => $visite->visitephar_id])}}"><i class="mdi mdi-pencil"></i>&nbsp;Modifier</a> @endif
                                                @if($visite->etat === 'plan') <a class="dropdown-item" data-toggle="modal" data-target="#deleteModel" data-whatever="{{$visite->visitephar_id}}" data-pharma="{{$visite->pharmacie->libelle}} {{$visite->pharmacie->zone_ph}}" data-datev="{{Carbon\Carbon::createFromFormat('Y-m-d',$visite->date_visite)->format('d/m/Y')}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a> @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="collapse table-info"  id="visite{{$visite->visitephar_id}}">
                                     <td colspan="4" >
                                           @if($visite->products->count() > 0)
                                               <ul class="mb-0">
                                                   @foreach($visite->products as $product)
                                                       <li class="pb-1">
                                                           Produit : <strong> {{$product->code_produit}}  </strong> &nbsp;
                                                           Nombre boîtes: <strong>{{$product->pivot->nb_boites}}</strong>
                                                       </li>
                                                   @endforeach
                                                </ul>
                                           @else
                                                <span>il n'y a pas encore de produits</span>
                                           @endif

                                      </td>
                                       <td colspan="5">
                                           @if(empty($visite->note))
                                            <span>Aucune note pour cette visite</span>
                                           @else
                                               <span>{{$visite->note}}</span>
                                            @endif
                                      </td>
                                </tr>

                            @endforeach {{-- end global loop--}}
                        </tbody>
                    </table>

                    <nav class="mt-5">
                        <ul class="pagination d-flex justify-content-center pagination-rounded">
                            {{ $visites->links() }}
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <!-- Modal -->
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Visite du : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Etes-vous sûr que vous voulez supprimer cette visite ?</h6>
                    <form action="" method="post" id="delete_form">
                        @csrf
                        @method('delete')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('delete_form').submit()" type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- filter Modal -->
    <div class="modal fade" id="filterModel" tabindex="-1" role="dialog" aria-labelledby="filterModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Filtrer vos visites</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filter-form" action="{{route('phvisites.index')}}" method="GET">
                        <input type="hidden" name="type" value="search">
                        <div class="form-row align-items-center">
                            <div class="col-sm-12 col-md-4">
                                <label for="date_start">Date début</label>
                                <input type="input" class="form-control selectdate" name="date_debut" id="date_start" required>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="date_end">Date fin</label>
                                <input type="input" class="form-control selectdate" name="date_fin" id="date_end" required>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="etat">Etat</label>
                                <select name="etat" id="etat" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="Plan">Plan</option>
                                    <option value="Réalisé">Réalisé</option>
                                    <option value="Réalisé hors plan">Réalisé hors plan</option>
                                    <option value="Reporté">Reporté</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('filter-form').submit()" type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{asset('theme/vendors/inputmask/dist/jquery.inputmask.js')}}"></script>
<script src="{{asset('theme/vendors/inputmask/dist/inputmask.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".selectdate").inputmask("99/99/9999",{"placeholder": "jj/mm/aaaa"});
        $('#deleteModel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) ;// Button that triggered the modal
            var v_id = button.data('whatever'); // Extract info from data-* attributes
            var date_visite = button.data('datev');
            var pharma = button.data('pharma'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-body>form').attr('action','/phvisites/'+v_id);
            modal.find('.modal-title>span').text(date_visite + " - Pharmacie: " + pharma);

        })
    });
</script>
@endpush
