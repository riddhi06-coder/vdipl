<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
</head>

<body>
    @include('components.frontend.header')


        <div class="about-image-container">
            <img src="{{ asset('uploads/assets/' . $assets->banner_image) }}" alt="Background Image">
            <div class="text">
                <h1 >{{ $assets->banner_title }}</h1>
                <p class="breadcrumb" >
                    <a href="{{ route('home.page') }}" >Home</a>  &nbsp;  &gt; {{ $assets->banner_title }}
                </p>
            </div>
        </div>
    

        <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
            <h2>{{ $assets->section_title }} </h2>
        </div>
  
        <div class="table-container">
            <table class="my-table">
                <thead>
                    <tr>
                        @if($assets && $assets->header_data)
                            @php
                                $headers = json_decode($assets->header_data, true);
                            @endphp

                            @foreach($headers as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($assets && $assets->assets_types && $assets->no_assets_list)
                        @php
                            $assetTypes = json_decode($assets->assets_types, true);
                            $noAssets = json_decode($assets->no_assets_list, true);
                        @endphp

                        @foreach($assetTypes as $index => $type)
                            <tr>
                                <td>{{ $type }}</td>
                                <td>{{ $noAssets[$index] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">No asset data available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>


    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')

    
    <script>
        $(".table-basic").freezeTable({
        columnNum: 0,           
        scrollable: true,
        freezeHead: true,        
        container: ".table-wrap", 
        zIndex: 100
        });
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FreezeTable Plugin -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/freeze-table@1.0.4/dist/freeze-table.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/freeze-table@1.0.4/dist/freeze-table.min.js"></script>
  
</body>
</html>
