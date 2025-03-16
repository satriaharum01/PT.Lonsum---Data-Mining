
    
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-free-6/css/all.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <script>
        const basePath = "{{asset('assets/js/') }}";
    </script>
    <link  rel="stylesheet"  href="{{asset('assets/css/datatables.min.css')}}"/>
    <link  rel="stylesheet"  href="{{asset('assets/css/lightbox.min.css')}}"/>
    <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet" />
     <!-- SweetAlert 2 -->
     <script src="{{ asset( 'assets/dist/sweetalert2/sweetalert2.all.min.js')}}">
    </script>
    <link rel="{{ asset( 'assets/dist/sweetalert2/sweetalert2.min.css')}}">
    <style>
        .custom-col {
            flex: 0 0 20%;
            max-width: 20%;
        }
        .cover__anime{
            max-height: 320px;
            width: 100%;
            height: 100%;
        }
        .image-container {
            position: relative;
            display: inline-block;
            width: 100%;
            height: auto;
        }

        .image-container img {
            max-height: 320px;
            width: 100%;
            height: auto;
        }
        
        .image-container:hover .overlay-full {
          opacity: 1;
        }
        
        .overlay-full {
            position: absolute;
            opacity:0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Optional dark overlay */
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            transition: 0.5s;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5); /* Optional dark overlay */
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .overlay .episode {
            background-color: #333;
            padding: 5px 10px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .overlay .btn {
            font-weight: bold;
            font-size: auto;
        }
        .overlay .date {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .overlay .day {
            background-color: #007bff;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        .overlay .title {
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: auto;
        }
    </style>