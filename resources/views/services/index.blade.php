@extends('layouts.app')

@section('content')

<div>

    <strong style="font-size:2em; display: block; line-height: 1.5;">
        Service Categories
    </strong>
    <br>

    <div class="row mb-3">
        <div class="col-lg-12 margin-tb">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('services.create') }}" class="btn btn-success" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';"> 
                    <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                    Create New Service
                </a>
                <form action="{{ route('services.index') }}" method="GET">
                    <div class="input-group" style="width: 300px;">
                      <input type="text" class="form-control" placeholder="Search..." name="q" id="search" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>
      </div>


    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div id="search-results" class="row"></div>

    <div id="service-cards" class="row">
        @foreach ($services as $index => $service)
        <div class="col-md-4">
            <div class="card mb-4" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div onclick="window.location='{{ route('services.show', $service->id) }}'" style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $service->files) }}" class="card-img-top" alt="service" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h2 class="card-title">{{ $service->name }}</h2>
                        <p class="card-text">{{ $service->description }}</p>
                    </div>
                </div>
                <div class="card-body" style="display: flex; gap: 10px; justify-content: start;">
                    <a href="{{ route('services.edit', $service->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        <span class="material-symbols-outlined">stylus</span>
                        Edit
                    </a>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                            <span class="material-symbols-outlined">delete</span>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
     </div>
    
  <div>
    {{ $services->links() }}
  </div>

      
</div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('#search').on('keyup',function() {
        var query = $(this).val();
        if(query !== '') {
            $('#service-cards').hide();
            $.ajax({
                url: "{{ route('services.index') }}",
                type: "GET",
                data: {'query': query},
                success: function(data) {
                    $('#search-results').empty().html(data);
                    $('#search-results').show();
                }
            });
        } else {
            $('#service-cards').show();
            $('#search-results').empty();
        }
});

    </script>
@endpush
