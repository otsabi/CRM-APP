@extends('layout.main')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
@endpush

<div class="row">
    <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                {{session('status')}}
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

<div class="col-12 grid-margin stretch-card">

    <div class="card">
        <div class="card-header">
                <h5 class="mb-0">
                <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp; Secteur
                <a class="float-sm-right text-primary" data-toggle="modal" data-target="#ajoutModel" href="#" > Nouveau <i class="mdi mdi-plus"></i> </a>
                </h5>




        </div>
      <div class="card-body">
       <div class="table-responsive">
           <table id="list_secteur" class="table table-bordered table-hover">
               <thead>
                   <tr>
                        <th>ID</th>
                        <th>Libelle</th>
                        <th>Actions</th>
                   </tr>

               </thead>
               <tbody>
                   @foreach ($list_secteur as $secteur)
                    <tr>
                    <td>{{$secteur->secteur_id}}</td>
                    <td>{{$secteur->libelle}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle p-2" type="button" id="dropdown{{$secteur->secteur_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$secteur->secteur_id}}">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#updateModel" data-whatever="{{$secteur->secteur_id}}" data-secteur="{{$secteur->libelle}}" ><i class="mdi mdi-pencil"></i>&nbsp;Modifier</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteModel" data-whatever="{{$secteur->secteur_id}}"  data-info="{{$secteur->libelle}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a>

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
<div class="modal show fade" id="ajoutModel" tabindex="-1" role="dialog" aria-labelledby="ajoutModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Nouveau secteur</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{route('admin.secteurs.store')}}" method="POST">
                        @csrf

                        <div class="form-row align-items-center">
                            <div class="col-sm-12 col-md-12">
                                <label for="libelle">Libelle</label>
                                <input type="input" class="form-control" name="libelle" id="libelle" required>
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


    <div class="modal show fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="updateModel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Modifier Secteur</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="update-form" action method="POST">
                            @csrf
                            @method('put')
                            <div class="form-row align-items-center ">
                                <div class="col-sm-12 col-md-12">
                                    <label for="up_libelle">Libelle</label>
                                    <input type="input" class="form-control" name="up_libelle" id="up_libelle" required>
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





        <div class="modal show fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Supprimer Secteur</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6>Etes-vous sûr que vous voulez supprimer ce secteur ?</h6>
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
<script type="text/javascript" src="{{asset('js/secteurs.js')}}"></script>

@endpush
