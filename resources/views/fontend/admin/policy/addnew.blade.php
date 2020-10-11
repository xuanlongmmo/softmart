@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div class="sample">
            <h2>Add new post</h2>
            <form method="POST" action="{{ route('postaddnewpolicy') }}" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control">
                <label for="titleimage">Image title</label>
                <input type="file" name="titleimage" id='titleimage'>
                <div style="display: flex;margin-top: 15px" class="input-box">
                    <select name="id_category" style="margin-left: 44px;width: 515px;" class="form-control">
                        @foreach ($listcategory as $item)
                            <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->category_name }}</option>
                        @endforeach
                    </select>
                    <span style="color: red;margin-top: 8px;font-size: 14px;margin-left: 4px">*</span>
                </div>
              <textarea id="edit" name="content"></textarea>
              <button type="submit">Post</button>
            </form>
        </div>
    </div>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>

<!-- Initialize the editor. -->
<script>
  new FroalaEditor('#edit', {
    // Set the file upload URL.
    imageUploadURL: '/upload_image.php',

    imageUploadParams: {
      id: 'my_editor'
    }
  })
</script>
@endsection