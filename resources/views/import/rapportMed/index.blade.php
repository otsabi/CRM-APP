@extends('layout.main')

@section('content')

    <div class="row">

        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    File(s) uploaded successfully -  {{session('status')}}
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
                <div class="card-body">
                    <form action="{{ route('import_rapportMed') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title d-flex">IMPORT FILES
                            <small class="ml-auto align-self-end">
                            <a href="dropify.html" class="font-weight-light" target="_blank"></a>
                            </small>

                        </h4>

                        <input  type="file" name="import_file[]" class="dropify" multiple  />

                        <span class="input-group-append pt-3 float-right">
                            <button id="uploadbtn" class="file-upload-browse btn btn-primary"  type="submit">Upload</button>
                          </span>

                    </form>

                    <div class="col-sm-12">
                        <div class="text-center" id="spinners"style="display: none;">
                                    <div class="spinner-grow "  role="status" style="margin-top: 40px;width: 4rem;height: 4rem;color: rgb(29, 83, 140);">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-success"  role="status" style="margin-top: 40px;width: 4rem;height: 4rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-secondary"  role="status" style="margin-top: 40px;width: 4rem;height: 4rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-danger"  role="status" style="margin-top: 40px;width: 4rem;height: 4rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-warning" role="status" style="margin-top: 40px;width: 4rem;height: 4rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-dark"  role="status" style="margin-top: 40px;width: 4rem;height: 4rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                        </div>

                    </div>




                </div>
            </div>





        </div>
    </div>




    @endsection
    @push('scripts')
    <script>
                $(document).ready(function(){
                        $("#uploadbtn").click(function(){
                                  $("#spinners").show();
                                                     });
                });


    </script>


    @endpush
