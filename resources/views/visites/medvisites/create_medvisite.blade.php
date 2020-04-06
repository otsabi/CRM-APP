@extends('layout.main')

@push('styles')
    <link rel="stylesheet" href="{{asset('theme/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('theme/vendors/select2/dist/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('theme/vendors/sweetalert2/dist/sweetalert2.min.css')}}">
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

        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp; Nouvelle visite médicale
                </div>

                <div class="card-body">
                    <form class="forms-sample" action="{{route('medvisites.store')}}" method="POST">
                        @csrf
                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6">
                                <label for="date_v">Date visite *:</label>
                                <input type="text" class="form-control" id="date_v" name="date_v" autocomplete="off" required>
                            </div>
                            <div class="col-sm-12 col-md-6 pl-md-5 mt-4 mt-sm-0">
                                <label for="plan">Etat visite *:</label>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="etat" id="plan" value="Plan"> Plan
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input  type="radio" class="form-check-input" name="etat" id="horsplan" value="Réalisé hors plan" checked> Réalisé hors plan
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6">
                                <label for="med">Médecin*</label>
                                <select class="form-control form-control-lg" id="med" name="med" required>

                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 pl-md-5 mt-4 mt-sm-0">
                                <label for="note">Note</label>
                                <textarea class="form-control form-control-lg" id="note" name="note" value placeholder="Ecrivez quelque chose"></textarea>
                            </div>

                        </div>

                        <div class="form-row pb-3">

                        </div>

                        <div class="form-row pb-3">
                            <div class="col">
                                <button id="newproduct" class="btn btn-sm btn-secondary float-right" type="button"> <i class="mdi mdi-plus"></i> Produit présenté</button>
                            </div>
                        </div>

                        <div class="form-row pb-3">

                            <div class="col table-responsive">
                                <table class="table table-bordered" id="products">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Feedback</th>
                                            <th>Nombre Echantillon</th>
                                            <th>Supprimer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="product[]" class="form-control form-control-sm" required>
                                                    <option value=""></option>
                                                    @foreach($produits as $produit)
                                                        <option value="{{$produit->produit_id}}">{{$produit->code_produit}}</option>
                                                        @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="feedback[]" class="form-control form-control-sm" required>
                                                    <option value=""></option>
                                                    @foreach($feedback as $fb)
                                                        <option value="{{$fb->feedback_id}}">{{$fb->libelle}}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="ech[]" class="form-control form-control-sm" required>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </td>

                                            <td>
                                                <button type="button" class="delproduct btn btn-sm btn-danger"><i class="mdi mdi-delete"></i>Supprimer</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <hr />

                        <div class="form-row">
                           <div class="col">
                                <button class="btn btn-success float-right" type="submit">Créer visite</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
    <script src="{{asset('theme/vendors/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('theme/vendors/select2/dist/js/select2.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/searchmed.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#date_v').datepicker({
                todayBtn: "linked",
                todayHighlight: true,
                autoclose:"true",
                startDate:"+1",
                language: "fr"
            });

            $('#newproduct').on('click',function (event) {
                event.preventDefault();
                var product = '<td><select name="product[]" class="form-control form-control-sm" required><option value=""></option>@foreach($produits as $produit)<option value="{{$produit->produit_id}}">{{$produit->code_produit}}</option>@endforeach</select></td>';
                var feedback = '<td><select name="feedback[]" class="form-control form-control-sm" required><option value=""></option>@foreach($feedback as $fb)<option value="{{$fb->feedback_id}}">{{$fb->libelle}}</option>@endforeach</select></td>';
                var ech = '<td><select name="ech[]" class="form-control form-control-sm" required><option value="0">0</option><option value="1">1</option><option value="2">2</option></select></td>';
                var btn_delete = '<td> <button type="button" class="delproduct btn btn-sm btn-danger"> <i class="mdi mdi-delete"></i> Supprimer </button> </td>';
                var ligne = '<tr>' + product + feedback + ech + btn_delete + '</tr>';
                $('#products>tbody').append(ligne);
             });

            $(document).on('click','.delproduct',function (event) {
                event.preventDefault();
                $(this).closest('tr').remove();
            });

            $("#horsplan").on('change',function () {
                $('#newproduct').removeAttr('disabled');
                $('#newproduct').trigger('click');
            });

            $('#plan').on('click',function (event) {
                //event.preventDefault();
                Swal.fire({
                    title: 'Attention !',
                    text: 'Pour plannifier cette visite, nous devons vider le tableau des produits présentés !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Je confirme !',
                }).then(function(result){
                    if(result.value){
                        $("#plan").prop('checked',true).trigger('change');
                        $('#newproduct').attr('disabled',true);
                        $('#products>tbody>tr').remove();
                    }else if(result.dismiss === Swal.DismissReason.cancel){
                        $("#horsplan").prop('checked',true);
                        $('#newproduct').removeAttr('disabled');
                    }
                });
            });


        });
    </script>
    @endpush
