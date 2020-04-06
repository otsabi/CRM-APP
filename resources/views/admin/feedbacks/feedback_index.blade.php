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
                                        <i class="mdi mdi-account-badge-horizontal"></i>&nbsp; Feedbacks
                                        <a class="float-sm-right text-primary" data-toggle="modal" data-target="#feedback_ajout_Model" href="#" > Ajouter <i class="mdi mdi-plus"></i> </a>
                                </h5>
                        </div>

                                <div class="card-body">
                                        <div class="table-responsive">

                                                <table id="feedbacks" class="table table-bordered">
                                                        <thead>
                                                          <tr>
                                                                <th>Feedbacks</th>
                                                                <th>Action</th>

                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($liste_feedbacks as $feedback)
                                                                <tr>
                                                                    <td>{{$feedback->libelle}}</td>

                                                                      <td class="">
                                                                            <div class="dropdown">
                                                                                    <button class="btn btn-sm btn-secondary dropdown-toggle p-2" type="button" id="dropdown{{$feedback->feedback_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                                                    <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$feedback->feedback_id}}">
                                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#feedback_modif_Model" data-whatever="{{$feedback->feedback_id}}" data-user="{{$feedback->libelle}}"><i class="mdi mdi-pencil"></i>&nbsp;Modifier</a>
                                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#feedback_delet_Model" data-whatever="{{$feedback->feedback_id}}" data-user="{{$feedback->libelle}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a>

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
    <div class="modal fade" id="feedback_ajout_Model" tabindex="-1" role="dialog" aria-labelledby="feedback_ajout_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <form id="new-feedback" action="{{route('admin.feedbacks.store')}}" method="POST" id="ajoute_form">
                                    @csrf
                                    <div class="form-row pb-3">
                                        <div class="col">
                                            <label for="feedback_libelle">feedback</label>
                                            <input type="Text" class="form-control" name="feedback_libelle" id="feedback_libelle">
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="document.getElementById('new-feedback').submit()" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>

    </div>



    <!-- Update Modal -->
    <div class="modal fade" id="feedback_modif_Model" tabindex="-1" role="dialog" aria-labelledby="feedback_modif_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">feedback : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <form id="modif-feedback" action="" method="POST" id="feedback_modif_Model">
                                    @csrf
                                    @method('put')
                                    <div class="form-row pb-3">
                                        <div class="col">
                                            <label for="feedback_libelle">feedback</label>
                                            <input type="Text" class="form-control" name="feedback_libelle" id="feedback_libelle">
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="document.getElementById('modif-feedback').submit()" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>

    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="feedback_delet_Model" tabindex="-1" role="dialog" aria-labelledby="feedback_delet_Model" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">feedback : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <h6>Etes-vous sûr que vous voulez supprimer cette feedback ?</h6>
                            <form id="delet-feedback" action="" method="POST" id="feedback_delet_Model">
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
                            <button type="button" onclick="document.getElementById('delet-feedback').submit()" class="btn btn-danger">Valider</button>
                    </div>
                </div>
            </div>

    </div>



@endsection




@push('scripts')


<script src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('js/feedbacks.js')}}"></script>
@endpush
