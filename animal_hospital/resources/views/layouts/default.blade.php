<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="/animal_hospital/public/css/styles.css">
  @yield('script')
</head>
<body>
  <header>
    <div class="header_top">
      <a class="svg_header_logo" href="{{url('/')}}"></a>
      <p>〇〇〇動物病院</p>
    </div>
    <div class="clearfix vets_number">
      <p><span class="font_bold">医院TEL</span><a href="000-0000-0000">000-0000-0000</a></p>
    </div>
    <div class="purpose">
      <p>@yield('heading')</p>
    </div>
  </header>
  @yield('content')


</body>
</html>