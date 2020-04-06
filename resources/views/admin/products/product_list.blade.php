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

    <div class="col-sm-12">
        <div class="card">
                <div class="card-header">
                        <i class="mdi mdi-account-group"></i>&nbsp; Produits
                </div>
            <div class="card-body">
                <div class="table-responsive">

                        <table id="order-listing" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Libelle</th>
                                        <th>Prix</th>
                                        <th>Gamme</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                         @foreach($produits as $produit)
                                    <tr>
                                        <td>{{$produit->code_produit}}</td>
                                        <td>{{$produit->libelle}}</td>
                                        <td>{{$produit->prix}}</td>
                                        <td>
                                        @if(!$produit->gammes->isEmpty())
                                        <span class="badge badge-secondary">@foreach($produit->gammes as $gamme) {{ $gamme->libelle }} @endforeach</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle p-2" type="button" id="dropdown{{$produit->produit_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                <div class="dropdown-menu mt-0" aria-labelledby="dropdown{{$produit->produit_id}}">
                                                    <a class="dropdown-item" href="{{route('admin.products.edit',['product' => $produit->produit_id])}}"> <i class="mdi mdi-pencil"></i> Modifier</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#deleteModel" data-whatever="{{$produit->produit_id}}" data-produit="{{$produit->code_produit}} {{$produit->libelle}}"> <i class="mdi mdi-trash-can"></i> Supprimer</a>

                                                    {{-- <a class="dropdown-item" data-toggle="modal" data-target="#deleteModel" data-whatever="{{$produit->produit_id}}"  data-info="{{$produit->code_produit. ' - ' . $produit->libelle . ' - Gamme : ' . $produit->gamme->libelle}}"><i class="mdi mdi-trash-can"></i>&nbsp;Supprimer</a> --}}

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
    <!-- Modal -->
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Produits : <span></span> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Etes-vous sûr que vous voulez supprimer ce Produit ?</h6>
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
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('theme/js/data-table.js')}}"></script>
<script>
        $(document).ready(function () {

            $('#deleteModel').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) ;// Button that triggered the modal
                var produit_id = button.data('whatever'); // Extract info from data-* attributes
                var code_libelle = button.data('produit'); // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-body>form').attr('action','/admin/products/'+produit_id);
                modal.find('.modal-title>span').text(code_libelle);

            })
        });
    </script>
@endpush
