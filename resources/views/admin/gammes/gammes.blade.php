@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
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
                        <div class="card-header">
                                <h5 class="mb-0">
                                        <i class="mdi mdi-account-badge-horizontal"></i>&nbsp; Gammes
                                        <a class="float-sm-right text-primary" data-toggle="modal" data-target="#gamme_ajout_Model" href="#" > Ajouter <i class="mdi mdi-plus"></i> </a>
                                </h5>
                        </div>

                                <div class="card-body">
                                        <div class="table-responsive">

                                                <table id="gammes" class="table table-bordered">
                                                        <thead>
                                                          <tr>
                                                                <th>Gamme</th>
                                                                <th>Action</th>

                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($liste_gammes as $gamme)
                                                                <tr>
                                                                    <td>{{$gamme->libelle}}</td>

                                                                      <td class="">
                                                                            <div class="dropdown">
                                                                                    <button class="btn btn-sm btn-secondary dropdown-toggle p-2" type="button" id="dropdown{{$gamme->gamme_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                                                    <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$gamme->gamme_id}}">
                                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#gamme_modif_Model" data-whatever="{{$gamme->gamme_id}}" data-user="{{$gamme->libelle}}"><i class="mdi mdi-pencil"></i>&nbsp;Modifier</a>
                                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#gamme_delet_Model" data-whatever="{{$gamme->gamme_id}}" data-user="{{$gamme->libelle}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a>

                                                                                    </div>
                                                                                </div>
                                                                      </td>
                                                                  </tr>
                                                            @endforeach
                                                        </tbody>
                                                </table>

                                        </div>
                                </div>

                        </div>

       </div>
</div>


@endsection

@section('modals')
    <!-- Ajout Modal -->
    <div class="modal fade" id="gamme_ajout_Model" tabindex="-1" role="dialog" aria-labelledby="gamme_ajout_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle Gamme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <form id="new-gamme" action="{{route('admin.gammes.store')}}" method="POST" id="ajoute_form">
                                    @csrf
                                    <div class="form-row pb-3">
                                        <div class="col">
                                            <label for="gamme_libelle">Gamme</label>
                                            <input type="Text" class="form-control" name="gamme_libelle" id="gamme_libelle">
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="document.getElementById('new-gamme').submit()" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>

    </div>



    <!-- Update Modal -->
    <div class="modal fade" id="gamme_modif_Model" tabindex="-1" role="dialog" aria-labelledby="gamme_modif_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Gamme : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <form id="modif-gamme" action="" method="POST" id="gamme_modif_Model">
                                    @csrf
                                    @method('put')
                                    <div class="form-row pb-3">
                                        <div class="col">
                                            <label for="gamme_libelle">Gamme</label>
                                            <input type="Text" class="form-control" name="gamme_libelle" id="gamme_libelle">
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="document.getElementById('modif-gamme').submit()" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>

    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="gamme_delet_Model" tabindex="-1" role="dialog" aria-labelledby="gamme_delet_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Gamme : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <h6>Etes-vous sûr que vous voulez supprimer cette Gamme ?</h6>
                            <form id="delet-gamme" action="" method="POST" id="gamme_delet_Model">
                                    @csrf
                                    @method('delete')
                                    <div class="form-row pb-3">
                                        <div class="col">

                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="document.getElementById('delet-gamme').submit()" class="btn btn-danger">Valider</button>
                    </div>
                </div>
            </div>

    </div>



@endsection




@push('scripts')


<script src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('js/gammes.js')}}"></script>
@endpush
