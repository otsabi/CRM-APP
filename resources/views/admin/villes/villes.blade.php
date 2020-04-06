@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
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
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-badge-horizontal"></i>&nbsp; Villes
                        <a class="float-sm-right text-primary" data-toggle="modal" data-target="#ajoutModel" href="#" > Nouvelle <i class="mdi mdi-plus"></i> </a>
                    </h5>
                </div>
                <div class="card-body">
                    <table id="villes" class="table table-bordered table-hover">
                        <thead>
                            <th>Ville</th>
                            <th>Secteur</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>

                        @foreach($villes as $ville)
                            <tr>
                                <td class="upper-case">{{$ville->libelle}}</td>
                                <td class="upper-case">{{$ville->secteur->libelle}}</td>
                                <td class="">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle p-2" type="button" id="dropdown{{$ville->ville_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                        <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$ville->ville_id}}">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#updateModel" data-whatever="{{$ville->ville_id}}" data-ville="{{$ville->libelle}}" data-secteur="{{$ville->secteur->secteur_id}}" ><i class="mdi mdi-pencil"></i>&nbsp;Modifier</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteModel" data-whatever="{{$ville->ville_id}}"  data-info="{{$ville->libelle. ' - Secteur : ' . $ville->secteur->libelle}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a>
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

@endsection

@section('modals')
    <!--   Modal -->
    <div class="modal show fade" id="ajoutModel" tabindex="-1" role="dialog" aria-labelledby="ajoutModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Nouvelle ville</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{route('admin.villes.store')}}" method="POST">
                        @csrf

                        <div class="form-row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <label for="libelle">Libelle</label>
                                <input type="input" class="form-control" name="libelle" id="libelle" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label for="sect">Secteur</label>
                                <select name="sect" id="sect" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    @foreach($secteurs as $secteur)
                                        <option value="{{$secteur->secteur_id}}">{{$secteur->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('add-form').submit()" type="submit" class="btn btn-primary">Créer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal show fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="updateModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Modifier Ville</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-form" action method="POST">
                        @csrf
                        @method('put')
                        <div class="form-row align-items-center ">
                            <div class="col-sm-12 col-md-6">
                                <label for="up_libelle">Libelle</label>
                                <input type="input" class="form-control" name="up_libelle" id="up_libelle" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label for="up_sect">Secteur</label>
                                <select name="up_sect" id="up_sect" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    @foreach($secteurs as $secteur)
                                        <option value="{{$secteur->secteur_id}}">{{$secteur->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('update-form').submit()" type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal show fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer Ville</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Etes-vous sûr que vous voulez supprimer cette ville ?</h6>
                    <p class="lead"></p>
                    <form id="del-form" action="" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="document.getElementById('del-form').submit()" type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

<script src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('js/villes.js')}}"></script>

@endpush
