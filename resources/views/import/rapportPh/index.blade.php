@extends('layout.main')

@section('content')

    <div class="row">

        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('import_rapportPh') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title d-flex">IMPORT FILES
                            <small class="ml-auto align-self-end">
                            <a href="dropify.html" class="font-weight-light" target="_blank"></a>
                            </small>
                        </h4>
                        <input  type="file" name="import_file[]" class="dropify" multiple  />
                        <span class="input-group-append pt-3 float-right">
                            <button class="file-upload-browse btn btn-primary " type="submit">Upload</button>
                          </span>

                    </form>

                </div>
            </div>





        </div>
    </div>




    @endsection
