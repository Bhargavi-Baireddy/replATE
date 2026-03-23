<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form id="registerForm">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role">
        <option value="donor">Donor</option>
        <option value="ngo">NGO</option>
        <option value="volunteer">Volunteer</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

<script>
document.getElementById("registerForm").addEventListener("submit", async function(e){
    e.preventDefault();

    let formData = new FormData(this);
    formData.append("action","register");

    let res = await fetch("/foodshare/backend/api/auth.php",{
        method:"POST",
        body:formData
    });

    let data = await res.json();

    if(data.status === "success"){
        alert("Registered successfully");
        window.location.href = "/foodshare/pages/login.php";
    } else {
        alert(data.message);
    }
});
</script>

</body>
</html>