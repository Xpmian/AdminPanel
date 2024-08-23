@extends('Layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kullanici-ekleme-formu.css') }}">
@endsection

@section('content')
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

    <div class="form-container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Ürün : {{$product->productTitle}}</h5>
                        <hr>
                        <form action="{{ route('products.image.upload', $product->slug) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Görseli Yükle <span class="warning">(En fazla 20 Görsel)</span></label>
                                <hr>
                                <input type="file" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple class="form-control">
                            </div>

                            <div class="mb-3">
                               <button type="submit" class="btn btn-primary" style="background-color: #284b63;">Yükle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                @foreach ($productImages as $productImage)
                    <img src="{{asset($productImage->image)}}" style="width: 100px; height: 100px" alt="img">

                    <a href="{{route('products.image.delete',$productImage->id)}}">Sil</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const file = this.files[0];
                    const previewImage = document.querySelector(`#product-picture-${this.id.split('-')[2]}`);

                    if (file) {
                        previewImage.src = URL.createObjectURL(file);

                        previewImage.onload = function() {
                            URL.revokeObjectURL(previewImage.src);
                        }
                    }
                });
            });
        });
    </script>
@endsection
