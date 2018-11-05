<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link href="{{ asset('/css/invoice.css') }}" rel="stylesheet">
</head>
<body>
<div class="wrapper">
 <!-- Header -->
 <header>
  <h1 class="header__title">LukaBapak e-commerce Invoice</h1>
 </header>
 <!-- section -->
 <section>
  <table class="u-full-width">
   <thead>
    <tr>
     <th class="table__label u-text-left">Description</th>
     <th class="table__label u-text-right">Amount</th>
    </tr>
   </thead>
   <tbody>
   @foreach($data as $d)   
    @foreach($d->detailTransactions as $f)
    <tr>
        <!-- {{var_dump($f->product->name)}} -->
        <td>{{$f->product->name}}</td>
        <td class="u-text-right"><strong>Rp. {{$f->product->price}}</strong></td>
    </tr>
    @endforeach
   <!-- {{var_dump($d->detailTransactions)}} -->
   @endforeach
    <!-- <tr>
     <td>Hosting Services / 24 months</td>
     <td class="u-text-right"><strong>$2,000.00</strong></td>
    </tr> -->
   </tbody>
  </table>
  <div class="u-cf">
   <div class="u-pull-right right-column right-column--mobile">
    <table class="u-full-width">
     <tbody>
      <tr class="u-no-border">
       <td class="table__label table__label--secondary table__label--large">Total</td>
       <td class="u-text-right"><span class="table__total">Rp. 11,200</span></td>
      </tr>
     </tbody>
    </table>
   </div>
  </div>
 </section>
</div>
</body>
</html>