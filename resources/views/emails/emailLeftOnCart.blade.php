<!DOCTYPE html>
<html>
<head>
    <title>LukaBapak</title>
</head>
 
<body>
<h2>Hai, {{$data['buyer']['name']}}! Ada Barang Tertinggal Di Keranjang Anda!</h2>

<ul>
@foreach($data['resource'] as $product)
    <li>{{$product->product->name}}</li>
@endforeach
</ul>

<p>Buruan lanjutkan pembayaran anda sebelum stok habis! Selamat Berbelanja di LukaBapak!</p>
</body>
 
</html>
 