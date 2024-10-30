@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>

<script>
tinymce.init({
    selector: 'textarea#description',
    menubar: false,
    plugins: 'code table lists image',
    toolbar: 'undo redo | blocks | bold italic |',
});
</script>
@endpush

@endsection