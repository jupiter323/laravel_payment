<!DOCTYPE html>
<html>
<head>
	<title>PayUMoney Process</title>
	<script>
	var hash = "{{$hash}}";
	function submitPayuForm() {
	  if(hash == '') {
	    return;
	  }
	  var payuForm = document.forms.payuForm;
	  payuForm.submit();
	}
	</script>
</head>
<body onload="submitPayuForm()">

<p style="margin-top:100px;text-align:center;font-size:16px;">Please wait while we are redirecting you to secure transaction...</p>
    <form action="{{$action}}" method="post" name="payuForm" style="visibility:hidden;">
      <input type="hidden" name="key" value="{{(empty($posted['key'])) ? '' : $posted['key']}}" />
      <input type="hidden" name="hash" value="{{(empty($posted['hash'])) ? '' : $posted['hash']}}"/>
      <input type="hidden" name="txnid" value="{{(empty($posted['txnid'])) ? '' : $posted['txnid']}}" />
      <table>
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount" value="{{(empty($posted['amount'])) ? '' : $posted['amount']}}" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="{{(empty($posted['firstname'])) ? '' : $posted['firstname']}}" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="{{(empty($posted['email'])) ? '' : $posted['email']}}" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="{{(empty($posted['phone'])) ? '' : $posted['phone']}}" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo">{{(empty($posted['productinfo'])) ? '' : $posted['productinfo']}}</textarea></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="{{(empty($posted['surl'])) ? '' : $posted['surl']}}" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="{{(empty($posted['furl'])) ? '' : $posted['furl']}}" size="64" /></td>
        </tr>
        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>
        <tr>
          <td colspan="3">
          <input type="text" name="address1" value="{{(empty($posted['address1'])) ? '' : $posted['address1']}}"/>
          <input type="text" name="city" value="{{(empty($posted['city'])) ? '' : $posted['city']}}"/>
          <input type="text" name="state" value="{{(empty($posted['state'])) ? '' : $posted['state']}}"/>
          <input type="text" name="zipcode" value="{{(empty($posted['zipcode'])) ? '' : $posted['zipcode']}}"/>
          <input type="text" name="country" value="{{(empty($posted['country'])) ? '' : $posted['country']}}"/>
          <input type="text" name="udf1" value="{{(empty($posted['udf1'])) ? '' : $posted['udf1']}}"/></td>
          <input type="text" name="udf2" value="{{(empty($posted['udf2'])) ? '' : $posted['udf2']}}"/></td>
        </tr>
        <tr>
          @if(!$hash)
            <td colspan="4"><input type="submit" value="Submit" /></td>
          @endif
        </tr>
      </table>
    </form>
  </body>
</html>
</body>
</html>