@extends('layout.main')

@section('content')

    <div class="row">

        <div class="col-sm-12 grid-margin stretch-card">

        <form action="{{ route('import_rapportPh') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="exampleFormControlFile1">File input</label>
              <input type="file" name="import_file[]" class="form-control-file" multiple>
              <input type="submit" value="Import" class="form-control-file">
            </div>
        </form>





        </div>
    </div>




    @endsection
