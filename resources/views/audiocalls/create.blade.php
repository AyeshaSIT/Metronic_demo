<x-default-layout>
    @section('title')
        Add Record
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('f-audiocalls.create') }}
    @endsection
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @if(session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
    <form  id="uploadForm"  action="{{ route('call-insights.f-audiocalls.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded mb-4">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
             @if($errors->has('name'))
             <small class="text-danger" id="name-error">{{ $errors->first('name') }}</small>
             @endif
        </div>
        <div class="form-group">
            <label for="language">Language:</label>
            <select id="language" class="form-control" name="language">
                <option value="" disabled selected>Select Language</option>
                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                <option value="ur" {{ old('language') == 'ur' ? 'selected' : '' }}>Urdu</option>
                <option value="hi" {{ old('language') == 'hi' ? 'selected' : '' }}>Hindi</option>
                <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Spanish</option>
                <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French</option>
                <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>German</option>
                <option value="it" {{ old('language') == 'it' ? 'selected' : '' }}>Italian</option>
            </select>
            @if($errors->has('language'))
            <small class="text-danger" id="lang-error">{{ $errors->first('language') }}</small>
            @endif
           
        </div>
           <div class="form-group">
            <label for="file">Audio File:</label>
            <input type="file" id='file' class="form-control" name="file">
             @if($errors->has('file'))
             <small class="text-danger" id="file-error">{{ $errors->first('file') }}</small>
             @endif
        </div>
        
        <button type="submit" class="btn btn-primary  mt-4 ml-4">Upload</button>
    </form>
    </div><div><br>
    
</div>
<script>
        $(document).ready(function() {
            // Function to hide error messages for valid input
            function validateField(input, errorMessageSelector) {
                if ($(input).val().trim() !== '') {
                    $(errorMessageSelector).hide();
                }
            }
            // field validation
            $('#name').on('input', function() {
                validateField(this, '#name-error');
            });
            $('#language').on('input', function() {
                 validateField(this, '#lang-error');
            });
             $('#file').on('change', function() {
                if ($(this).val() !== '') {
                    $('#file-error').hide();
                }
            });
        });
</script>
</x-default-layout>
