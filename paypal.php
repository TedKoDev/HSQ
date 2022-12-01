
<!doctype html>

<html>

 <body> 

 <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

 <input type="hidden" name="cmd" value="_xclick">

 <input type="hidden" name="business" value="seller001@test.com">

 상품명 : <input type="text" name="item_name" value="Content Name">

 상품코드 : <input type="text" name="item_number" value="0001">

 통화 : <input type="text" name="currency_code" value="USD">

 가격 : <input type="text" name="amount" value="10">

 <input type="hidden" name="custom" value="회원번호">

 <input type="hidden" name="charset" value="UTF-8">

 <input type="image" name="submit" border="0" 

src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" 

alt="PayPal - The safer, easier way to pay online">

 </form>

 </body>

</html>