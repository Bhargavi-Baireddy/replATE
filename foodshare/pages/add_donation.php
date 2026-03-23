<!DOCTYPE html>
<html>
<body>

<h2>Add Donation</h2>

<form method="POST" action="/foodshare/backend/api/donor.php">
<input name="food_type" placeholder="Food"><br>
<input name="quantity" type="number"><br>

<input type="hidden" name="lat" id="lat">
<input type="hidden" name="lng" id="lng">

<input type="datetime-local" name="expiry"><br>

<button>Submit</button>
</form>

<script>
navigator.geolocation.getCurrentPosition(pos=>{
document.getElementById("lat").value = pos.coords.latitude;
document.getElementById("lng").value = pos.coords.longitude;
});
</script>

</body>
</html>