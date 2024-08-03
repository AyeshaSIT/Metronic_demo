<x-default-layout>
    @section('title')
        View Record
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('f-audiocalls.index') }}
    @endsection
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if(count($audiocalls)>0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Audio File</th>
                <th>Language</th>

                <th>Delete Record</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($audiocalls as $audiocall)
                <tr>
                    <td>{{ $audiocall['name'] }}</td>
                    <td>
                        <audio controls>
                            <source src="{{ asset('storage/'.$audiocall['file_path']) }}" type="audio/mpeg">
                            Your browser does not support the audio element.</audio>
                    </td>
                    <td>{{ $audiocall['language'] }}</td>
                    <td><form method="POST" action="{{route('call-insights.f-audiocalls.destroy',$audiocall['id'])}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm mb-3" type="submit">Delete</button>
                      </form>   </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   
    {{count($audiocalls). ' Record found' }}
    
    @else{{count($audiocalls). ' Record found'}}@endif
    </div>  
    </div>
</div>
</x-default-layout>