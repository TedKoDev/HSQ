<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>간단한 바닐라 SPA</title>
  </head>  
  <script>

  let shop_test = "shop";

  console.log("shop_test : "+shop_test);
  </script>
  <body>
    <nav class="navbar">
      <a href="/">HOME</a>
      <a href="/post/123">POST</a>
      <a href="/shop/">SHOP</a>
    </nav>
    <div id="app"></div>
    <script type="module" src="./main.js"></script>
  </body>
</html>